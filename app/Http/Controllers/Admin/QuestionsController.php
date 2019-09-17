<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionsController extends Controller
{
    public function index(){
		$qus = Question::get();
		return view('dashboard.questions.index', compact('qus'));
	}

	public function store(Request $request){

		$add 		     	= new Question();
		$add->question_ar 	= $request['qu_ar'];
		$add->question_en 	= $request['qu_en'];

		if ($add->save()){
			addReport(auth()->user()->id, 'اضافة سؤال', $request->ip());
			Session::flash('success', 'تم اضافة السؤال بنجاح');
			return back();
		}else{
			Session::flash('danger', 'لم يتم الاضافة بعد, الرجاء محاولة مره اخري');
			return back();
		}
	}

	public function update(Request $request){

		$edit 			    =  Question::find($request->id);
		$edit->question_ar 	= $request['qu_ar'];
		$edit->question_en 	= $request['qu_en'];

		if ($edit->save()){
			addReport(auth()->user()->id, 'تعديل سؤال '  , $request->ip());
			Session::flash('success', 'تم تعديل السؤال بنجاح');
			return back();
		}else{
			Session::flash('danger', 'لم يتم التعديل بعد, الرجاء محاولة مره اخري');
			return back();
		}
	}

	public function delete(Request $request){
		Question::findOrFail($request->delete_id)->delete();
		addReport(auth()->user()->id, 'بحذف السؤال', $request->ip());
		Session::flash('success', 'تم حذف السؤال بنجاح');
		return back();
	}

	public function deleteAll(Request $request){
		$requestIds = json_decode($request->data);
		foreach ($requestIds as $id) {
			$ids[] = $id->id;
        }
        
		if (Question::whereIn('id', $ids)->delete()) {
			addReport(auth()->user()->id, 'قام بحذف العديد من الاسئلة', $request->ip());
			Session::flash('success', 'تم الحذف بنجاح');
			return response()->json('success');
		} else {
			return response()->json('failed');
		}
	}
}
