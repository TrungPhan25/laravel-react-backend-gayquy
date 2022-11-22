<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $orders_warning=Customer::where('status',0)->get();
        $donors_warning=Donor::where('status',0)->get();
        $count_order_warning=Customer::where('status',0)->count();
        $total_donate=Donor::where('status',1)->sum('number_money');
        $total_donor=Donor::where('status',1)->count();



        return response()->json([
                'status'=>200,
                'orders_warning'=>$orders_warning,
                'donors_warning'=>$donors_warning,
                'count_order_warning'=>$count_order_warning,
                'total_donate'=>$total_donate,
                'total_donor'=>$total_donor,
            ]);

    }
}
