<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FavController extends Controller
{
	public function set_fav(Request $request){
		$rules = [
			'product_id'    => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set save', 400);

		$like_msg      = trans('apis.like');
		$dislike_msg   = trans('apis.dislike');

		if ($request->header('Authorization')){  // if user auth...
			$user         = JWTAuth::parseToken()->authenticate();

			if (Favorite::where(['product_id' => $request['product_id'], 'user_id' => $user->id])->exists()){
				Favorite::where(['product_id' => $request['product_id'], 'user_id' => $user->id])->delete();
				return returnResponse(null, $dislike_msg, 200);
			}else{
				$fav              = new Favorite();
				$fav->product_id  = $request['product_id'];
				$fav->user_id     = Auth::user()->id;
				$fav->save();

//				$user_id = Products::where('id', $request['event_id'])->first()->user_id;
//				set_notification($user_id, null,$request['event_id'], $fav->id, null, 4, $request['lang'], null, null);

				return returnResponse(null, $like_msg, 200);
			}

		}else{  // if user guest
			if (Favorite::where(['product_id' => $request['product_id'], 'device_id' => $request['device_id']])->exists()){
				Favorite::where(['product_id' => $request['product_id'], 'device_id' => $request['device_id']])->delete();
				return returnResponse(null, $dislike_msg, 200);
			}else{
				$fav                = new Favorite();
				$fav->product_id    = $request['product_id'];
				$fav->device_id     = $request['device_id'];
				$fav->save();

//				$user_id = Products::where('id', $request['event_id'])->first()->user_id;
//				set_notification($user_id, null,$request['event_id'], $fav->id, null, 4, lang(), null, null);

				return returnResponse(null, $like_msg, 200);
			}
		}
	}

	public function favorites(Request $request){
		if (!$request->header('Authorization') && !$request['device_id'])
			return returnResponse(null, 'plz, enter auth token or device id to set fav', 400);


		if ($request->header('Authorization')){  // if user auth...
			$user         		= JWTAuth::parseToken()->authenticate();
			$products_ids   	= Favorite::where('user_id', $user->id)->get(['product_id']);
			$products		  	= Product::select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->whereIn('id', $products_ids)->get();
		}else{  // if user guest
			$products_ids    = Favorite::where('device_id', $request['device_id'])->get(['product_id']);
			$products       	= Product::select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->whereIn('id', $products_ids)->get();
		}

		$all_products = [];
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
}
