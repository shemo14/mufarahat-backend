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

			Cart::whereIn('id', $cart_ids)->delete();
			return returnResponse(NULL, trans('apis.set_order') , 200);
		}
	}

	public function my_orders(Request $request){
		$rules = [
			'type'  => 'required', // type => 0 ( new order ) || // type => 1 ( finished order )
		];
		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$orders 	= Order::where([ 'user_id' => Auth::user()->id, 'status' => $request->type ])->get();
		$all_orders = [];

		foreach ($orders as $order) {
			$all_orders[] = [
				'id' 		=> $order->id,
				'order_no' 	=> '#' . $order->id,
				'price' 	=> $order->price,
				'images' 	=> orders($order->id)
			];
		}

		return returnResponse($all_orders, '', 200);
	}

	public function deleted_order(Request $request){
		$rules = [
			'order_id'  => 'required'
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$order = Order::find($request->order_id);
		if ($order->delete()){
			return returnResponse(NULL, trans('apis.delete_order') , 200);
		}
	}
}
