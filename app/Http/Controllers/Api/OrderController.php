<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function set_order(Request $request){
		$rules = [
			'cart_items'  	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$cart_ids 	= json_decode($request->cart_items);
		$cart_items = Cart::whereIn('id', $cart_ids)->get();

		$order 					= new Order();
		$order->user_id 		= Auth::user()->id;
		$order->city_id 		= $request->city_id;
		$order->coupon_id 		= $request->coupon_id;
		$order->price 			= $request->price;
		$order->notes 			= $request->notes;
		$order->lat 			= $request->lat;
		$order->long 			= $request->long;
		$order->payment_type 	= $request->payment_type;
		$order->name 			= Auth::user()->name;
		$order->dalegate_id 	= 1;
		$order->packaging_id 	= $request->packaging_id;

		if ($order->save()){
			foreach ($cart_items as $cart_item) {
				$order_item 				= new OrderItem();
				$order_item->order_id	 	= $order->id;
				$order_item->product_id 	= $cart_item->product_id;
				$order_item->quantity 		= $cart_item->quantity;
				$order_item->price 			= $cart_item->product->price * $cart_item->quantity;
				$order_item->save();
			}
			return returnResponse('', 'تم تسجيل الطلب بنجاح', 200);
		}

	}
}
