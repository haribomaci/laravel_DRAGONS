<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function signIn(Request $request){
        if(Auth::attempt([ "email"=>$request->email, "password"=>$request->password])){
            $authUser = Auth::user();
            $success["token"]=$authUser->createToken("MyAuthApp")->plainTextToken;
            $success["name"]=$authUser->name;

            return $this->sendResponse($success, "Sikeres bejelentkezés");
            print_r("siker");
        }
        else{
            return $this->sendError("Unathorized.".["error"=>"hibás adatok"]);
            print_r("hibas");
        }
    }
    public function signUp(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email"=> "required",
            "password"=>"required",
            "confirm_password" => "required|same:password"
        ]);

        if($validator->fails() ){
            return sendError("Error validation", $validator->errors());
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;

        return $this->sendResponse($success,"Sikeres Regisztráció");
    }
    public function logOut(Request $request){
        //érvénytelenítem a tokent
        auth("sanctum")->user()->currentAccessToken()->delete();

        return response()->json("sikeres kijelentkezés");
    }

}
