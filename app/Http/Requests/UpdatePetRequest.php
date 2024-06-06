<?php

namespace App\Http\Requests;

use App\Models\Pet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pet_edit');
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
