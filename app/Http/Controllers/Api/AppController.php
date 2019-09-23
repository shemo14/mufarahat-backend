<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Packaging;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Social;
use App\Models\ContactUs;
use App\Models\Intro;
use Illuminate\Support\Facades\App;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;
use App\Models\Images;
use App\Models\CommanQues;


class AppController extends Controller
{
	public function roles(){
		$roles       = 'roles_' . lang();
		return returnResponse([ 'roles' => settings($roles)], '', 200);
	}

	public function about_app(){
		$about_us       = 'about_us_' . lang();
		return returnResponse([ 'about' => settings($about_us)], '', 200);
	}

	public function app_info(Request $request){
		$socials    = Social::get();
		$allSocials = [];

		foreach ($socials as $social) {
			$allSocials[] = [
				'name' => $social->site_name,
				'logo' => url('images/socials') . '/' . $social->icon,
				'url'  => $social->url,
			];
		}

		$info = [
			'phone'     => settings('phone'),
			'email'     => settings('email'),
		];

		$data = [
			'info'      	=> $info,
			'socials'   	=> $allSocials
		];

		return returnResponse($data, '', 200);
	}

	public function send_report(Request $request){

		$rules = [
			'username'  => 'required',
			'email'   	=> 'required|email',
			'msg'     	=> 'required',
		];

		$validator  = validator($request->all(), $rules);

		if ($validator->fails()) {
			return returnResponse([], validateRequest($validator), 400);
		}

		$contact        	= new ContactUs();
		$contact->username  = $request['username'];
		$contact->email 	= $request['email'];
		$contact->msg   	= $request['msg'];

		if ($contact->save()){
			$msg = trans('apis.report');
			return returnResponse(null, $msg, 200);
		}

	}

	public function set_lang(Request $request){
		Session::put('locale', $request['lang']);
		return returnResponse(null, trans('apis.set_language'), 200);
	}

	public function intro(Request $request){
		$intros 	= Intro::select('id', 'name_' . lang() . ' as name', 'desc_' . lang() . ' as desc', 'image')->get();
		$all_intros = [];

		foreach ($intros as $intro) {
			$all_intros[] = [
				'id' 	=> $intro->id,
				'name' 	=> $intro->name,
				'desc' 	=> $intro->desc,
				'image' =>  url('images/intro') . '/' . $intro->image,
			];
		}

		return returnResponse($all_intros, '', 200);
	}

	public function uploading_video(Request $request){
//		dd($request->file('video'));
		$upload 		= new Images();
		$upload->key 	= 100;
		$upload->type 	= 'test';
		$upload->name 	= UploadFile::uploadImage($request->file('video'), 'categories');

		if ($upload->save()){
			return returnResponse(null, 'uploaded successfully', 200);
		}
	}

	public function common_questions(Request $request){

		$qus 		= CommanQues::select('qu_' . lang() . ' as qu', 'ans_' . lang() . ' as ans')->get();
		$all_qus   	= [];

		foreach ($qus as $qu) {
			$all_qus[] = [
				'qu'  	=> $qu->qu,
				'ans'   => $qu->ans,
			];
		}

		return returnResponse($all_qus, '', 200);
	}

	public function cities(){
		$cities 	= City::select('id', 'name_' . lang() . ' as name', 'shipping')->get();
		$cities_all = [];

		foreach ($cities as $city) {
			$cities_all[] = [
				'id'  		=> $city->id,
				'name'  	=> $city->name,
				'shipping'  => $city->shipping . ' ' . trans('apis.rs'),
			];
		}

		return returnResponse($cities_all, '', 200);
	}

	public function packages(){
		$packages 		= Packaging::select('id', 'name_' . lang() . ' as name', 'price')->get();
		$packages_all 	= [];

		foreach ($packages as $package) {
			$packages_all[] = [
				'id'  	 => $package->id,
				'name'   => $package->name,
				'price'  => $package->price . ' ' . trans('apis.rs'),
			];
		}

		return returnResponse($packages_all, '', 200);
	}

	public function suggestions(Request $request){
		$suggestions 			= new Suggestion();
		$suggestions->user_id 	= Auth::user()->id;
		$suggestions->title 	= $request->title;
		$suggestions->content 	= $request->msg;

		if ($suggestions->save()){
			return returnResponse(NULL, trans('apis.order_report'), 200);
		}
	}
}
