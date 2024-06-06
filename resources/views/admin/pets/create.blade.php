@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pet.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pets.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.pet.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Pet::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pet.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="breed">{{ trans('cruds.pet.fields.breed') }}</label>
                <input class="form-control {{ $errors->has('breed') ? 'is-invalid' : '' }}" type="text" name="breed" id="breed" value="{{ old('breed', '') }}" required>
                @if($errors->has('breed'))
                    <span class="text-danger">{{ $errors->first('breed') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pet.fields.breed_helper') }}</span>
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