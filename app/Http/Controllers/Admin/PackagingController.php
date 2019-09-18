<?php

namespace App\Http\Controllers\Admin;


use App\Models\Packaging;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Packaging\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PackagingController extends Controller
{
    public function index()
    {
        $packagings = Packaging::get();
        return view('dashboard.packaging.index', compact('packagings'));
    }

    public function store(Store $request)
    {
        $boxStored = Packaging::create($request->all());
        
        addReport(auth()->user()->id, 'باضافة نوع تغليف جديد  ', $request->ip());
        Session::flash('success', 'تم اضافة نوع التغليف بنجاح');
        return back();
    }

    public function update(Request $request)
    {
        $Packaging = Packaging::find($request->id);
        $Packaging->update($request->all());
        Session::flash('success', 'تم تعديل النوع  بنجاح');
        return back();
    }

    public function delete(Request $request)
    {
        Packaging::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف نوع تغليف', $request->ip());
        Session::flash('success', 'تم حذف النوع بنجاح');
        return back();
    }

    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Packaging::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من المدن', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
