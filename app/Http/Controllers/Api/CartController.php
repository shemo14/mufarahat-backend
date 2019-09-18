<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use JWTAuth;
use App\Models\Product;

class CartController extends Controller
{
    public function cart(Request $request){
		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set save', 400);

		$user_id = NULL;
		if ($request->header('Authorization')){  // if user auth...
			$user       = JWTAuth::parseToken()->authenticate();
			$user_id    = $user->id;
		}

		$cart_items	 	= $user_id ? Cart::where('user_id', $user_id)->get() : Cart::where('device_id', $request->device_id)->get();
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
				'price'  		=> ( $item->product->price - ( $item->product->price * $item->product->discount ) / 100 ) * $item->quantity,
				'rate'   		=> $item->product->reviews()->avg('rate')
			];
		}

		return returnResponse($all_products, '', 200);
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

			if (Cart::where([ 'user_id' => $user->id, 'product_id' => $request->product_id ])->exists()){
				$cart = Cart::where([ 'user_id' => $user->id, 'product_id' => $request->product_id ])->first();
				$cart->quantity = $cart->quantity + $request->quantity;
				$cart->save();
			}else{
				$cart  				= new Cart();
				$cart->user_id 		= $user->id;
				$cart->product_id 	= $request->product_id;
				$cart->quantity 	= $request->quantity;
				$cart->save();
			}

		}else{  // if user guest
			if (Cart::where([ 'device_id' => $request->device_id, 'product_id' => $request->product_id ])->exists()){
				$cart = Cart::where([ 'device_id' => $request->device_id, 'product_id' => $request->product_id ])->first();
				$cart->quantity = $cart->quantity + $request->quantity;
				$cart->save();
			}else{
				$cart  					= new Cart();
				$cart->device_id 		= $request->device_id;
				$cart->product_id 		= $request->product_id;
				$cart->quantity 		= $request->quantity;
				$cart->save();
			}
		}

		return returnResponse(NULL, trans('apis.set_cart'), 200);
	}

	public function delete_cart(Request $request){
		$rules = [
			'cart_id'  	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$cart 	= Cart::find($request->cart_id);

		if ($cart->delete()){
			return returnResponse(NULL, trans('apis.delete_cart'), 200);
		}

		return returnResponse(NULL, 'cant delete cart, plz try again', 400);
	}

	public function cart_quantity(Request $request){
		$rules = [
			'cart_id'  	=> 'required',
			'quantity'  => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$cart 				= Cart::find($request->cart_id);
		$cart->quantity 	= $request->quantity;

		if ($cart->save()){
			return returnResponse(NULL, trans('apis.qnty_cart'), 200);
		}

		return returnResponse(NULL, 'cant modified cart, plz try again', 400);
	}

	public function cart_search(Request $request){
		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set save', 400);

		$user_id = NULL;
		if ($request->header('Authorization')){  // if user auth...
			$user       = JWTAuth::parseToken()->authenticate();
			$user_id    = $user->id;
		}

		$products_ids	= $user_id ? Cart::where('user_id', $user_id)->get(['product_id']) : Cart::where('device_id', $request->device_id)->get(['product_id']);
		$products 		= Product::whereIn('id', $products_ids)->where('name_ar', 'LIKE', '%' . $request['search'] . '%')->orWhere('name_en', 'LIKE', '%' . $request['search'] . '%')
								  ->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();

		$all_products = [];
		foreach ($products as $product) {
			$all_products[] = [
				'cart_id' 		=> cart_details($product->id, $user_id, $request->device_id)->id,
				'product_id' 	=> $product->id,
				'name'    		=> $product->name,
				'quantity' 		=> cart_details($product->id, $user_id, $request->device_id)->quantity,
				'image'    		=> url('images/products') . '/' . $product->images()->first()->name,
				'category'  	=> $product->category->name,
				'desc'  		=> $product->desc,
				'price'  		=> ( $product->price - ( $product->price * $product->discount ) / 100 ) * cart_details($product->id, $user_id, $request->device_id)->quantity,
				'rate'   		=> $product->reviews()->avg('rate')
			];
		}

		return returnResponse($all_products, '', 200);
	}
}
