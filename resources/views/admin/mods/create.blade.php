@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.mod.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.mods.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.mod.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($mod) ? $mod->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.mod.fields.description') }}</label>
                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($mod) ? $mod->description : '') }}</textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.description_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('platform') ? 'has-error' : '' }}"">
                <label for="platform">{{ trans('cruds.mod.fields.platform') }}</label>
                <select name="platform" id="platform" class="form-control select2">
                        <option value=" "  selected>Select Platform</option>
                        <option value="android" >Android</option>
                        <option value="ios" >Ios</option>
                        <option value="both" >Both</option>
                </select>
                @if($errors->has('platform'))
                    <em class="invalid-feedback">
                        {{ $errors->first('platform') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('app_id') ? 'has-error' : '' }}">
                <label for="app">{{ trans('cruds.mod.fields.apps') }}</label>
                <select name="app_id" id="app" class="form-control select2" required>
                    @foreach($apps as $id => $app)
                        <option value="{{ $id }}" {{ (isset($mod) && $mod->app ? $mod->app->id : old('app_id')) == $id ? 'selected' : '' }}>{{ $app }}</option>
                    @endforeach
                </select>
                @if($errors->has('app_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('app_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                <label for="logo">{{ trans('cruds.mod.fields.logo') }}</label>
                <div class="needsclick dropzone" id="logo-dropzone">

                </div>
                @if($errors->has('logo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.logo_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.mods.storeMedia') }}',
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
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($mod) && $mod->logo)
      var file = {!! json_encode($mod->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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
@stop