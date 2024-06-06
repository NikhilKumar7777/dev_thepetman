@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.reportsAbuse.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reports-abuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.reportsAbuse.fields.id') }}
                        </th>
                        <td>
                            {{ $reportsAbuse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reportsAbuse.fields.user') }}
                        </th>
                        <td>
                            {{ $reportsAbuse->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reportsAbuse.fields.post') }}
                        </th>
                        <td>
                            {{ $reportsAbuse->post->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reports-abuses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection