<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Box;
use App\Models\City;
use App\Models\Role;
use App\Models\Offer;
use App\Models\Coupon;
use App\Models\Report;
use App\Models\Product;
use App\Models\Question;
use App\Models\Countries;
use App\Models\Packaging;
use App\Models\Warehouse;
use App\Models\Categories;
use App\Models\CommanQues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Dashboard Page
    public function dashboard()
    {
        $users          = User::where('role', 0)->count();
        $admins         = User::where('role', 1)->count();
        $categories     = Categories::count();
        $roles          = Role::count();
        $cities         = City::count();
        $wharehouses    = Warehouse::count();
        $products       = Product::count();
        $offers         = Offer::count();
        $boxes          = Box::count();
        $packagins      = Packaging::count();
        $coupons        = Coupon::count();
        $questions      = Question::count();
        $commanQues      = CommanQues::count();
        $reports        = Report::count();
        return view('dashboard.dashboard', 
        compact('users', 'admins', 'cities', 'categories', 'wharehouses', 'products', 'offers', 'boxes', 'packagins','coupons','questions','reports','roles','commanQues'));
    }

    public function loginForm()
    {
        return view('dashboard.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $rememberme = $request->rememberme == 1 ? true : false;
        if (auth()->guard()->attempt(['email' => $request->email, 'password' => $request->password], $rememberme)) {
            $user         = User::findOrFail(auth()->user()->id);
            $user->active = 1;
            $user->save();
            return redirect()->route('dashboard');
        } else {
            if (User::where('email', $request->email)->count() == 0) {
                session()->flash('error_email', 'تحقق من صحة البريد الالكتروني');
            } else {
                session()->flash('error_password', 'تحقق من صحة كلمة المرور');
            }
            return redirect()->route('loginForm');
        }
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/');
    }
}
