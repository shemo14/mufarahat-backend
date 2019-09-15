<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'           => 'required|min:2|max:190',
            'name_en'           => 'required|min:2|max:190',
            'description_ar'    => 'required|min:10',
            'description_en'    => 'required|min:10',
            'quantity'          => 'required|numeric',
            'price'             => 'required|numeric',
            'category_id'       => 'required',
            'images'           => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required'        => 'يجب ادخال اسم المنتج بالعربيه',
            'name_ar.min'             => 'يجب ان يكون الاسم اكبر من حرفين    ',
            'name_ar.max'             => 'يجب ان يكون الاسم اصغر من 190 حرف      ',
            'name_en.required'        => 'يجب ادخال اسم المنتج بالانجليزيه',
            'name_en.min'             => 'يجب ان يكون الاسم اكبر من حرفين    ',
            'name_en.max'             => 'يجب ان يكون الاسم اضغر من 190 حرف      ',
            'description_ar.required' => 'يجب ادخال وصف المنتج بالانجليزيه',
            'description_ar.min'      => 'يجب ان يكون الوصف اكبر من 10حروف    ',
            'description_en.required' => 'يجب ادخال وصف المنتج بالانجليزيه',
            'description_en.min'      => 'يجب ان يكون الوصف اكبر من 10حروف    ',
            'quantity.required'       => 'يجب ادخال الكميه المتاحه ',
            'quantity.numeric'        => 'يجب ان تكون الكميه رقم    ',
            'price.required'          => 'يجب ادخال السعر',
            'price.numeric'           => 'يجب ان تكون السعر  رقم    ',
            'category_id.required'    => 'يجب ان تكون السعر  رقم    ',
            'images.required'         => 'يجب اضافه صوره واحده علي الاقل',
        ];  
    }
}
