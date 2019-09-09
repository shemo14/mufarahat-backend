<?php

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Warehouse;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WarehousesController extends Controller
{

    public function index()
    {
        $warehouses = Warehouse::get();
        $cities     = City::get();
        return view('dashboard.Warehouses.index', compact('warehouses','cities'));
    }


    
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name'       => 'required|min:2|max:190',
            'phone'      => 'required|min:2|max:190',
            'address'    => 'required',
            'city_id'    => 'required',
            
        ];

        // Validator messages
        $messages = [
            'name.required'     => 'الاسم مطلوب',
            'name.min'          => 'الاسم لابد ان يكون اكبر من حرفين',
            'name.max'          => 'الاسم لابد ان يكون اصغر من 190 حرف',
            'phone.required'    => 'رقم الهاتف مطلوب',
            'address.required'  => ' العنوان مطلوب',
            'city_id.required'  => 'المدينه مطلوبة',
        ];
        // Validation
        $validator = validator($request->all(), $rules,$messages);
        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
       $Warehouse = Warehouse::create([
            'name'               => $request['name'],
            'phone'              => $request['phone'],
            'address'            => $request['address'],
            'city_id'            => $request['city_id'],
            
        ]);
        $ip = $request->ip();

        addReport(auth()->user()->id, 'باضافة مستودع ', $ip);
        Session::flash('success', 'تم اضافة المستودع بنجاح');
        return back();
    }

    
}
