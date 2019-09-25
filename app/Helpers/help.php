<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Models\Role;
//use App\Html;
//use App\Contact;
//use App\SmsEmailNotification;
use App\Models\Permission;
use App\Models\Report;
use App\Models\Favorite;
use App\Models\Cart;

function Home()
{
	
    $colors = [
        '#8cc759','#8c6daf','#ef5d74','#f9a74b','#60beeb','#fbef5a','#FC600A','#0247FE','#FCCB1A',
        '#EA202C','#448D76','#AE0D7A','#7FBD32','#FD4D0C','#66B032','#091534','#8601AF','#C21460',
        '#FFA500','#800080','#008000','#964B00','#D2B48C','#f5f5dc','#4281A4','#48A9A6',
    ];
    $home =[
        [
        'name'=>'الاعضاء',
        'count'=>User::count() -1,
        'icon'=>'<i style="font-size: 90px;" class="fa fa-users"></i>',
        'color'=>$colors[array_rand($colors)],
        ],
        [
            'name'=>'المشرفين',
            'count'=>User::where('role', '>', 0)->count(),
            'icon'=>'<i style="font-size: 90px;" class="fa fa-user-circle"></i>',
            'color'=>$colors[array_rand($colors)],
        ],
        [
            'name'=>'التقارير',
            'count'=>Report::count(),
            'icon'=>'<i style="font-size: 90px" class="fa fa-flag-checkered"></i>',
            'color'=>$colors[array_rand($colors)],
        ],
    ];

    return $blocks[]=$home; 
}

//function set_notification($user_id, $comment_id, $product_id, $like_id, $offer_id, $type ,$lang, $admin_msg_ar, $admin_msg_en){
//	// type = 1 => admin notification
//	// type = 2 => order notification (send - accept - refuse)
//	// type = 3 => comment
//	// type = 4 => like
//
//	App::setLocale($lang);
//	$title = '';
//	$body  = '';
//
//	if ($type == 1){
//		$title_ar = 'اشعار اداري';
//		$title_en = 'admin notification';
//		$body_ar  = $admin_msg_ar;
//		$body_en  = $admin_msg_en;
//
//		$title = trans('notifications.title_admin_notification');
//		$body  = $lang == 'ar' ? $body_ar : $body_en;
//	}elseif ($type == 2){
//		$offer = Offers::find($offer_id);
//		if ($offer->status == 0){
//			$title_ar = 'عرض جديد';
//			$title_en = 'new offer';
//			$body_ar  = 'يوجد عرض جديد علي ';
//			$body_ar  .= $offer->product->name;
//			$body_ar  .= ' من قبل ';
//			$body_ar  .= $offer->user->name;
//			$body_en  = 'new offer on ';
//			$body_en  .= $offer->product->name;
//			$body_en  .= ' from ';
//			$body_en  .= $offer->user->name;
//
//			$title = trans('notifications.title_offer_notification');
//			$body  = trans('notifications.body_offer_notification', ['product_name' => $offer->product->name, 'user_name' => $offer->user->name]);
//		}elseif ($offer->status == 1){
//			$title_ar = 'رفض العرض';
//			$title_en = 'offer refused';
//			$body_ar  = 'تم رفض عرضك علي ';
//			$body_ar  .= $offer->product->name;
//			$body_en  = 'your offer on ';
//			$body_en  .= $offer->product->name;
//			$body_en  .= ' was refused ';
//
//			$title = trans('notifications.title_refused_offer');
//			$body  = trans('notifications.body_refused_offer', ['product_name' => $offer->product->name]);
//		}elseif ($offer->status == 2){
//			$title_ar = 'قبول العرض';
//			$title_en = 'offer accepted';
//			$body_ar  = 'تم قبول عرضك علي ';
//			$body_ar  .= $offer->product->name;
//			$body_en  = 'your offer on ';
//			$body_en  .= $offer->product->name;
//			$body_en  .= ' was accepted ';
//
//			$title = trans('notifications.title_accepted_offer');
//			$body  = trans('notifications.body_accepted_offer', ['product_name' => $offer->product->name]);
//		}
//	}elseif ($type == 3){
//		$comment   = Comments::find($comment_id);
//		$title_ar  = 'تعليق جديد';
//		$title_en  = 'new comment';
//		$body_ar   = 'تم التعليق علي  ';
//		$body_ar  .= $comment->product->name;
//		$body_en   = 'you have a new comment on ';
//		$body_en  .= $comment->product->name;
//
//		$title = trans('notifications.title_comment_notification');
//		$body  = trans('notifications.body_comment_notification', ['product_name' => $comment->product->name, 'user_name' => $comment->user->name]);
//	}elseif ($type == 4){
//		$fav        = Favs::find($like_id);
//		$title_ar   = 'اعجاب جديد';
//		$title_en   =  'new like';
//		$body_ar    = 'تم الاعجاب بـ';
//		$body_ar   .= $fav->product->name;
//		$body_en    = 'your have a new like on ';
//		$body_en   .= $fav->product->name;
//
//		$title = trans('notifications.title_like_notification');
//		$body  = trans('notifications.body_like_notification', ['product_name' => $fav->product->name, 'user_name' => $fav->user->name]);
//	}
//
//	$user = User::find($user_id);
//
//	if ($user->device_id){
//		$notification               = new Notifications();
//		$notification->title_ar     = $title_ar;
//		$notification->title_en     = $title_en;
//		$notification->body_ar      = $body_ar;
//		$notification->body_en      = $body_en;
//		$notification->user_id      = $user_id;
//		$notification->product_id   = $product_id;
//		$notification->offer_id     = $offer_id;
//		$notification->type         = $type;
//
//		if ($notification->save()){
//			if ($user->isNotify){
//				$key                = $user->device_id;
//				$interestDetails    = ["$user_id" , $key];
//				$expo               = \ExponentPhpSDK\Expo::normalSetup();
//				$expo->subscribe($interestDetails[0], $interestDetails[1]);
//				$notification       = ['body' => $body, 'title' => $title, 'sound' => 'default', 'channelId' => 'orders', 'data' => [ 'type' => $type, 'product_id' => $product_id, 'offer_id' => $offer_id ]];
//				$expo->notify($interestDetails[0], $notification);
//			}
//
//			return true;
//		}
//	}
//}

