<?php

namespace App\Http\Requests;

use App\Models\View;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreViewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('view_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'post_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
