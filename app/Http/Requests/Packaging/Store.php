<?php

namespace App\Http\Requests\Packaging;

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
            'name_ar'          => 'required',
            'name_en'          => 'required',
            'price'            => 'required|numeric',
        ];
    }


    public function messages()
    {
        return [
            'name_en.required'     => 'يجب ادخال  الاسم بالانجليزيه',
            'name_ar.required'     => 'يجب ادخال  الاسم بالعربيه',
            'price.required'         => 'يجب ادخال  السعر ',
        ];  
    }

}
