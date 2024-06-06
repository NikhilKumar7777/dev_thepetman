<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'images' => [
                'array',
            ],
            'slug' => [
                'string',
                'required',
                'unique:posts,slug,' . request()->route('post')->id,
            ],
            'like_count' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unlike_count' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'view_count' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'answer_count' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'type' => [
                'required',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'required',
                'array',
            ],
            'option_1' => [
                'string',
                'required',
            ],
            'option_2' => [
                'string',
                'required',
            ],
            'option_3' => [
                'string',
                'nullable',
            ],
            'option_4' => [
                'string',
                'nullable',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
