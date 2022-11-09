<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'categorySlug'=>'required|max:191',
            'display'=>'required|max:191',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $CT=IdGenerator::generate([
                'table' => 'categories',
                'field' => 'id_category',
                'length' => 10,
                'prefix' => 'CT']);
            $category = new Category;
            $category->id_category=$CT;
            $category->categorySlug=$request->input('categorySlug');
            $category->display=$request->input('display');
            $category->description=$request->input('description');
            $category->status=$request->input('status')== true ? '1':'0';
            $category->save();
            return response()->json([
                'status'=>200,
                'message'=>'Category Added Successfully',
            ]);
        }
    }

    public function allCategory(){
        $category=Category::where('status',0)->get();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }

    public function index(){
        $category=Category::all();
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }

    public function edit($id){
        $category = Category::find($id);
        if ($category){
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Category ID Found',
            ]);
        }
    }


    public function update($id,Request $request){
//        $category = Category::find($id);

        $validator= Validator::make($request->all(),[
            'categorySlug'=>'required|max:191',
            'display'=>'required|max:191',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $category = Category::find($id);
            if ($category){
                $category->categorySlug=$request->input('categorySlug');
                $category->display=$request->input('display');
                $category->description=$request->input('description');
                $category->status=$request->input('status');
                $category->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Category Added Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No Category ID Found',
                ]);
            }

        }
    }

    public function destroy($id){
        $category = Category::find($id);
        if ($category){
            $category->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Category ID Found'
            ]);
        }
    }
}
