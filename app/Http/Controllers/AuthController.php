<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email"=> "required",
            "password"=>"required",
            "confirm_password" => "required|same:password"
        ]);

        if($validator->fails() ){
            //return sendError("Error validation", $validator->errors());
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;

        //return $this->sendResponse($success,"Sikeres Regisztráció");
    }
}
