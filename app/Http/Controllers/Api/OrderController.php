<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\OrderItem;
use App\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function set_order(Request $request){
		$rules = [
			'cart_items'  	=> 'required',
			'lat'  			=> 'required',
			'long'  		=> 'required',
			'address'  		=> 'required',
			'payment_type'  => 'required',
			'price'  		=> 'required',
			'city_id'  		=> 'required',
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
		$order->address 		= $request->address;
		$order->payment_type 	= $request->payment_type;
		$order->name 			= isset($request->name) ? $request->name : Auth::user()->name;
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

		if (Auth::user()->type == 'user')
			$orders 	= Order::where([ 'user_id' => Auth::user()->id, 'status' => $request->type ])->get();
		else
			$orders 	= Order::where([ 'city_id' => Auth::user()->city_id , 'status' => $request->type ])->get();


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

	public function order_details(Request $request){
		$rules = [
			'order_id'  => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$order 			= Order::find($request->order_id);
		$order_items 	= OrderItem::where('order_id', $order->id)->get();
		$all_items		= [];

		foreach ($order_items as $item) {
			$all_items[] = [
				'id' 			=> $item->id,
				'name' 			=> $item->product->name,
				'desc' 			=> $item->product->desc,
				'quantity' 		=> $item->quantity,
				'price' 		=> $item->price . ' ' . trans('apis.rs'),
				'url' 			=> url('images/products') . '/' . $item->product->images()->first()->name,
				'category' 		=> $item->product->category->name,
				'package_price' => isset($order->packaging->price) ? $order->packaging->price . ' ' . trans('apis.rs') : null,
				'package_name'  => isset($order->packaging->name) ? $order->packaging->name : NULL,
			];
		}

		$user = User::find($order->user_id);

		$delegated_data = [];

		if ($order->dalegate_id){
			$delegated_data = [
				'user_id' => $order->dalegate_id,
				'name'    => $order->dalegate->name,
				'phone'   => $order->dalegate->phone,
				'avatar'  => url('images/users') . '/' .  $order->dalegate->avatar,
			];
		}

		$order_details = [
			'order_id' 		=> $order->id,
			'status'   		=> $order->status,
			'shaping_price' => $order->city->shipping . ' ' . trans('apis.rs'),
			'total'    		=> $order->price + $order->city->shipping . ' ' . trans('apis.rs'),
			'items'    		=> $all_items,
			'location' => [
				'lat'  		=> $order->lat,
				'long' 		=> $order->long,
				'address' 	=> $order->address,
			],
			'user'	   => [
				'user_id' => $order->user_id,
				'name'    => $user->name,
				'phone'   => $user->phone,
				'avatar'  => url('images/users') . '/' .  $user->avatar,
			],
			'delegated'	  => $delegated_data
		];

		return returnResponse($order_details, '', 200);
	}

	public function accept_order(Request $request){
		$rules = [
			'order_id'  => 'required'
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$order 			= Order::find($request->order_id);
		$order->status 	= 1;
		if ($order->save()){
			return returnResponse(NULL, trans('apis.accept_order') , 200);
		}
	}

	public function finish_order(Request $request){
		$rules = [
			'order_id'  => 'required'
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$order 			= Order::find($request->order_id);
		$order->status 	= 2;
		if ($order->save()){
			return returnResponse(NULL, trans('apis.finish_order') , 200);
		}
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
