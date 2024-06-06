@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.vote.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.votes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.vote.fields.id') }}
                        </th>
                        <td>
                            {{ $vote->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vote.fields.user') }}
                        </th>
                        <td>
                            {{ $vote->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vote.fields.post') }}
                        </th>
                        <td>
                            {{ $vote->post->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.vote.fields.vote') }}
                        </th>
                        <td>
                            {{ App\Models\Vote::VOTE_SELECT[$vote->vote] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.votes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection