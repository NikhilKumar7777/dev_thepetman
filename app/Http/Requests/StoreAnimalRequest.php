<?php

namespace App\Http\Requests;

use App\Models\Animal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAnimalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('animal_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:animals',
            ],
            'breed_id' => [
                'required',
                'integer',
            ],
            'pet_type' => [
                'required',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
