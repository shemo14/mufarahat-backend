<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\City;
use App\Models\Role;
use App\Models\Order;
use App\Models\Delegate;
use App\Models\Warehouse;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class DelegateController extends Controller
{
    public function index(User $user)
    {
        $users = User::with('dalegateInformation')->where('role', 0)->where('type','delegate')->where('checked',1)->latest()->get();
        $cities = City::get();
        $warehouses = Warehouse::get();
        return view('dashboard.delegates.index', compact('users','cities','warehouses'));
    }

    public function index2(User $user)
    {
        $users = User::with('dalegateInformation')->where('role', 0)->where('type','delegate')->where('checked',0)->latest()->get();
        $cities = City::get();
        $warehouses = Warehouse::get();
        return view('dashboard.delegates.index2', compact('users','cities','warehouses'));
    }

    public function activate(Request  $request)
    {
        $delegate = User::findOrFail($request->active_id);
        $delegate->checked   = $delegate->checked > 0 ? 0 : 1 ;
        $message  = $delegate->checked > 0 ? '' : 'الغاء';
        $delegate->save();
        $ip = $request->ip();
        addReport(auth()->user()->id, $message.' تفعيل مندوب ', $ip);
        Session::flash('success', 'تم  '.$message.' التفعيل بنجاح ');
        return back();

    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name'              => 'required|min:2|max:190',
            'phone'             => 'required|unique:users,phone',
            'email'             => 'required|email|unique:users,email',
            'address'           => 'required',
            'password'          => 'required',
            'city_id'           => 'required',
            'warehouse_id'      => 'required',
            'licenses_image'    => 'image|required',
            'car_image'         => 'required|image',
            'avatar'            => 'nullable|image'
        ];
        // Validation
        $validator = validator($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        if ($request->hasFile('avatar')) {
            $avatar = UploadFile::uploadImage($request->file('avatar'), 'users');
        } else {
            $avatar = 'default.png';
        }

       


        // Save User
       $user =   User::create([
            'name'              => $request['name'],
            'phone'             => convert2english($request['phone']),
            'email'             => $request['email'],
            'address'           => $request['address'],
            'password'          => bcrypt($request['password']),
            'city_id'           => $request['city_id'],
            'avatar'            => $avatar,
            'lat'               => $request['lat'],
            'long'              => $request['long'],
            'active'            => 1 ,
            'checked'           => 1 ,
            'type'              =>'delegate'
        ]);

        $car_image = UploadFile::uploadImage($request->file('car_image'), 'users/cars');
        $licenses_image = UploadFile::uploadImage($request->file('licenses_image'), 'users/licenses');

        $delegate = Delegate::create([
            'user_id'           =>$user->id,
            'car_image'         => $car_image,
            'licenses_image'    => $licenses_image,
            'warehouse_id'      => $request['warehouse_id'],
        ]);

        $ip = $request->ip();

        addReport(auth()->user()->id, 'باضافة مندوب جديد', $ip);
        Session::flash('success', 'تم اضافة المندوب بنجاح');
        return back();
    }

    public function update(Request $request)
    {

        // Validation rules
        $rules = [
            'edit_name'     => 'required|min:2|max:190',
            'edit_phone'    => 'required|unique:users,phone,' . $request->id,
            'edit_email'    => 'required|email|unique:users,email,' . $request->id,
            'edit_address'  => 'required',
            'city_id'       => 'required',
            'warehouse_id'  => 'required'
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = User::findOrFail($request->id);

        if ($request->has('avatar')) {
            if ($user->avatar != 'default.png') {
                File::delete(public_path('images/users/' . $user->avatar));
            }

            $user->avatar = UploadFile::uploadImage($request->file('avatar'), 'users');
        }
        
        if (isset($request->password) || $request->password != null) {
            $user->password = bcrypt($request->password);
        }

        $user->name     = $request->edit_name;
        $user->city_id     = $request->city_id;
        $user->address     = $request->edit_address;
        // $user->lat      = $request->edit_lat;
        // $user->lng      = $request->edit_lng;
        $user->phone    = convert2english($request->edit_phone);
        $user->email    = $request->edit_email;
        $user->save();

        $delegate = Delegate::where('user_id',$user->id)->first();

        if ($request->has('car_image')) {
            if ($delegate->car_image != 'default.png') {
                File::delete(public_path('images/users/cars/' . $delegate->avatar));
            }
            $delegate->car_image = UploadFile::uploadImage($request->file('car_image'), 'users/cars');
        }
        if ($request->has('licenses_image')) {
            if ($delegate->licenses_image != 'default.png') {
                File::delete(public_path('images/users/licenses/' . $delegate->licenses_image));
            }

            $delegate->licenses_image = UploadFile::uploadImage($request->file('licenses_image'), 'users');
        }


        $delegate->warehouse_id = $request->warehouse_id;
        $delegate->save();

        $ip = $request->ip();

        addReport(auth()->user()->id, 'بتعديل بيانات العضو', $ip);
        Session::flash('success', 'تم تعديل العضو بنجاح');
        return back();
    }
    
    public function delete(Request $request)
    {
        Delegate::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف المندوب', $request->ip());
        Session::flash('success', 'تم حذف المندوب بنجاح');
        return back();
    }

    public function orders($id){
        $orders = Order::with('dalegate')->with('packaging')->with('coupon')->with('items')->with('city')->with('user')->where('dalegate_id',$id)->get();

        $dalegate = User::find($id);

        return view('dashboard.delegates.orders', compact('orders','dalegate'));
    }
}
