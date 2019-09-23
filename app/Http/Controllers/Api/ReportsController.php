<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ComplaintReason;
use App\Models\OrderComplaint;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function reports_reasons(){
    	$reasons 		= ComplaintReason::select('id', 'name_' . lang() . ' as name')->get();
    	$all_reasons 	= [];

		foreach ($reasons as $reason) {
			$all_reasons[] = [
				'id' 	=> $reason->id,
				'name' 	=> $reason->name,
			];
    	}

		return returnResponse($all_reasons, '', 200);
	}

	public function set_report(Request $request){
		$rules = [
			'order_id'  	=> 'required',
			'reason_id'  	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$complaint 					= New OrderComplaint();
		$complaint->user_id 		= Auth::user()->id;
		$complaint->order_id 		= $request->order_id;
		$complaint->complaint_id 	= $request->reason_id;

		if ($complaint->save()){
			return returnResponse(NULL, trans('apis.order_report'), 200);
		}

	}
}
