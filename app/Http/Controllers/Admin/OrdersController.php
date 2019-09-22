<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\Order;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrdersController extends Controller
{
    public function index(){
       $status =  request()->segment(3);
       $orders = Order::where('status' , $status)->get();
       return view('dashboard.orders.index', compact('orders','status'));
    }



    public function delete(Request $request){
        Order::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف القسم', $request->ip());
        Session::flash('success', 'تم حذف القسم بنجاح');
        return back();
    }

    public function deleteAll(Request $request){
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Order::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من الاقسام', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }


}
