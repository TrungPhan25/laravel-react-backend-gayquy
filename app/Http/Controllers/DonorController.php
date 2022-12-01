<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonorController extends Controller
{
    public function indexAll(){
        $donors=Donor::where('status',1)->get();
        return response()->json([
            'status'=>200,
            'donors'=>$donors
        ]);
    }

    public function index(){
        $donors=Donor::all();
        return response()->json([
            'status'=>200,
            'donors'=>$donors,
        ]);
    }

    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email',
            'number_money'=>'required',
            'frequency'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{

            Donor::create([
                'frequency'=>$request->input('frequency'),
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'number_money'=>$request->input('number_money'),
                'status'=>0,
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'Donate thanh cong',
            ]);
        }
    }

    public function edit($id){
        $donor=Donor::find($id);
        if($donor){
            return response()->json([
                'status'=>200,
                'donor'=>$donor,
                'status_donor'=>$donor['status']
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Không tìm thấy '
            ]);
        }
    }

    public function update(Request $request,$id){
        $donor = Donor::find($id);
        if ($donor){
            $donor->status=$request->input('status');

            SendMail::dispatch($donor['email'],$donor['name'],'donate',[],1)->delay(now()->addSeconds(2));


            $donor->save();



            return response()->json([
                'status'=>200,
                'message'=>'Cập nhật trạng thái thành công',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'không tìm thấy Đơn hàng',
            ]);
        }
    }
}
