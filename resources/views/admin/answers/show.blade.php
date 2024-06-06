@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.answer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.answers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.answer.fields.id') }}
                        </th>
                        <td>
                            {{ $answer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.answer.fields.post') }}
                        </th>
                        <td>
                            {{ $answer->post->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.answer.fields.user') }}
                        </th>
                        <td>
                            {{ $answer->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.answer.fields.answer') }}
                        </th>
                        <td>
                            {{ $answer->answer }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.answers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#answer_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.comment.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="answer_comments">
            @includeIf('admin.answers.relationships.answerComments', ['comments' => $answer->answerComments])
        </div>
    </div>
</div>

@endsection