<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organizations;
use App\Models\Events;
use App\Models\Offer;
use App\Models\Review;
use App\Models\Bookings;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Carbon\Carbon;

class ProductsController extends Controller
{
	public function products(){
		$products 		= Product::select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();
		$all_products	= [];

		foreach ($products as $product){
			$all_products[] = [
				'id' 			=> $product->id,
				'name' 			=> $product->name,
				'image' 		=> url('/images/products') . '/' .  $product->images()->first()->name,
				'category' 		=> $product->category->name,
				'old_price'     => $product->price,
				'price'     	=> $product->price - ($product->price * $product->discount)/100,
			];
		}

		return returnResponse($all_products, '', 200);
	}

	public function offers(){
		$products_ids 	= Offer::where('active', 1)->get(['product_id']);
		$products 		= Product::whereIn('id', $products_ids)->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();
		$all_products	= [];

		foreach ($products as $product){
			$max_date   		= Carbon::now()->subHours($product->offer->time);
			if ($product->offer->created_at >= $max_date){
				$all_products[] = [
					'id' 			=> $product->id,
					'name' 			=> $product->name,
					'image' 		=> url('/images/products') . '/' .  $product->images()->first()->name,
					'category' 		=> $product->category->name,
					'old_price'     => $product->price  . ' ' . trans('apis.rs'),
					'seconds'       => $max_date->diffInSeconds($product->offer->created_at),
					'price'     	=> $product->price - ($product->price * $product->offer->discount)/100 . ' ' . trans('apis.rs'),
				];
			}
		}

		return returnResponse($all_products, '', 200);
	}

	public function events_filter(Request $request){
		$events = Events::query();

		if ($request['city_id']){
			$events = $events->where('country_id', $request['city_id']);
		}

		if ($request['org_id']){
			$events = $events->where('organization_id', $request['org_id']);
		}

		if ($request['date']){
			$events = $events->where('date', $request['date']);
		}

		if ($request['price']){
			$events = $events->where('normal', $request['price']);
		}

		if (isset($request->category_id)){
			$events 	= $events->where('category_id', $request['category_id'])->select( 'id', 'title_' . lang() . ' as title', 'date', 'time', 'normal' )->get();
		}else{
			$events 	= $events->select( 'id', 'title_' . lang() . ' as title', 'date', 'time', 'normal' )->get();
		}


		$all_events = [];


		foreach ($events  as $event) {
			$all_events[] = [
				'id' 	=> $event->id,
				'title' => $event->title,
				'date' 	=> $event->date,
				'time' 	=> $event->time,
				'price' => $event->normal . ' ' . trans('apis.rs'),
				'image' => url('images/events') . '/' .  $event->images()->first()->name,
			];
		}

		return returnResponse($all_events, '', 200);
	}

	public function category_products(Request $request){
		$rules = [
			'category_id'   => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse([], validateRequest($validator), 400);
		}

		$products 		= Product::where('category_id', $request->category_id)->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();
		$all_products	= [];

		foreach ($products as $product){
			$all_products[] = [
				'id' 			=> $product->id,
				'name' 			=> $product->name,
				'image' 		=> url('/images/products') . '/' .  $product->images()->first()->name,
				'category' 		=> $product->category->name,
				'old_price'     => $product->price,
				'price'     	=> $product->price - ($product->price * $product->discount)/100,
			];
		}

		return returnResponse($all_products, '', 200);
	}

