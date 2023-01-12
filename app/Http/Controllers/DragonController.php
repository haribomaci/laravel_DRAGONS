<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DragonController extends Controller
{
    public function store(Request $request){
        $colorReq =$request->color;
        $colorid = Color::first($colorReq)->get();
        print_r($color);
    }
}
