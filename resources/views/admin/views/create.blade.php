@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.view.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.views.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.view.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.view.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.view.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ old('post_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.view.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection