<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommanQues;
use Session;

class QUAnsController extends Controller
{
	public function index(){
		$qus = CommanQues::get();
		return view('dashboard.comman_qus.index', compact('qus'));
	}

	public function addQU(Request $request){

		$add 			= new CommanQues();
		$add->qu_ar 	= $request['qu_ar'];
		$add->qu_en 	= $request['qu_en'];
		$add->ans_ar 	= $request['ans_ar'];
		$add->ans_en 	= $request['ans_en'];

		if ($add->save()){
			addReport(auth()->user()->id, 'اضافة سؤال', $request->ip());
			Session::flash('success', 'تم اضافة السؤال بنجاح');
			return back();
		}else{
			Session::flash('danger', 'لم يتم الاضافة بعد, الرجاء محاولة مره اخري');
			return back();
		}
	}

	public function updateQU(Request $request){

		$edit 			= CommanQues();
		$edit->qu_ar 	= $request['qu_ar'];
		$edit->qu_en 	= $request['qu_en'];
		$edit->ans_ar 	= $request['ans_ar'];
		$edit->ans_en 	= $request['ans_en'];

		if ($edit->save()){
			addReport(auth()->user()->id, 'تعديل سؤال '  , $request->ip());
			Session::flash('success', 'تم تعديل السؤال بنجاح');
			return back();
		}else{
			Session::flash('danger', 'لم يتم التعديل بعد, الرجاء محاولة مره اخري');
			return back();
		}
	}

	public function deleteQU(Request $request){
		CommanQues::findOrFail($request->delete_id)->delete();
		addReport(auth()->user()->id, 'بحذف السؤال', $request->ip());
		Session::flash('success', 'تم حذف السؤال بنجاح');
		return back();
	}

	public function deleteQus(Request $request){
		$requestIds = json_decode($request->data);
		foreach ($requestIds as $id) {
			$ids[] = $id->id;
		}
		if (CommanQues::whereIn('id', $ids)->delete()) {
			addReport(auth()->user()->id, 'قام بحذف العديد من الاسئلة', $request->ip());
			Session::flash('success', 'تم الحذف بنجاح');
			return response()->json('success');
		} else {
			return response()->json('failed');
		}
	}
}
