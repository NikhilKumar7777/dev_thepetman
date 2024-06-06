@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.animal.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.animals.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.animal.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="icon">{{ trans('cruds.animal.fields.icon') }}</label>
                <div class="needsclick dropzone {{ $errors->has('icon') ? 'is-invalid' : '' }}" id="icon-dropzone">
                </div>
                @if($errors->has('icon'))
                    <span class="text-danger">{{ $errors->first('icon') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.icon_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.animal.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Animal::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="breed_id">{{ trans('cruds.animal.fields.breed') }}</label>
                <select class="form-control select2 {{ $errors->has('breed') ? 'is-invalid' : '' }}" name="breed_id" id="breed_id" required>
                    @foreach($breeds as $id => $entry)
                        <option value="{{ $id }}" {{ old('breed_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('breed'))
                    <span class="text-danger">{{ $errors->first('breed') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.breed_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.animal.fields.pet_type') }}</label>
                <select class="form-control {{ $errors->has('pet_type') ? 'is-invalid' : '' }}" name="pet_type" id="pet_type" required>
                    <option value disabled {{ old('pet_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Animal::PET_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('pet_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('pet_type'))
                    <span class="text-danger">{{ $errors->first('pet_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.pet_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.animal.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.animal.fields.user_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.iconDropzone = {
    url: '{{ route('admin.animals.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="icon"]').remove()
      $('form').append('<input type="hidden" name="icon" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="icon"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($animal) && $animal->icon)
      var file = {!! json_encode($animal->icon) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="icon" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection