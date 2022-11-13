<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'categorySlug'=>'required',
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'selling_price'=>'required',
            'price'=>'required',
            'qty'=>'required',
            'image01'=>'required|image|mimes:jpg,jpeg,png|max:2048',
            'image02'=>'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
//                'size'=>json_decode($request->input('size'))
            ]);
        }else {
            $product = new Product;
            $product->categorySlug=$request->input('categorySlug');
            $product->slug=$request->input('slug');
            $product->title=$request->input('title');
            $product->description=$request->input('description');

            $product->selling_price=$request->input('selling_price');
            $product->price=$request->input('price');
            $product->qty=$request->input('qty');

            if($request->hasFile('image01')){
//                $file = Input::file('image');
                $file= $request->file('image01');
                $ext= $file->getClientOriginalExtension();
                $filename=time().'.'.$ext;
                $file->move('uploads/product/',$filename);
                $product->image01='uploads/product/'.$filename;
            }

            if($request->hasFile('image02')){
//                $file1 = Input::file('image');
                $file1= $request->file('image02');
                $ext1= $file1->getClientOriginalExtension();
                $filename1=time().'2.'.$ext1;
                $file1->move('uploads/product/',$filename1);
                $product->image02='uploads/product/'.$filename1;
            }


            $product->size=json_decode($request->input('size'));
//            $product->size=($request->input('size'));

            $product->save();
            return response()->json([
                'status'=>200,
                'massage'=>'Product Added Successfully',
            ]);
        }
    }

    public function index(){
        $products=Product::all();
//        $products= DB::table('products')->select('size')->get()->toArray();
//        $products=json_code($products);
        return response()->json([
            'status'=>200,
            'products'=>$products,
        ]);
    }

    public function edit($id){
        $product=Product::find($id);

        if ($product){
            return response()->json([
                'status'=>200,
                'product'=>$product,
                'size'=>Product::find($id)->select('size')->first(),
                'image01'=>Product::find($id)->select('image01')->first(),
                'image02'=>Product::find($id)->select('image02')->first(),

            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Product Found',
            ]);
        }
    }

    public function update($id,Request $request){
        $validator= Validator::make($request->all(),[
            'categorySlug'=>'required',
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'selling_price'=>'required',
            'price'=>'required',
            'qty'=>'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else {
            $product = Product::find($id);
            if($product)
            {
                    $product->categorySlug=$request->input('categorySlug');
                    $product->slug=$request->input('slug');
                    $product->title=$request->input('title');
                    $product->description=$request->input('description');
                    $product->selling_price=$request->input('selling_price');
                    $product->price=$request->input('price');
                    $product->qty=$request->input('qty');

                    if($request->hasFile('image01')){
                        $path=$product->image01;
                        if(File::exists($path)){
                            File::delete($path);
                        }
                        $file= $request->file('image01');
                        $ext= $file->getClientOriginalExtension();
                        $filename=time().'.'.$ext;
                        $file->move('uploads/product/',$filename);
                        $product->image01='uploads/product/'.$filename;
                    }

                    if($request->hasFile('image02')){
                        $path1=$product->image02;
                        if(File::exists($path1)){
                            File::delete($path1);
                        }
                        $file1= $request->file('image02');
                        $ext1= $file1->getClientOriginalExtension();
                        $filename1=time().'2.'.$ext1;
                        $file1->move('uploads/product/',$filename1);
                        $product->image02='uploads/product/'.$filename1;
                    }

                $product->size=json_decode($request->input('size'));

                $product->save();
                    return response()->json([
                        'status'=>200,
                        'massage'=>'Product Update Successfully'
                    ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'massage'=>'Product Not Found'
                ]);
            }
        }
    }
}
