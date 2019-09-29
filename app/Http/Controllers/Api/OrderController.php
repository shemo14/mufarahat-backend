<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\UserCoupon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate;

class OrderController extends Controller
{
    public function set_order(Request $request){
		$rules = [
			'cart_items'  	=> 'required',
			'lat'  			=> 'required',
			'long'  		=> 'required',
			// 'address'  		=> 'required',
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
		// $order->address 		= $request->address;
		$order->payment_type 	= $request->payment_type;
		$order->name 			= isset($request->name) ? $request->name : Auth::user()->name;
		$order->packaging_id 	= $request->packaging_id;

		if ($order->save()){
			if($request->coupon_id){

				$coupon = Coupon::find($request->coupon_id);
				$coupon->usage_number =  $coupon->usage_number - 1 ; 
				$coupon->save();

				$coupon_user = new UserCoupon();
				$coupon_user->user_id   = Auth::user()->id;
				$coupon_user->coupon_id = $request->coupon_id;
				$coupon_user->save();
			}

			foreach ($cart_items as $cart_item) {
				$order_item 				= new OrderItem();
				$order_item->order_id	 	= $order->id;
				$order_item->product_id 	= $cart_item->product_id;
				$order_item->quantity 		= $cart_item->quantity;
				$order_item->price 			= $cart_item->product->price * $cart_item->quantity;
				$order_item->save();
			}

			$dalegates = User::where('city_id',$order->city_id)->where('type','delegate')->get();
			// foreach ($dalegates as $dalegate) {
			// 	set_notification($dalegate->id,2,$dalegate->lang,$order->id);
			// }
			Cart::whereIn('id', $cart_ids)->delete();
			return returnResponse(NULL, trans('apis.set_order') , 200);
		}
	}

	public function financial_accounts(){
		$user_id 		= Auth::user()->id;
		$accounts 		= Transaction::where(['dalegate_id' => $user_id, 'status' => 0])->get();
		$all_accounts  	= [];

		foreach ($accounts as $account) {
			$all_accounts[] = [
				'id' 		=> $account->id,
				'order_id' 	=> $account->order_id,
				'price'     => $account->order->price . ' ' . trans('apis.rs'),
			];
		}

		return returnResponse($all_accounts, '', 200);
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

		$order 				    = Order::find($request->order_id);
		$order->status 			= 1;
		$order->dalegate_id 	= auth()->user()->id;
		if ($order->save()){
			set_notification($order->user_id,3,$order->user->lang,$order->id);
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
			if ($order->payment_type == 2){
				$transaction 		   		= new Transaction();
				$transaction->order_id 		= $order->id;
				$transaction->dalegate_id 	= $order->dalegate_id;
				$transaction->save();
			}
			set_notification($order->dalegate_id,4,$order->dalegate->lang,$order->id);
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

	public function couponDiscountOnOrder(Request $request){
		$rules = [
			'cart_items'  	  => 'required',
			'coupon_number'   => 'required',
		];
		$validator  = validator($request->all(), $rules);
		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}
		$cart_ids 	   = json_decode($request->cart_items);
		$cart_items    = Cart::whereIn('id', $cart_ids)->get();
		$couponDetails = Coupon::where('number',$request->coupon_number)->first();
		$totalMoney = 0 ;
		if ($couponDetails) {
			if($couponDetails->usage_number > 0 && $couponDetails->expire_date >= Carbon::now()){
				foreach ($cart_items as $cart_item) {
					if($couponDetails->category_id == $cart_item->product->category_id){
						$totalDiscount 				    = $couponDetails->discount + $cart_item->product->discount ;
						$totalDiscount 					= $totalDiscount > 100 ? 100 : $totalDiscount ;
						$totalProductPriceAfterDiscount = $cart_item->product->price - (($cart_item->product->price * $totalDiscount)/100);
						$totalMoney += ($totalProductPriceAfterDiscount * $cart_item->quantity ) ;
					}else{
						$totalDiscount 				    = $cart_item->product->discount ;
						$totalProductPriceAfterDiscount = $cart_item->product->price - (($cart_item->product->price * $totalDiscount)/100);
						$totalMoney += ($totalProductPriceAfterDiscount * $cart_item->quantity ) ;
					}
				}
				return returnResponse(['totalPrice' => $totalMoney,'coupon_id' => $couponDetails->id],'تم تفعيل الكوبون بنجاح ', 200);
			}else{
				foreach ($cart_items as $cart_item) {
						$totalDiscount 				    = $cart_item->product->discount ;
						$totalProductPriceAfterDiscount = $cart_item->product->price - (($cart_item->product->price * $totalDiscount)/100);
						$totalMoney += ($totalProductPriceAfterDiscount * $cart_item->quantity ) ;
				}
				return returnResponse(['totalPrice' => $totalMoney,'coupon_id' => null],'تم انتهاء صلاحيه هذا الكوبون', 400);
			}
		}else{
			foreach ($cart_items as $cart_item) {
				$totalDiscount 				    = $cart_item->product->discount ;
				$totalProductPriceAfterDiscount = $cart_item->product->price - (($cart_item->product->price * $totalDiscount)/100);
				$totalMoney += ($totalProductPriceAfterDiscount * $cart_item->quantity ) ;
			}	
			return returnResponse(['totalPrice' => $totalMoney,'coupon_id' => null],'الكود غير متوفر', 400);
		}
		
	}




}
