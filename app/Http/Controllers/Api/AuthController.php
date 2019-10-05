<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use JWTAuth;
use App\User;
use App\Models\Delegate;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;

class AuthController extends Controller
{
	public function login(Request $request){
		$rules = [
			'phone'         => 'required|exists:users,phone',
			'password'      => 'required|string',
			'device_id'     => 'required',
			'type'     		=> 'required',
		];

		$validator = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}
		$credentials = $request->only('phone', 'password');

		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				$msg = trans('apis.password');
				return returnResponse(null, $msg, 400);
			}
		} catch (JWTException $e) {
			return returnResponse(null,'could_not_create_token', 500);
		}

		$userType = User::where('phone',$request->phone)->first();

		if($userType->type == $request->type){
			$user               = auth()->user();
			$user->device_id    = $request['device_id'];
			$user->save();

			$userToken = new  UserToken();
			$userToken->user_id = auth()->user()->id;
			$userToken->token = $request['device_id'];
			$userToken->save();

			$delegated = [];

			if ($request->type == 'delegate'){
				$delegate = Delegate::where('user_id', $user->id)->first();
				$delegated = [
					'id' 			=> $delegate->id,
					'car_img' 		=>  url('images/delegates') . '/' . $delegate->car_image,
					'licenses_img' 	=>  url('images/delegates') . '/' . $delegate->licenses_image,
				];
			}

			$userData      = [
				'id'            => $user->id,
				'name'          => $user->name,
				'email'         => $user->email,
				'phone'         => $user->phone,
	 			'city_id'    	=> $user->city_id,
				'code'          => $user->code,
				'avatar'        => url('images/users') . '/' . $user->avatar,
				'active'        => $user->active,
				'checked'       => $user->checked,
				'role'          => $user->role,
				'device_id'     => $user->device_id,
				'isNotify'      => $user->isNotify,
				'lang'          => $user->lang,
				'delegate'     	=> $delegated,
				'created_at'    => $user->created_at,
				'updated_at'    => $user->updated_at,
				'token'         => $token,
			];

			$msg           = trans('apis.login');
			return returnResponse($userData, $msg, 200);
		}else{
			return returnResponse(null,'غير مسموح بالدخول', 500);
		}
	}

	public function register(Request $request){
		$rules = [
			'name'          => 'required',
			'password'      => 'required|min:6',
			'device_id'     => 'required',
			'lat'	     	=> 'required',
			'lng'		    => 'required',
			'email'         => 'required|email|unique:users,email',
			'phone'         => 'required|min:9|unique:users,phone',
		];

		App::setLocale($request['lang']);
		$validator = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}


		$user             = new User();
		$user->name       = $request['name'];
		$user->phone      = $request['phone'];
		$user->device_id  = $request['device_id'];
		$user->lang       = $request['lang'];
		$user->email      = $request['email'];
		$user->address    = $request['address'];
		$user->lat        = $request['lat'];
		$user->long       = $request['lng'];
		$user->type       = 'user';
		$user->active     = 0;
		$user->password   = bcrypt($request['password']);

		$code             = rand(1111, 9999);
		$user->code       = $code;

		if ($user->save()){

			$userToken = new  UserToken();
			$userToken->user_id = auth()->user()->id;
			$userToken->token = $request['device_id'];
			$userToken->save();

			$data['code'] 	= $user->code;
			$msg 			= trans('apis.register');
			return returnResponse($data, $msg, 200);
		}
	}

	public function delegateActiveChecked(){
		$active = auth()->user()->checked;
		if ($active == 0 ) {
			return returnResponse(null,'الحساب في انتظار تأكيد الاداره', 400);
		}

		return returnResponse(NULL,'', 200);
	}

	public function delegate_register(Request $request){
		$rules = [
			'name'          => 'required',
			'password'      => 'required|min:6',
			'device_id'     => 'required',
			'lat'	     	=> 'required',
			'lng'		    => 'required',
			'vehicle_img'	=> 'required',
			'profile_img'	=> 'required',
			'license_img'	=> 'required',
			'email'         => 'required|email|unique:users,email',
			'phone'         => 'required|min:9|unique:users,phone',
		];

		App::setLocale($request['lang']);
		$validator = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}


		$user             	= new User();
		$user->name       	= $request['name'];
		$user->phone      	= $request['phone'];
		$user->device_id  	= $request['device_id'];
		$user->lang       	= $request['lang'];
		$user->email      	= $request['email'];
		$user->lat        	= $request['lat'];
		$user->long       	= $request['lng'];
		$user->address   	= $request['address'];
		$user->type       	= 'delegate';
		$user->avatar  		= save_img_base64($request['profile_img'], 'images/users');
		$user->active     	= 0;
		$user->password   	= bcrypt($request['password']);

		$code             	= rand(1111, 9999);
		$user->code       	= $code;

		if ($user->save()){
			$delegate 					= new Delegate();
			$delegate->car_image 		= save_img_base64($request['vehicle_img'], 'images/delegates');
			$delegate->licenses_image 	= save_img_base64($request['license_img'], 'images/delegates');
			$delegate->user_id			= $user->id;
			$delegate->save();

			$data['code'] 				= $user->code;
			$msg 						= trans('apis.register');
			return returnResponse($data, $msg, 200);
		}
	}

	public function active_account(Request $request){
		$rules = [
			'phone' => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$user = User::where('phone', $request['phone'])->first();
		if ($user){
			$user->active  = 1;
			$user->update();

			$data['id']      = $user->id;
			$msg             = trans('apis.active_account');
			return returnResponse(NULL, $msg, 200);
		}else{
			$msg = trans('apis.phone_not_found');
			return returnResponse(null, $msg, 400);
		}
	}

	public function forget_password(Request $request){
		$rules = [
			'phone' => 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$user = User::where('phone', $request['phone'])->first();
		if ($user){
			$code        = rand(1111, 9999);
			$user->code  = $code;
			$user->update();

			$data['id']      = $user->id;
			$data['code']    = $user->code;
			$msg             = trans('apis.send_code');
			return returnResponse($data, $msg, 200);
		}else{
			$msg = trans('apis.phone_not_found');
			return returnResponse(null, $msg, 400);
		}
	}

	public function renew_password(Request $request){
		$rules = [
			'password'  => 'required|min:6',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse(null, validateRequest($validator), 400);
		}

		$user           = Auth::user();
		if (Hash::check($request->password, $user->password)) {
			$user->password = bcrypt($request['password']);
			$user->save();
			$msg  = trans('apis.update_password');
		}else
			$msg  = trans('apis.failed_update_password');

		return returnResponse(null, $msg, 200);
	}

	public function user_data(Request $request){
		$user           = auth()->user();
		$token          = $request->header('Authorization');

		$delegated = [];

		if ($user->type == 'delegate'){
			$delegate = Delegate::where('user_id', $user->id)->first();
			$delegated = [
				'id' 			=> $delegate->id,
				'car_img' 		=>  url('images/delegates') . '/' . $delegate->car_image,
				'licenses_img' 	=>  url('images/delegates') . '/' . $delegate->licenses_image,
			];
		}

		$userData       = [
			'id'            => $user->id,
			'name'          => $user->name,
			'email'         => $user->email,
			'phone'         => $user->phone,
      		'city_id' 	    => $user->city_id,
			'code'          => $user->code,
			'avatar'        => url('images/users') . '/' . $user->avatar,
			'active'        => $user->active,
			'checked'       => $user->checked,
			'role'          => $user->role,
			'device_id'     => $user->device_id,
			'isNotify'      => $user->isNotify,
			'lang'          => $user->lang,
			'delegate'		=> $delegated,
			'created_at'    => $user->created_at,
			'updated_at'    => $user->updated_at,
			'token'         => $token,
		];
		return returnResponse($userData, '', 200);
	}
}
