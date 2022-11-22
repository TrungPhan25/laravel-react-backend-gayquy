<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(){
        $blogs=Blog::all();
        return response()->json([
            'status'=>200,
            'blogs'=>$blogs,
        ]);
    }

    public function edit($id){
        $blog=Blog::find($id);
        if($blog){
            return response()->json([
                'status'=>200,
                'blog'=>$blog,


            ]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>'Dont find',
            ]);
        }
    }

    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'title'=>'required|max:191',
            'title_blog'=>'required',
            'description'=>'required',
            'image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
            'slider'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else {
            $blog= new Blog();
            $blog->title=$request->input('title');
            if($request->hasFile('image')){
                $file= $request->file('image');
                $ext= $file->getClientOriginalExtension();
                $filename=time().'blog.'.$ext;
                $file->move('uploads/blog/',$filename);
                $blog->image='uploads/blog/'.$filename;
            }
            if($request->hasFile('slider')){
                $file= $request->file('slider');
                $ext= $file->getClientOriginalExtension();
                $filename=time().'blog1.'.$ext;
                $file->move('uploads/blog/',$filename);
                $blog->slider='uploads/blog/'.$filename;
            }
            $blog->title_blog=$request->input('title_blog');
            $blog->description=$request->input('description');
            $blog->status=0;
            $blog->save();
            return response()->json([
                'status'=>200,
                'massage'=>$request->input('title_blog'),
            ]);
        }
    }

    public function update($id,Request $request){
        $validator= Validator::make($request->all(),[
            'title'=>'required|max:191',
            'title_blog'=>'required',
            'description'=>'required',

        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $blog= Blog::find($id);
            if($blog){
                $blog->title=$request->input('title');
                if($request->hasFile('image')){
                    $pat=$blog->image;
                    if(File::exists($pat)){
                        File::delete($pat);
                    }
                    $file= $request->file('image');
                    $ext= $file->getClientOriginalExtension();
                    $filename=time().'blog.'.$ext;
                    $file->move('uploads/blog/',$filename);
                    $blog->image='uploads/blog/'.$filename;
                }
                if($request->hasFile('slider')){
                    $pat=$blog->slider;
                    if(File::exists($pat)){
                        File::delete($pat);
                    }
                    $file= $request->file('slider');
                    $ext= $file->getClientOriginalExtension();
                    $filename=time().'blog1.'.$ext;
                    $file->move('uploads/blog/',$filename);
                    $blog->slider='uploads/blog/'.$filename;
                }
                $blog->title_blog=$request->input('title_blog');
                $blog->description=$request->input('description');
                $blog->status=0;
                $blog->save();
                return response()->json([
                    'status'=>200,
                    'massage'=>'Thành công'
                ]);
            
            }else{
                return response()->json([
                    'status'=>404,
                    'massage'=>'Blog Not Found'
                ]);
            }
        }
    }
}
