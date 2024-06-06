<?php

namespace App\Http\Requests;

use App\Models\Answer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAnswerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('answer_create');
    }

    public function rules()
    {
        return [
            'post_id' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'answer' => [
                'required',
            ],
        ];
    }
}
