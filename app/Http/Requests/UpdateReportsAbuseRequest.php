<?php

namespace App\Http\Requests;

use App\Models\ReportsAbuse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReportsAbuseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reports_abuse_edit');
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
