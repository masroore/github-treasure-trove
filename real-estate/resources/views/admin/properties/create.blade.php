@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.property.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.properties.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="property_title">{{ trans('cruds.property.fields.property_title') }}</label>
                <input class="form-control {{ $errors->has('property_title') ? 'is-invalid' : '' }}" type="text" name="property_title" id="property_title" value="{{ old('property_title', '') }}" required>
                @if($errors->has('property_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_title_helper') }}</span>
            </div>
            <input type="hidden" name="created_by_id" id="created_by_id" value="{{ Auth::user()->id }}">
            <div class="form-group">
                <label class="required" for="property_main_photo">{{ trans('cruds.property.fields.property_main_photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('property_main_photo') ? 'is-invalid' : '' }}" id="property_main_photo-dropzone">
                </div>
                @if($errors->has('property_main_photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_main_photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_main_photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="property_description">{{ trans('cruds.property.fields.property_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('property_description') ? 'is-invalid' : '' }}" name="property_description" id="property_description">{!! old('property_description') !!}</textarea>
                @if($errors->has('property_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.property.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $entry)
                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="rooms">{{ trans('cruds.property.fields.rooms') }}</label>
                <input class="form-control {{ $errors->has('rooms') ? 'is-invalid' : '' }}" type="number" name="rooms" id="rooms" value="{{ old('rooms', '0') }}" step="1" required>
                @if($errors->has('rooms'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rooms') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.rooms_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="property_price">{{ trans('cruds.property.fields.property_price') }}</label>
                <input class="form-control {{ $errors->has('property_price') ? 'is-invalid' : '' }}" type="number" name="property_price" id="property_price" value="{{ old('property_price', '') }}" step="0.01" required>
                @if($errors->has('property_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.property.fields.per') }}</label>
                <select class="form-control {{ $errors->has('per') ? 'is-invalid' : '' }}" name="per" id="per" required>
                    <option value disabled {{ old('per', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Property::PER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('per', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('per'))
                    <div class="invalid-feedback">
                        {{ $errors->first('per') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.per_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="google_map_location">{{ trans('cruds.property.fields.google_map_location') }}</label>
                <textarea class="form-control {{ $errors->has('google_map_location') ? 'is-invalid' : '' }}" name="google_map_location" id="google_map_location" required>{{ old('google_map_location') }}</textarea>
                @if($errors->has('google_map_location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('google_map_location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.google_map_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="year_built">{{ trans('cruds.property.fields.year_built') }}</label>
                <input class="form-control date {{ $errors->has('year_built') ? 'is-invalid' : '' }}" type="text" name="year_built" id="year_built" value="{{ old('year_built') }}" required>
                @if($errors->has('year_built'))
                    <div class="invalid-feedback">
                        {{ $errors->first('year_built') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.year_built_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="area">{{ trans('cruds.property.fields.area') }}</label>
                <input class="form-control {{ $errors->has('area') ? 'is-invalid' : '' }}" type="number" name="area" id="area" value="{{ old('area', '') }}" step="1" required>
                @if($errors->has('area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="property_photos">{{ trans('cruds.property.fields.property_photos') }}</label>
                <div class="needsclick dropzone {{ $errors->has('property_photos') ? 'is-invalid' : '' }}" id="property_photos-dropzone">
                </div>
                @if($errors->has('property_photos'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_photos') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_photos_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="property_video">{{ trans('cruds.property.fields.property_video') }}</label>
                <input class="form-control {{ $errors->has('property_video') ? 'is-invalid' : '' }}" type="text" name="property_video" id="property_video" value="{{ old('property_video', '') }}" required>
                @if($errors->has('property_video'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_video') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.property_video_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="floor_plans">{{ trans('cruds.property.fields.floor_plans') }}</label>
                <div class="needsclick dropzone {{ $errors->has('floor_plans') ? 'is-invalid' : '' }}" id="floor_plans-dropzone">
                </div>
                @if($errors->has('floor_plans'))
                    <div class="invalid-feedback">
                        {{ $errors->first('floor_plans') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.floor_plans_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.property.fields.tags') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ in_array($id, old('tags', [])) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.tags_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.property.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Property::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('available') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="available" id="available" value="1" required {{ old('available', 0) == 1 ? 'checked' : '' }}>
                    <label class="required form-check-label" for="available">{{ trans('cruds.property.fields.available') }}</label>
                </div>
                @if($errors->has('available'))
                    <div class="invalid-feedback">
                        {{ $errors->first('available') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.available_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('feature_property') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="feature_property" value="0">
                    <input class="form-check-input" type="checkbox" name="feature_property" id="feature_property" value="1" {{ old('feature_property', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="feature_property">{{ trans('cruds.property.fields.feature_property') }}</label>
                </div>
                @if($errors->has('feature_property'))
                    <div class="invalid-feedback">
                        {{ $errors->first('feature_property') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.feature_property_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location">{{ trans('cruds.property.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', '') }}" required>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amenities">{{ trans('cruds.property.fields.amenities') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('amenities') ? 'is-invalid' : '' }}" name="amenities[]" id="amenities" multiple>
                    @foreach($amenities as $id => $amenity)
                        <option value="{{ $id }}" {{ in_array($id, old('amenities', [])) ? 'selected' : '' }}>{{ $amenity }}</option>
                    @endforeach
                </select>
                @if($errors->has('amenities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amenities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.property.fields.amenities_helper') }}</span>
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
    Dropzone.options.propertyMainPhotoDropzone = {
    url: '{{ route('admin.properties.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="property_main_photo"]').remove()
      $('form').append('<input type="hidden" name="property_main_photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="property_main_photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($property) && $property->property_main_photo)
      var file = {!! json_encode($property->property_main_photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="property_main_photo" value="' + file.file_name + '">')
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
                xhr.open('POST', '{{ route('admin.properties.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $property->id ?? 0 }}');
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
    var uploadedPropertyPhotosMap = {}
Dropzone.options.propertyPhotosDropzone = {
    url: '{{ route('admin.properties.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="property_photos[]" value="' + response.name + '">')
      uploadedPropertyPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPropertyPhotosMap[file.name]
      }
      $('form').find('input[name="property_photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($property) && $property->property_photos)
      var files = {!! json_encode($property->property_photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="property_photos[]" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.floorPlansDropzone = {
    url: '{{ route('admin.properties.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="floor_plans"]').remove()
      $('form').append('<input type="hidden" name="floor_plans" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="floor_plans"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($property) && $property->floor_plans)
      var file = {!! json_encode($property->floor_plans) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="floor_plans" value="' + file.file_name + '">')
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
