<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Categories;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Coupons\Update;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    public function index()
    {
        $Categories = Categories::get();
        $coupons = Coupon::get();
        return view('dashboard.coupons.index', compact('coupons','Categories'));
    }

    public function store(Store $request)
    {
        $Coupon = Coupon::create($request->all());
        addReport(auth()->user()->id, 'باضافة كوبون جديد    ', $request->ip());
        Session::flash('success', 'تم اضافة الكوبون  بنجاح');
        return back();
    }

    public function update(Update $request)
    {
        $Coupon = Coupon::find($request->id);
        $Coupon->update($request->all());
        Session::flash('success', 'تم تعديل الكوبون  بنجاح');
        return back();
    }

    public function delete(Request $request)
    {
        Coupon::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف كوبون ', $request->ip());
        Session::flash('success', 'تم حذف الكوبون بنجاح');
        return back();
    }
    
    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Coupon::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من المدن', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
