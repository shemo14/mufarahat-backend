<?php

namespace App\Http\Controllers\Admin;


use App\Models\Product;
use App\Models\Categories;
use App\Helpers\UploadFile;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Products\Store;
use App\Http\Requests\Products\Update;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    public function index()
    {
        $products   = Product::get();
        $categories = Categories::get();
        return view('dashboard.products.index', compact('products','categories'));
    }

    public function store(Store $request)
    {
        if ($request->file('images')) {
            $product =  Product::create($request->all());
            foreach ($request->file('images') as $row) {
                $avatar = UploadFile::uploadImage($row, 'products');
                ProductImage::create(['name'=>$avatar,'product_id'=>$product->id]);
            }
        }else {
            return back()->withErrors('يجب اضافه صوره واحده علي الاقل ');
        }
        addReport(auth()->user()->id, 'باضافة منتج جديد  ', $request->ip());
        Session::flash('success', 'تم اضافة المنتج بنجاح');
        return back();
    }

    public function update(Update $request)
    {
        $product =  Product::find($request->id);
        $product =  $product->update($request->all());
        if ($request->file('images')) {
            foreach ($request->file('images') as $row) {
            $avatar = UploadFile::uploadImage($row, 'products');
                ProductImage::create(['name'=>$avatar,'product_id'=>$product->id]);
            }
        }
        addReport(auth()->user()->id, 'بتعديل منتج جديد  ', $request->ip());
        Session::flash('success', 'تم تعديل المنتج بنجاح');
        return back();
    }

    public function delete(Request $request)
    {
        Product::findOrFail($request->delete_id)->delete();
        addReport(auth()->user()->id, 'بحذف منتج', $request->ip());
        Session::flash('success', 'تم حذف المنتج بنجاح');
        return back();
    }



    public function deleteImg($id){

        $image =  ProductImage::find($id);
        $product = Product::find($image->product_id);
        if ($product->images->count() > 1) {
            $image->delete();
            Session::flash('success', 'تم حذف صوره الاعلان بنجاح');
        }else {
            Session::flash('success', 'لايمكن حذف الصوره يجب توافر صوره للاعلان');
        }
        return back();
    }

}
