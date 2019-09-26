<?php

use App\User;
use App\Models\Cart;
use App\Models\Role;
use App\Models\Order;
use App\Models\Report;
use App\Models\Favorite;
use App\Models\UserToken;
use App\Models\Permission;
use App\Models\Notifications;
use Illuminate\Support\Facades\Route;

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

function set_notification($user_id, $type , $lang ,$order_id = null , $admin_msg_ar = null , $admin_msg_en = null ){
	// type = 1 => admin notification
	// type = 2 => Send new orders to Dalegates
	// type = 3 => 
	// type = 4 => 

	App::setLocale($lang);
	$title = '';
	$body  = '';

	if ($type == 1){
		$title_ar = 'اشعار اداري';
		$title_en = 'admin notification';
		$body_ar  = $admin_msg_ar;
		$body_en  = $admin_msg_en;

		$title = trans('notifications.title_admin_notification');
        $body  = $lang == 'ar' ? $body_ar : $body_en;
    }elseif ($type == 2){
			$order     = Order::find($order_id);
			$title_ar  = 'طلب جديد ';
			$title_en  = 'new Order';
			$body_ar   = 'يوجد طلب جديد ';
			// $body_ar  .= $order->product->name;
			$body_en   = 'A new order is available';
			// $body_en  .= $comment->product->name;

			$title = trans('notifications.title_dalegate_newOrders');
			$body  = trans('notifications.body_comment_notification');
	}elseif ($type == 3){
		$order     = Order::find($order_id);
		$title_ar  = 'اشعار قبول ';
		$title_en  = 'Order Notfication';
		$body_ar   = 'تم قبول طلبك وجاري تجهيزه';
		$body_en   = 'Your request has been accepted and is being processed';
		
		$title = trans('notifications.title_order_accepted');
		$body  = trans('notifications.body_order_accepted');
	}elseif ($type == 4){
		$order     = Order::find($order_id);
		$title_ar  = 'تم تسليم الطلب بنجاح';
		$title_en  = 'Confirm delivery request';
		$body_ar   = 'تم تأكيد استلام الطلب رقم '.$order_id;
		$body_en   = 'Order '.$order_id.' has been confirmed';
		
		$title = trans('notifications.title_order_confirmed');
		$body  = trans('notifications.body_order_confirmed');
	}

	$user = User::find($user_id);

	if ($user){
		$notification               = new Notifications();
		$notification->title_ar     = $title_ar;
		$notification->title_en     = $title_en;
		$notification->body_ar      = $body_ar;
		$notification->body_en      = $body_en;
		$notification->user_id      = $user_id;
		$notification->order_id     = $order_id;
		$notification->type         = $type;

		if ($notification->save()){
			if ($user->isNotify){
				$userTokens  = UserToken::where('user_id',$user_id)->get();
				foreach($userTokens as $UT){
					$key                = $UT->token;
					$interestDetails    = ["$user_id" , $key];
					$expo               = \ExponentPhpSDK\Expo::normalSetup();
					$expo->subscribe($interestDetails[0], $interestDetails[1]);
					$notification       = ['body' => $body, 'title' => $title, 'sound' => 'default', 'channelId' => 'orders', 'data' => [ 'type' => $type, 'order_id' => $order_id]];
					$expo->notify($interestDetails[0], $notification);
				}
			}
			return true;
		}
	}
}

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
