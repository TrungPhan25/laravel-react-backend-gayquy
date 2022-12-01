<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function check($code){
        $order=Customer::where('customer_id',$code)->first();
        if($order){
            return response()->json([
                'status'=>200,
                'order'=>$code,
                'status_code'=>$order['status'],
                'message'=>'Check Hàng Thành Công'
            ]);
        }else{
            return response()->json([
                'status'=>422,
                'error'=>'Not Found',
            ]);
        }
    }

    public function index(){
        $orders=Customer::all();
        return response()->json([
            'status'=>200,
            'orders'=>$orders
        ]);
    }

    public function edit($id){
        $order=Customer::find($id);
        $order_detail=Cart::where('customer_id',$id)->get();
        if($order){
            return response()->json([
                'status'=>200,
                'order'=>$order,
                'order_detail'=>$order_detail,
                'status_order'=>$order['status']
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Không tìm thấy đơn hàng'
            ]);
        }

    }

    public function update(Request $request,$id){
        $validator= Validator::make($request->all(),[
            'status'=>'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
                'message'=>$request->input('status')
            ]);
        }else{
            $order = Customer::find($id);
            if ($order){
                $order->status=$request->input('status');
                $order->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'Cập nhật trạng thái thành công',
                    'mesadssage'=>$request->input('status')

                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'không tìm thấy Đơn hàng',
                ]);
            }

        }
    }

    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email',
            'number_phone'=>'required',
            'address'=>'required',
            'note'=>'required',
            'method_payment'=>'required|integer',
        ]);
        $data=$request->input('items');
        $data1=json_decode($data);
//        $productId = array_keys($data1);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }else{

            try {
                DB::beginTransaction();
                $ctm_id = Helper::IDGenerator(new Customer, 'customer_id', 4, 'CTM');

                $customer=Customer::create([
                    'customer_id' =>$ctm_id,
                    'name' => $request->input('name'),
                    'phone' => $request->input('number_phone'),
                    'address' => $request->input('address'),
                    'email' => $request->input('email'),
                    'method_payment'=>$request->input('method_payment'),
                    'status' => 0,
                ]);

                $data=[];
                $carts=$data1;
                foreach ($carts as $cart){
                    $data[] =[
                        'customer_id' => $customer->id,
                        'product_id' => $cart->product_id,
                        'pty'   => $cart->quantity,
                        'price' => $cart->price
                    ];
                }

                Cart::insert($data);


                DB::commit();

                SendMail::dispatch($request->input('email'),$request->input('name'),$ctm_id,$carts,0)->delay(now()->addSeconds(2));

                return response()->json([
                    'status'=>200,
                    'massage'=>'Đặt hàng thành công',
                ]);


            }catch (\Exception $err){
                DB::rollBack();
                return response()->json([
                    'status'=>400,
                    'errors'=>'Đặt Hàng Lỗi, Vui lòng thử lại sau',
                ]);
            }
        }
    }


}
