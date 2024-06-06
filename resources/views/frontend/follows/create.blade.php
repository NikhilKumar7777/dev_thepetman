@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.follow.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.follows.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="follower_id">{{ trans('cruds.follow.fields.follower') }}</label>
                            <select class="form-control select2" name="follower_id" id="follower_id">
                                @foreach($followers as $id => $entry)
                                    <option value="{{ $id }}" {{ old('follower_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('follower'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('follower') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.follow.fields.follower_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="following_id">{{ trans('cruds.follow.fields.following') }}</label>
                            <select class="form-control select2" name="following_id" id="following_id" required>
                                @foreach($followings as $id => $entry)
                                    <option value="{{ $id }}" {{ old('following_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('following'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('following') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.follow.fields.following_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection