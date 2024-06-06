@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approved" value="0">
                    <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ old('approved', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                </div>
                @if($errors->has('approved'))
                    <span class="text-danger">{{ $errors->first('approved') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="social_token">{{ trans('cruds.user.fields.social_token') }}</label>
                <input class="form-control {{ $errors->has('social_token') ? 'is-invalid' : '' }}" type="text" name="social_token" id="social_token" value="{{ old('social_token', '') }}">
                @if($errors->has('social_token'))
                    <span class="text-danger">{{ $errors->first('social_token') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.social_token_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="social_platform">{{ trans('cruds.user.fields.social_platform') }}</label>
                <input class="form-control {{ $errors->has('social_platform') ? 'is-invalid' : '' }}" type="text" name="social_platform" id="social_platform" value="{{ old('social_platform', '') }}">
                @if($errors->has('social_platform'))
                    <span class="text-danger">{{ $errors->first('social_platform') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.social_platform_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="categories">{{ trans('cruds.user.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.user.fields.profile_status') }}</label>
                <select class="form-control {{ $errors->has('profile_status') ? 'is-invalid' : '' }}" name="profile_status" id="profile_status">
                    <option value disabled {{ old('profile_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\User::PROFILE_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('profile_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('profile_status'))
                    <span class="text-danger">{{ $errors->first('profile_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.profile_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.user.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="about">{{ trans('cruds.user.fields.about') }}</label>
                <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{{ old('about') }}</textarea>
                @if($errors->has('about'))
                    <span class="text-danger">{{ $errors->first('about') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.about_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bio">{{ trans('cruds.user.fields.bio') }}</label>
                <textarea class="form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}" name="bio" id="bio">{{ old('bio') }}</textarea>
                @if($errors->has('bio'))
                    <span class="text-danger">{{ $errors->first('bio') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.bio_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="age">{{ trans('cruds.user.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" name="age" id="age">{{ old('age') }}</input>
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="team_id">{{ trans('cruds.user.fields.team') }}</label>
                <select class="form-control select2 {{ $errors->has('team') ? 'is-invalid' : '' }}" name="team_id" id="team_id">
                    @foreach($teams as $id => $entry)
                        <option value="{{ $id }}" {{ old('team_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('team'))
                    <span class="text-danger">{{ $errors->first('team') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.team_helper') }}</span>
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