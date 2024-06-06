<?php

namespace App\Http\Requests;

use App\Models\UserAddress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserAddressRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_address_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'phone_no' => [
                'string',
                'min:10',
                'max:10',
                'required',
            ],
            'addressline_1' => [
                'string',
                'required',
            ],
            'addressline_2' => [
                'string',
                'required',
            ],
            'city' => [
                'string',
                'required',
            ],
            'zip_code' => [
                'string',
                'max:6',
                'required',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'type' => [
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
