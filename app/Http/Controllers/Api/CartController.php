<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use JWTAuth;

class CartController extends Controller
{
    public function cart(Request $request){
		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set save', 400);

		if ($request->header('Authorization')){  // if user auth...
			$user         		= JWTAuth::parseToken()->authenticate();
			$cart_items		= Cart::where('user_id', $user->id)->get();
			$all_products 	= [];

			foreach ($cart_items as $item) {
				$all_products[] = [
					'cart_id' 		=> $item->id,
					'product_id' 	=> $item->product_id,
					'name'    		=> $item->product->name,
					'quantity' 		=> $item->quantity,
					'image'    		=> url('images/products') . '/' . $item->product->images()->first()->name,
					'category'  	=> $item->product->category->name,
					'desc'  		=> $item->product->desc,
					'price'  		=> $item->product->price - ( $item->product->price * $item->product->discount ) / 100 . ' ' . trans('apis.rs'),
					'rate'   		=>  $item->product->rate()->avg('rate')
				];
			}

		}else{  // if user guest
			$cart  					= new Cart();
			$cart->device_id 		= $request->device_id;
			$cart->product_id 		= $request->product_id;
			$cart->quantity 		= $request->quantity;
			$cart->save();
		}

		return returnResponse(NULL, trans('apis.set_cart'), 200);
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