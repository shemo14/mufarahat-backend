<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Offers\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OffersController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $offers   = Offer::with('product')->get();
        return view('dashboard.offers.index', compact('offers','products'));
    }

    public function store(Store $request)
    {
        $request->expire_date = Carbon::now()->addHours($request->time);
        $Offer =  Offer::create($request->all());


        addReport(auth()->user()->id, 'باضافة عرض جديد  ', $request->ip());
        Session::flash('success', 'تم اضافة العرض بنجاح');
        return back();
    }

    public function update(Store $request)
    {
        $offer =  Offer::find($request->id);
        $offer =  $offer->update($request->all());
        
        addReport(auth()->user()->id, 'بتعديل عرض   ', $request->ip());
        Session::flash('success', 'تم تعديل العرض بنجاح');
        return back();
    }


    public function delete(Request $request)
    {
        Offer::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف عرض', $request->ip());
        Session::flash('success', 'تم حذف العرض بنجاح');
        return back();
    }

    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Offer::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من العروض', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
