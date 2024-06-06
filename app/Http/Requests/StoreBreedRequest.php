<?php

namespace App\Http\Requests;

use App\Models\Breed;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBreedRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('breed_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
            'breed' => [
                'string',
                'required',
            ],
        ];
    }
}
