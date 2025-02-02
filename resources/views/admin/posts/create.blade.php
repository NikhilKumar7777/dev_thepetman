@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.post.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.posts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.post.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="body">{{ trans('cruds.post.fields.body') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="body">{!! old('body') !!}</textarea>
                @if($errors->has('body'))
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.body_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="images">{{ trans('cruds.post.fields.images') }}</label>
                <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                </div>
                @if($errors->has('images'))
                    <span class="text-danger">{{ $errors->first('images') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.images_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.post.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="like_count">{{ trans('cruds.post.fields.like_count') }}</label>
                <input class="form-control {{ $errors->has('like_count') ? 'is-invalid' : '' }}" type="number" name="like_count" id="like_count" value="{{ old('like_count', '0') }}" step="1" required>
                @if($errors->has('like_count'))
                    <span class="text-danger">{{ $errors->first('like_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.like_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unlike_count">{{ trans('cruds.post.fields.unlike_count') }}</label>
                <input class="form-control {{ $errors->has('unlike_count') ? 'is-invalid' : '' }}" type="number" name="unlike_count" id="unlike_count" value="{{ old('unlike_count', '0') }}" step="1" required>
                @if($errors->has('unlike_count'))
                    <span class="text-danger">{{ $errors->first('unlike_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.unlike_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="view_count">{{ trans('cruds.post.fields.view_count') }}</label>
                <input class="form-control {{ $errors->has('view_count') ? 'is-invalid' : '' }}" type="number" name="view_count" id="view_count" value="{{ old('view_count', '0') }}" step="1" required>
                @if($errors->has('view_count'))
                    <span class="text-danger">{{ $errors->first('view_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.view_count_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_report') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_report" value="0">
                    <input class="form-check-input" type="checkbox" name="is_report" id="is_report" value="1" {{ old('is_report', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_report">{{ trans('cruds.post.fields.is_report') }}</label>
                </div>
                @if($errors->has('is_report'))
                    <span class="text-danger">{{ $errors->first('is_report') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.is_report_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="answer_count">{{ trans('cruds.post.fields.answer_count') }}</label>
                <input class="form-control {{ $errors->has('answer_count') ? 'is-invalid' : '' }}" type="number" name="answer_count" id="answer_count" value="{{ old('answer_count', '0') }}" step="1" required>
                @if($errors->has('answer_count'))
                    <span class="text-danger">{{ $errors->first('answer_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.answer_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.post.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Post::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="categories">{{ trans('cruds.post.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="option_1">{{ trans('cruds.post.fields.option_1') }}</label>
                <input class="form-control {{ $errors->has('option_1') ? 'is-invalid' : '' }}" type="text" name="option_1" id="option_1" value="{{ old('option_1', '') }}" required>
                @if($errors->has('option_1'))
                    <span class="text-danger">{{ $errors->first('option_1') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.option_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="option_2">{{ trans('cruds.post.fields.option_2') }}</label>
                <input class="form-control {{ $errors->has('option_2') ? 'is-invalid' : '' }}" type="text" name="option_2" id="option_2" value="{{ old('option_2', '') }}" required>
                @if($errors->has('option_2'))
                    <span class="text-danger">{{ $errors->first('option_2') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.option_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_3">{{ trans('cruds.post.fields.option_3') }}</label>
                <input class="form-control {{ $errors->has('option_3') ? 'is-invalid' : '' }}" type="text" name="option_3" id="option_3" value="{{ old('option_3', '') }}">
                @if($errors->has('option_3'))
                    <span class="text-danger">{{ $errors->first('option_3') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.option_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="option_4">{{ trans('cruds.post.fields.option_4') }}</label>
                <input class="form-control {{ $errors->has('option_4') ? 'is-invalid' : '' }}" type="text" name="option_4" id="option_4" value="{{ old('option_4', '') }}">
                @if($errors->has('option_4'))
                    <span class="text-danger">{{ $errors->first('option_4') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.option_4_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.post.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.post.fields.user_helper') }}</span>
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
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.posts.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $post->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.posts.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
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
      $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
      uploadedImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImagesMap[file.name]
      }
      $('form').find('input[name="images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($post) && $post->images)
      var files = {!! json_encode($post->images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
        }
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