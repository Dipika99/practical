<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'name' => 'required|min:4|max:50',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'description' => 'required',
            'activation_start_date' => 'required|date_format:m/d/Y',
            'activation_end_date' => 'required|date_format:m/d/Y|after_or_equal:activation_start_date',
        ];
    }

    public function attributes(){

        return [
            'category_id'=>'category',
            'sub_category_id'=>'sub category',
        ];
    }
}
