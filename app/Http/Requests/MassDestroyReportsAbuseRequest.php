<?php

namespace App\Http\Requests;

use App\Models\ReportsAbuse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReportsAbuseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reports_abuse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reports_abuses,id',
        ];
    }
}
