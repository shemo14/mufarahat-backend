<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;

class CartController extends Controller
{
    public function cart(){
    	//
	}

	public function set_cart(Request $request){
		$rules = [
			'product_id'  	=> 'required',
			'quantity'  	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set save', 400);

		if ($request->header('Authorization')){  // if user auth...
			$user         		= JWTAuth::parseToken()->authenticate();
			$cart  				= new Cart();
			$cart->user_id 		= $user->id;
			$cart->product_id 	= $request->product_id;
			$cart->quantity 	= $request->quantity;
			$cart->save();

		}else{  // if user guest
			$cart  					= new Cart();
			$cart->device_id 		= $request->device_id;
			$cart->product_id 		= $request->product_id;
			$cart->quantity 		= $request->quantity;
			$cart->save();
		}

		return returnResponse(NULL, trans('apis.set_cart'), 200);
	}
}
