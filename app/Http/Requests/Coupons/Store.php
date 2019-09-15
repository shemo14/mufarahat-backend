<?php

namespace App\Http\Requests\Coupons;

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
            'number'          => 'required|unique:coupons',
            'usage_number'    => 'required|numeric',
            'expire_date'     => 'required|date',
            'category_id'     => 'required|numeric',
            'discount'        => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [

            'number.required'   => 'يجب ادخال رقم الكوبون ',
            'number.unique'    => 'هذا الرقم مستخدم من قبل ',


            'usage_number.required'   => 'يجب ادخال عد مرات الاستخدام',
            'usage_number.numeric'    => 'يجب  ان تكون عدد مرات الاستخدام رقما  ',


            'discount.required'     => 'يجب ادخال قيمه التخفيض',
            'discount.numeric'      => 'يجب ان تكون القيمه رقميه',
            'discount.max'          => 'يجب ان تكون قميمه التخفيض حقيقيه ',

            'category_id.required'         => 'يجب اختيار القسم    ',
            'category_id.numeric'         => 'يجب اختيار القسم    ',
            
        ];  
    }
}
