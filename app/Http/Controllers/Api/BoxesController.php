<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\BoxItem;

class BoxesController extends Controller
{
    public function boxes(){
    	$boxes 		= Box::select('id', 'name_' . lang() . ' as name', 'image', 'price')->get();
    	$all_boxes 	= [];

		foreach ($boxes as $box) {
			$all_boxes[] = [
				'id' 	=> $box->id,
				'name' 	=> $box->name,
				'price' => $box->price . ' ' . trans('apis.rs'),
				'image' => url('images/boxes') . '/' . $box->image,
			];
    	}

		return returnResponse($all_boxes, '', 200);
	}

	public function box_items(Request $request){
    	$box 			= Box::find($request['box_id']);
    	$products_ids   = BoxItem::where('box_id', $request['box_id'])->get(['product_id']);
    	$products 		= Product::whereIn('id', $products_ids)->select('name_' . lang() . ' as name', 'description_' . lang() . ' as desc', 'id', 'price', 'category_id', 'discount' )->get();
		$all_products	= [];

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
}
