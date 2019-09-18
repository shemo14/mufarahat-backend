<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function set_order(Request $request){
		$rules = [
			'cart_items'  	=> 'required',
			'quantity'  	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

	}
}
