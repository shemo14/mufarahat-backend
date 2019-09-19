<?php

namespace App\Http\Controllers\Admin;


use App\Models\Box;
use App\Models\BoxItem;
use App\Models\Product;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use App\Http\Requests\Boxs\Store;
use App\Http\Requests\Boxs\Update;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class BoxsController extends Controller
{
    public function index()
    {
        $boxes  = Box::get();
        $products = Product::get();
        return view('dashboard.boxes.index', compact('boxes','products'));
    }

    public function store(Store $request)
    {
        if ($request->file('image2')) {
            $avatar = UploadFile::uploadImage($request->file('image2'), 'boxes');
            $request['image']= $avatar;
            
            if ($request->product) {
                $boxStored =  Box::create($request->all());
                foreach ($request->product as $key1 => $value1) {
                    foreach ($request->ammounts as $key2 => $value2) {
                        if ($key1 == $key2) {
                            $checkThatProductExists = BoxItem::where(['box_id' => $boxStored->id , 'product_id' => $value1])->get();
                            if ($checkThatProductExists->count() == 0 ) {
                                BoxItem::create([
                                    'box_id'     => $boxStored->id,
                                    'product_id' => $value1,
                                    'quantity'   => $value2,
                                ]);
                            }else{
                                $checkThatProductExists->first()->update([
                                    'box_id'     => $boxStored->id,
                                    'product_id' => $value1,
                                    'quantity'   => $value2+$checkThatProductExists->first()->quantity,
                                ]);
                            }
                        }
                    }  
                }
            }else {
                return back()->withErrors('يجب اختيار منتج واحد علي الاقل');
            }

        }else {
            return back()->withErrors('يجب اضافه الصوره');
        }
        addReport(auth()->user()->id, 'باضافة بوكس جديد  ', $request->ip());
        Session::flash('success', 'تم اضافة البوكس بنجاح');
        return back();
    }

    public function update(Update $request)
    {
        if ($request->hasFile('image2')){
            $request['image']    =  UploadFile::uploadImage($request->file('image2'), 'boxes');
        }
        $box = Box::find($request->id);
        $box->update($request->all());
        addReport(auth()->user()->id, 'تعديل بوكس ' . $request['name_ar'] , $request->ip());
        Session::flash('success', 'تم تعديل البوكس بنجاح');
        return back();
        
    }


    public function updateBoxProducts(Request $request)
    {
        if ($request->product)
        {
            $boxitems = BoxItem::where('box_id',$request->box_id)->delete();
            foreach ($request->product as $key1 => $value1) {
                foreach ($request->ammounts as $key2 => $value2) {
                    if ($key1 == $key2) {
                        $checkThatProductExists = BoxItem::where(['box_id' => $request->box_id , 'product_id' => $value1])->get();
                            if ($checkThatProductExists->count() == 0 ) {
                                BoxItem::create([
                                    'box_id'     => $request->box_id,
                                    'product_id' => $value1,
                                    'quantity'   => $value2,
                                ]);
                            }else{
                                $checkThatProductExists->first()->update([
                                    'box_id'     => $request->box_id,
                                    'product_id' => $value1,
                                    'quantity'   => $value2+$checkThatProductExists->first()->quantity,
                                ]);
                            }
                    }
                }  
            }
        }else {
            return back()->withErrors('يجب اضافه منتج واحد علي الاقل ');
        }
        // addReport(auth()->user()->id, 'بتعديل منتجات بوكس', $request->ip());
        Session::flash('success', 'تم تعديل منتجات البوكس  بنجاح');
        return back();
    }

    public function delete(Request $request)
    {
        Box::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف بوكس', $request->ip());
        Session::flash('success', 'تم حذف البوكس بنجاح');
        return back();
    }

    public function deleteAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Box::whereIn('id', $ids)->delete()) {
            addReport(auth()->user()->id, 'قام بحذف العديد من المدن', $request->ip());
            Session::flash('success', 'تم الحذف بنجاح');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
