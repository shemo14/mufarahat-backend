<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use Illuminate\Http\Request;
use App\Models\OrderComplaint;
use App\Http\Controllers\Controller;

class ComplaintsController extends Controller
{
    public function index(){
        $rows = OrderComplaint::with('user')->with('order')->get();
        return view('dashboard.complaints.index', compact('rows'));
    }

    public function delete(Request $request){
        ComplaintReason::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف السبب', $request->ip());
        Session::flash('success', 'تم حذف السبب بنجاح');
        return back();
    }

    public function deleteAll(Request $request){
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (ComplaintReason::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من الاسباب', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }

}
