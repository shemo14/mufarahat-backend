<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Organizations;
use App\Models\Countries;
use App\Models\Categories;
use App\Models\Social;
use App\Models\ContactUs;
use App\Models\Notifications;
use validator;
use App\Helpers\UploadFile;
use Hash;


class SiteController extends Controller
{
	public function lang($type){
		Session::put('locale', $type);
		return back();
	}

	public function register(){
		return view('site.register_one');
	}

	public function next_register(Request $request){
		$name  = $request->name;
		$email = $request->email;
		$phone = $request->phone;

		return view('site.next_register', compact('name', 'phone', 'email'));
	}

	public function home(){
		if (Auth::check()){
			if (Auth::user()->role == 1){
				return redirect('/admin');
			}
		}

		return redirect('/');
	}
	
}
