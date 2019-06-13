<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpBalanceRequest extends FormRequest
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

            'sum' => 'required|integer',
            'type' => 'required|integer',
            'check' => 'required|mimes:png,jpg,jpeg'
        ];
    }
}

