<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'title'=>'required|max:191',
            'description'=>'required',
            'color'=>'required',
            'img'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }
}
