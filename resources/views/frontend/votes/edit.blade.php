@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.vote.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.votes.update", [$vote->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.vote.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vote->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.vote.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="post_id">{{ trans('cruds.vote.fields.post') }}</label>
                            <select class="form-control select2" name="post_id" id="post_id" required>
                                @foreach($posts as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('post_id') ? old('post_id') : $vote->post->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('post'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('post') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.vote.fields.post_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.vote.fields.vote') }}</label>
                            <select class="form-control" name="vote" id="vote" required>
                                <option value disabled {{ old('vote', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Vote::VOTE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('vote', $vote->vote) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('vote'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vote') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.vote.fields.vote_helper') }}</span>
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