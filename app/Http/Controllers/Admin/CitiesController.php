<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
{
    public function index()
    {
        $cities = City::get();
        return view('dashboard.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name_ar'              => 'required|min:2|max:190',
            'name_en'              => 'required|min:2|max:190',
            'shipping'             => 'required',
            
        ];
        // Validation
        $validator = validator($request->all(), $rules);
        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
       $city =   City::create([
            'name_ar'              => $request['name_ar'],
            'name_en'              => $request['name_en'],
            'shipping'             => $request['shipping'],
            
        ]);
        $ip = $request->ip();

        addReport(auth()->user()->id, 'باضافة مدينه ', $ip);
        Session::flash('success', 'تم اضافة المدينه بنجاح');
        return back();
    }

    public function update(Request $request)
    {

        // Validation rules
        $rules = [
            'edit_name_ar'     => 'required|min:2|max:190',
            'edit_name_en'     => 'required|min:2|max:190',
            'edit_shipping'    => 'required|min:2|max:190',
            
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $city = City::findOrFail($request->id);


        $city->name_ar     = $request->edit_name_ar;
        $city->name_en     = $request->edit_name_en;
        $city->shipping     = $request->edit_shipping;
        
        $city->save();
        $ip = $request->ip();

        addReport(auth()->user()->id, 'بتعديل بيانات المدينه', $ip);
        Session::flash('success', 'تم تعديل المدينه بنجاح');
        return back();
    }


    
    public function delete(Request $request)
    {
        City::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف المدينه', $request->ip());
        Session::flash('success', 'تم حذف المدينه بنجاح');
        return back();
    }
}
