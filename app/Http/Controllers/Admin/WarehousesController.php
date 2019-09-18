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


    public function update(Request $request)
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
        $validator = Validator::make($request->all(), $rules);

        // If failed
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $Warehouse = Warehouse::findOrFail($request->id);


        $Warehouse->name     = $request->name;
        $Warehouse->phone    = $request->phone;
        $Warehouse->address  = $request->address;
        $Warehouse->city_id  = $request->city_id;
        
        $Warehouse->save();
        $ip = $request->ip();

        addReport(auth()->user()->id, 'بتعديل بيانات المستودع', $ip);
        Session::flash('success', 'تم تعديل المستودع بنجاح');
        return back();
    }


    public function delete(Request $request)
    {
        Warehouse::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف المستودع', $request->ip());
        Session::flash('success', 'تم حذف المستودع بنجاح');
        return back();
    }

    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Warehouse::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من المدن', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }

    
}
