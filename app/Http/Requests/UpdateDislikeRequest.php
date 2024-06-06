<?php

namespace App\Http\Requests;

use App\Models\Dislike;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDislikeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dislike_edit');
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
