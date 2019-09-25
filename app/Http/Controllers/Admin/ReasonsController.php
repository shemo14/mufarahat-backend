<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ComplaintReason;
use App\Http\Controllers\Controller;
use Session;
use Validator;

class ReasonsController extends Controller
{
    public function index(){
        $rows = ComplaintReason::get();
        return view('dashboard.reasons.index', compact('rows'));
    }

    public function store(Request $request){
        // Validation rules
        $rules = [
            'name_ar'   => 'required',
            'name_en'   => 'required'
        ];
        // Validation
        $validator = validator($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $add 			= new ComplaintReason();
        $add->name_ar 	= $request['name_ar'];
        $add->name_en 	= $request['name_en'];

        if ($add->save()){
            addReport(auth()->user()->id, 'اضافة سبب للأبلاغات', $request->ip());
            Session::flash('success', 'تم اضافة القسم بنجاح');
            return back();
        }else{
            Session::flash('danger', 'لم يتم الاضافة بعد, الرجاء محاولة مره اخري');
            return back();
        }
    }

    public function update(Request $request){
        $rules = [
            'name_ar'   => 'required',
            'name_en'   => 'required'
        ];
        // Validation
        $validator = validator($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $edit           = ComplaintReason::find($request['id']);
        $edit->name_ar  = $request['name_ar'];
        $edit->name_en  = $request['name_en'];
        if ($edit->save()){
            addReport(auth()->user()->id, 'تعديل سبب ابلاغ ' . $request['name_ar'] , $request->ip());
            Session::flash('success', 'تم تعديل القسم بنجاح');
            return back();
        }else{
            Session::flash('danger', 'لم يتم التعديل بعد, الرجاء محاولة مره اخري');
            return back();
        }
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
