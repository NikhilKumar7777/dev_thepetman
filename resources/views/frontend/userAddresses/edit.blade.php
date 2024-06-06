@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.userAddress.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.user-addresses.update", [$userAddress->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.userAddress.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $userAddress->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_no">{{ trans('cruds.userAddress.fields.phone_no') }}</label>
                            <input class="form-control" type="text" name="phone_no" id="phone_no" value="{{ old('phone_no', $userAddress->phone_no) }}" required>
                            @if($errors->has('phone_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.phone_no_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="addressline_1">{{ trans('cruds.userAddress.fields.addressline_1') }}</label>
                            <input class="form-control" type="text" name="addressline_1" id="addressline_1" value="{{ old('addressline_1', $userAddress->addressline_1) }}" required>
                            @if($errors->has('addressline_1'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('addressline_1') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.addressline_1_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="addressline_2">{{ trans('cruds.userAddress.fields.addressline_2') }}</label>
                            <input class="form-control" type="text" name="addressline_2" id="addressline_2" value="{{ old('addressline_2', $userAddress->addressline_2) }}" required>
                            @if($errors->has('addressline_2'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('addressline_2') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.addressline_2_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.userAddress.fields.city') }}</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', $userAddress->city) }}" required>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="zip_code">{{ trans('cruds.userAddress.fields.zip_code') }}</label>
                            <input class="form-control" type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $userAddress->zip_code) }}" required>
                            @if($errors->has('zip_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('zip_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.zip_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="state">{{ trans('cruds.userAddress.fields.state') }}</label>
                            <input class="form-control" type="text" name="state" id="state" value="{{ old('state', $userAddress->state) }}">
                            @if($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.state_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.userAddress.fields.type') }}</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\UserAddress::TYPE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $userAddress->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="default" value="0">
                                <input type="checkbox" name="default" id="default" value="1" {{ $userAddress->default || old('default', 0) === 1 ? 'checked' : '' }}>
                                <label for="default">{{ trans('cruds.userAddress.fields.default') }}</label>
                            </div>
                            @if($errors->has('default'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('default') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.default_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.userAddress.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $userAddress->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userAddress.fields.user_helper') }}</span>
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