	public function product_details(Request $request){
		$rules = [
			'id'          => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set fav', 400);

		$product          = Product::select( 'id', 'name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'category_id', 'price', 'discount' )->find($request['id']);
		$images           = $product->images()->get();
		$product_images   = [];

		foreach ($images as $image) {
			$product_images[] =  url('images/products') . '/' . $image->name;
		}

		$user_id   = null;
		$device_id = null;
		if ($request->header('Authorization')){
			$user       = JWTAuth::parseToken()->authenticate();
			$user_id    = Auth::user()->id;
		}else
			$device_id  = $request['device_id'];

		$product_details = [
			'id' 		=> $request['id'],
			'name' 		=> $product->name,
			'desc'  	=> $product->desc,
			'price'     => $product->price - ($product->price * $product->discount)/100,
			'old_price' => $product->price,
			'category' 	=> $product->category->name,
			'isLiked'   => isLiked($product->id, $user_id, $device_id),
			'rate'      => $product->reviews()->get()->avg('rate'),
			'images' 	=> $product_images
		];

		return returnResponse($product_details, '', 200);
	}

	public function search(Request $request){
		$products 	= Product::where('name_ar', 'LIKE', '%' . $request['search'] . '%')->orWhere('name_en', 'LIKE', '%' . $request['search'] . '%')
							 ->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();

		$all_products = [];
		foreach ($products as $product){
			$all_products[] = [
				'id' 			=> $product->id,
				'name' 			=> $product->name,
				'image' 		=> url('/images/products') . '/' .  $product->images()->first()->name,
				'category' 		=> $product->category->name,
				'old_price'     => $product->price . ' ' . trans('apis.rs'),
				'price'     	=> $product->price - ($product->price * $product->discount)/100 . ' ' . trans('apis.rs'),
			];
		}

		return returnResponse($all_products, '', 200);
	}

	public function rate(Request $request){
		$rules = [
			'product_id'    => 'required',
			'rate'          => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		if ($is_rated = Review::where(['user_id' => Auth::user()->id, 'product_id' => $request['product_id']])->first()){
			$is_rated->rate = $request['rate'];
			$is_rated->update();

			$msg      = lang() == 'ar' ? 'تم التقيم بنجاح' : 'rated successfully';
			$avg_rate = Review::where('product_id', $request['product_id'])->avg('rate');
			return returnResponse(['rate' => $avg_rate], $msg, 200);
		}else{
			$rate               = new Review();
			$rate->user_id      = Auth::user()->id;
			$rate->rate         = $request['rate'];
			$rate->product_id   = $request['product_id'];
			if ($rate->save()){
				$avg_rate = $rate->avg('rate');
				$msg      = lang() == 'ar' ? 'تم التقيم بنجاح' : 'rated successfully';
				return returnResponse(['rate' => $avg_rate], $msg, 200);
			}else{
				$msg      = lang() == 'ar' ? 'لم يتم التقيم بعد ,الرجاء المحاولة مرة اخري' : 'something went wrong, plz try again';
				return returnResponse(null, $msg, 400);
			}
		}

	}

	public function suggested_events(){
		$events 	= Events::select( 'id', 'title_' . lang() . ' as title', 'date', 'time', 'normal' )->orderBy('date', 'desc')->take(10)->get();
		$all_events = [];

		foreach ($events  as $event) {
			$all_events[] = [
				'id' 	=> $event->id,
				'title' => $event->title,
				'date' 	=> $event->date,
				'time' 	=> $event->time,
				'price' => $event->normal . ' ' . trans('apis.rs'),
				'image' => url('images/events') . '/' .  $event->images()->first()->name,
			];
		}


		return returnResponse($all_events, '', 200);
	}

	public function common_events(){
		$event_id = Bookings::select('event_id')
							->groupBy('event_id')
							->orderByRaw('COUNT(*) DESC')
							->distinct()
							->get(['event_id']);

		$events 	= Events::whereIn('id', $event_id)->select( 'id', 'title_' . lang() . ' as title', 'date', 'time', 'normal' )->orderBy('date', 'desc')->take(10)->get();
		$all_events = [];


		foreach ($events  as $event) {
			$all_events[] = [
				'id' 	=> $event->id,
				'title' => $event->title,
				'date' 	=> $event->date,
				'time' 	=> $event->time,
				'price' => $event->normal . ' ' . trans('apis.rs'),
				'image' => url('images/events') . '/' .  $event->images()->first()->name,
			];
		}


		return returnResponse($all_events, '', 200);
	}

	public function organizations_events(Request $request){
		$organizationId 	= Organizations::get(['id']);
		$events 			= Events::whereIn('organization_id', $organizationId)->select( 'id', 'title_' . lang() . ' as title', 'date', 'time', 'normal' )->orderBy('date', 'desc')->get();
		$min 				= Events::whereIn('organization_id', $organizationId)->min('normal');
		$max 				= Events::whereIn('organization_id', $organizationId)->max('normal');
		$step				= ( $max - $min ) / $min;
		$all_events 		= [];

		foreach ($events  as $event) {
			$all_events[] = [
				'id' 	=> $event->id,
				'title' => $event->title,
				'date' 	=> $event->date,
				'time' 	=> $event->time,
				'price' => $event->normal . ' ' . trans('apis.rs'),
				'image' => url('images/events') . '/' .  $event->images()->first()->name,
			];
		}


		$data = [
			'events' => $all_events,
			'min'	 => $min,
			'max'	 => $max,
		];

		return returnResponse($data, '', 200);

	}

}