function lang(){
	return App::getLocale();
}

#role name
function Role()
{
    $role = Role::findOrFail(Auth::user()->role);
    if(count($role) > 0)
    {
        return $role->role;
    }else{
        return 'عضو';
    }
}

function cart_details($product_id, $user_id, $device_id){
	$cart = NULL;
	if ($user_id != null){
		if (Cart::where(['product_id' => $product_id, 'user_id' => $user_id])->exists())
			$cart = Cart::where(['product_id' => $product_id, 'user_id' => $user_id])->first();
	}else{
		if (Cart::where(['product_id' => $product_id, 'device_id' => $device_id])->exists())
			$cart = Cart::where(['product_id' => $product_id, 'device_id' => $device_id])->first();
	}

	return $cart;
}

function reports () {
    $reports = Report::orderBy('id', 'desc')->take(8)->get();

    return $reports;
}

function orders ($order_id) {
	$products_ids 	= \App\Models\OrderItem::where('order_id', $order_id)->distinct()->get(['product_id']);
    $products   	= \App\Models\Product::whereIn('id', $products_ids)->get();
    $imgs			= [];

	foreach ($products as $product) {
		$imgs[] = url('images/products') . '/' . $product->images()->first()->name;
    }

	return $imgs;
}

#Likes
function isLiked($product_id, $user_id, $device_id){
	if ($user_id != null){
		if (Favorite::where(['product_id' => $product_id, 'user_id' => $user_id])->exists()){
			$isLiked = true;
		}else
			$isLiked = false;
	}else{
		if (Favorite::where(['product_id' => $product_id, 'device_id' => $device_id])->exists()){
			$isLiked = true;
		}else
			$isLiked = false;
	}

	return $isLiked;
}

function save_img_base64($base64_img, $path)
{
	$image      = str_replace('data:image/png;base64,', '', $base64_img);
	$image      = str_replace(' ', '+', $image);
	$image      = base64_decode( $image );
	$imageName  = time() . '_' . rand(11111, 99999) . '.' . 'png';
	File::put($path. '/' . $imageName, $image);
	return $imageName;
}

#report
function addReport($user_id,$event, $ip)
{
    if ($ip == "127.0.0.1") {
        $ip = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
    }

    $location = \Location::get($ip);
	$report = new Report;
	$user = User::findOrFail($user_id);
    if($user->role > 0)
    {
        $report->user_id = $user->id;
        $report->event   = 'قام '.$user->name .' '.$event;
        $report->supervisor = 1;
        $report->ip = $ip;
        $report->country = ($location->countryCode != null) ? $location->countryCode : '';
        $report->area = ($location->regionName != null) ? $location->regionName : '';
        $report->city = ($location->cityName != null) ? $location->cityName : '';
        $report->save();
    }else
    {
        $report->user_id = $user->id;
        $report->event   = 'قام '.$user->name .' '.$event;
        $report->supervisor = 0;
        $report->ip = $ip;
        $report->country = ($location->countryName != null) ? $location->countryName : 'localhost';
        $report->area = ($location->regionName != null) ? $location->regionName : 'localhost';
        $report->city = ($location->cityName != null) ? $location->cityName : 'localhost';
        $report->save();
    }

}

#current route
function currentRoute()
{
    $routes = Route::getRoutes();
    foreach ($routes as $value)
    {
        if($value->getName() === Route::currentRouteName()) 
        {
            echo $value->getAction()['title'] ;
        }
    }
}

function convert2english($string) {
    $newNumbers = range(0, 9);
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string =  str_replace($arabic, $newNumbers, $string);
    return $string;
}

function is_unique($key,$value){
    $user                = User::where($key , $value)->first();
    if(  $user   )
    {
        return 1;
    }
    return 0;
}

function generate_code() {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $token = '';
    $length = 6;
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

function appPath() {
    return url('/');
}

function settings($key)
{
    return \App\Models\AppSetting::where('key', $key)->first()->value;
}

function validateRequest ($validator) {
	foreach ((array)$validator->errors() as $key => $value){
		foreach ($value as $msg){
			return $msg[0];
		}
	}
}

function returnResponse($data, $msg, $code ){
	if ($data !== null){
		if ($msg == '')
			return response()->json([ 'status' => $code, 'data' => $data ]);
		else
			return response()->json([ 'status' => $code, 'msg' => $msg, 'data' => $data ]);
	}else
		return response()->json([ 'status' => $code, 'msg' => $msg ]);
}
