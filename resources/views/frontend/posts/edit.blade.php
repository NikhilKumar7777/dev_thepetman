@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.post.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.posts.update", [$post->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.post.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="body">{{ trans('cruds.post.fields.body') }}</label>
                            <textarea class="form-control ckeditor" name="body" id="body">{!! old('body', $post->body) !!}</textarea>
                            @if($errors->has('body'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('body') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.body_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.post.fields.images') }}</label>
                            <div class="needsclick dropzone" id="images-dropzone">
                            </div>
                            @if($errors->has('images'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('images') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.images_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="slug">{{ trans('cruds.post.fields.slug') }}</label>
                            <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" required>
                            @if($errors->has('slug'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('slug') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.slug_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="like_count">{{ trans('cruds.post.fields.like_count') }}</label>
                            <input class="form-control" type="number" name="like_count" id="like_count" value="{{ old('like_count', $post->like_count) }}" step="1" required>
                            @if($errors->has('like_count'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('like_count') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.like_count_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="unlike_count">{{ trans('cruds.post.fields.unlike_count') }}</label>
                            <input class="form-control" type="number" name="unlike_count" id="unlike_count" value="{{ old('unlike_count', $post->unlike_count) }}" step="1" required>
                            @if($errors->has('unlike_count'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unlike_count') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.unlike_count_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="view_count">{{ trans('cruds.post.fields.view_count') }}</label>
                            <input class="form-control" type="number" name="view_count" id="view_count" value="{{ old('view_count', $post->view_count) }}" step="1" required>
                            @if($errors->has('view_count'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('view_count') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.view_count_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="is_report" value="0">
                                <input type="checkbox" name="is_report" id="is_report" value="1" {{ $post->is_report || old('is_report', 0) === 1 ? 'checked' : '' }}>
                                <label for="is_report">{{ trans('cruds.post.fields.is_report') }}</label>
                            </div>
                            @if($errors->has('is_report'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_report') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.is_report_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="answer_count">{{ trans('cruds.post.fields.answer_count') }}</label>
                            <input class="form-control" type="number" name="answer_count" id="answer_count" value="{{ old('answer_count', $post->answer_count) }}" step="1" required>
                            @if($errors->has('answer_count'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('answer_count') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.answer_count_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.post.fields.type') }}</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Post::TYPE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $post->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="categories">{{ trans('cruds.post.fields.category') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                @foreach($categories as $id => $category)
                                    <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || $post->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('categories'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('categories') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.category_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="option_1">{{ trans('cruds.post.fields.option_1') }}</label>
                            <input class="form-control" type="text" name="option_1" id="option_1" value="{{ old('option_1', $post->option_1) }}" required>
                            @if($errors->has('option_1'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('option_1') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.option_1_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="option_2">{{ trans('cruds.post.fields.option_2') }}</label>
                            <input class="form-control" type="text" name="option_2" id="option_2" value="{{ old('option_2', $post->option_2) }}" required>
                            @if($errors->has('option_2'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('option_2') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.option_2_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="option_3">{{ trans('cruds.post.fields.option_3') }}</label>
                            <input class="form-control" type="text" name="option_3" id="option_3" value="{{ old('option_3', $post->option_3) }}">
                            @if($errors->has('option_3'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('option_3') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.option_3_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="option_4">{{ trans('cruds.post.fields.option_4') }}</label>
                            <input class="form-control" type="text" name="option_4" id="option_4" value="{{ old('option_4', $post->option_4) }}">
                            @if($errors->has('option_4'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('option_4') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.post.fields.option_4_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.post.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $post->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
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

        </div>
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
                xhr.open('POST', '{{ route('frontend.posts.storeCKEditorImages') }}', true);
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
    url: '{{ route('frontend.posts.storeMedia') }}',
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