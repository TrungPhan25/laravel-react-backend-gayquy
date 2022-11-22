<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class SliderController extends Controller
{
    public function index(){
        $sliders=Slider::all();
        return response()->json([
            'status'=>200,
            'sliders'=>$sliders,
        ]);
    }


    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'title'=>'required|max:191',
            'description'=>'required',
            'color'=>'required',
            'img'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $slider= new Slider;
            $slider->title=$request->input('title');
            $slider->description=$request->input('description');
            if($request->hasFile('img')){
                $file= $request->file('img');
                $ext= $file->getClientOriginalExtension();
                $filename=time().'slider.'.$ext;
                $file->move('uploads/slider/',$filename);
                $slider->img='uploads/slider/'.$filename;
            }
            $slider->path="/catalog/ao-thun-dinosaur-01";
            $slider->color=$request->input('color');
            $slider->save();
            return response()->json([
                'status'=>200,
                'massage'=>'Slider Added Successfully',
            ]);
        }
    }

    public function edit($id){
        $slider=Slider::find($id);
        if($slider){
            return response()->json([
                'status'=>200,
                'slider'=>$slider,
                'img'=>Slider::find($id)->select('img')->first(),
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Slider Found',
            ]);
        }
    }

    public function update($id,Request $request){
        $validator= Validator::make($request->all(),[
            'title'=>'required|max:191',
            'description'=>'required',
            'color'=>'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $slider= Slider::find($id);
            if($slider){
                $slider->title=$request->input('title');
                $slider->description=$request->input('description');
                if($request->hasFile('img')){
                    $pat=$slider->img;
                    if(File::exists($pat)){
                        File::delete($pat);
                    }
                    $file= $request->file('img');
                    $ext= $file->getClientOriginalExtension();
                    $filename=time().'slider.'.$ext;
                    $file->move('uploads/slider/',$filename);
                    $slider->img='uploads/slider/'.$filename;
                }
                $slider->path="/catalog/ao-thun-dinosaur-01";
                $slider->color=$request->input('color');
                $slider->save();
                return response()->json([
                    'status'=>200,
                    'massage'=>'Slider Added Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'massage'=>'Slider Not Found'
                ]);
            }

        }
    }

}
