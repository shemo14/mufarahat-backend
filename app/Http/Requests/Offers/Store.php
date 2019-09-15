<?php

namespace App\Http\Requests\Offers;

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
            'product_id'          => 'required|numeric',
<<<<<<< HEAD
            'discount'            => 'required|numeric',
=======
//            'discount'            => 'required|numeric|max:3',
>>>>>>> a95a103d3afedd9d13935de4e071bd2a02133081
            'time'                => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required'   => 'يجب اختيار المنتج المراد من العرض',
            'product_id.numeric'    => 'يجب اختيار المنتج المراد من العرض',

            'discount.required'     => 'يجب ادخال قيمه التخفيض',
            'discount.numeric'      => 'يجب ان تكون القيمه رقميه',
            'discount.max'          => 'يجب ان تكون قميمه التخفيض حقيقيه ',

            'time.required'         => 'يجب ادخال مده العرض ',
            'time.numeric'          => 'يجب ان تكون مده رقميه',
            
        ];  
    }
}
