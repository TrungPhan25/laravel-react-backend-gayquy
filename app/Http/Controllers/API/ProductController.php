<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'category_id'=>'required',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
            'brand'=>'required',
            'selling_price'=>'required',
            'original_price'=>'required',
            'qty'=>'required',
            'image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else {
            $product = new Product;
            $product->category_id=$request->input('category_id');
            $product->slug=$request->input('slug');
            $product->name=$request->input('name');
            $product->description=$request->input('description');

            $product->brand=$request->input('brand');
            $product->selling_price=$request->input('selling_price');
            $product->original_price=$request->input('original_price');
            $product->qty=$request->input('qty');

            if($request->hasFile('image')){
//                $file = Input::file('image');
                $file= $request->file('image');
                $ext= $file->getClientOriginalExtension();
                $filename=time().'.'.$ext;
                $file->move('uploads/product/',$filename);
                $product->image='uploads/product/'.$filename;
            }
            $product->featured=$request->input('featured') == true ? '1' : 0;
            $product->popular=$request->input('popular') == true ? '1' : 0;
            $product->status=$request->input('status') == true ? '1' : 0;

            $product->save();
            return response()->json([
                'status'=>200,
                'massage'=>'Product Added Successfully'
            ]);
        }
    }
}
