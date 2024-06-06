<?php

namespace App\Http\Requests;

use App\Models\Follow;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFollowRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('follow_create');
    }

    public function rules()
    {
        return [
            'following_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
