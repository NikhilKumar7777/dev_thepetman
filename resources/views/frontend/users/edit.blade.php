@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.users.update", [$user->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control" type="password" name="password" id="password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="approved" value="0">
                                <input type="checkbox" name="approved" id="approved" value="1" {{ $user->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                                <label for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                            </div>
                            @if($errors->has('approved'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('approved') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="roles[]" id="roles" multiple required>
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="social_token">{{ trans('cruds.user.fields.social_token') }}</label>
                            <input class="form-control" type="text" name="social_token" id="social_token" value="{{ old('social_token', $user->social_token) }}">
                            @if($errors->has('social_token'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('social_token') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.social_token_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="social_platform">{{ trans('cruds.user.fields.social_platform') }}</label>
                            <input class="form-control" type="text" name="social_platform" id="social_platform" value="{{ old('social_platform', $user->social_platform) }}">
                            @if($errors->has('social_platform'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('social_platform') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.social_platform_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="categories">{{ trans('cruds.user.fields.category') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="categories[]" id="categories" multiple>
                                @foreach($categories as $id => $category)
                                    <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || $user->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('categories'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('categories') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.category_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.user.fields.profile_status') }}</label>
                            <select class="form-control" name="profile_status" id="profile_status">
                                <option value disabled {{ old('profile_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\User::PROFILE_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('profile_status', $user->profile_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('profile_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('profile_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.profile_status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', $user->city) }}">
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="about">{{ trans('cruds.user.fields.about') }}</label>
                            <textarea class="form-control" name="about" id="about">{{ old('about', $user->about) }}</textarea>
                            @if($errors->has('about'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('about') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.about_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="bio">{{ trans('cruds.user.fields.bio') }}</label>
                            <textarea class="form-control" name="bio" id="bio">{{ old('bio', $user->bio) }}</textarea>
                            @if($errors->has('bio'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bio') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bio_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="team_id">{{ trans('cruds.user.fields.team') }}</label>
                            <select class="form-control select2" name="team_id" id="team_id">
                                @foreach($teams as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('team_id') ? old('team_id') : $user->team->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('team'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('team') }}
                                </div>
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

        </div>
    </div>
</div>
@endsection