@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.mod.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.mods.update", [$mod->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
            <div class="form-group {{ $errors->has('platform') ? 'has-error' : '' }}">
                <label for="platform">{{ trans('cruds.mod.fields.platform') }}</label>
               
                <select name="platform" id="platform" class="form-control select2" required>
                        <option value=" "  {{ $mod->platform == ' ' ? 'selected' : '' }}>Select Platform</option>
                        <option value="android" {{ $mod->platform == 'android' ? 'selected' : '' }}>Android</option>
                        <option value="ios" {{ $mod->platform == 'ios' ? 'selected' : '' }}>Ios</option>
                        <option value="both" {{ $mod->platform == 'both' ? 'selected' : '' }}>Both</option>
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
            <div class="form-group {{ $errors->has('facebooklink') ? 'has-error' : '' }}">
                <label for="facebooklink">{{ trans('cruds.mod.fields.facebooklink') }}</label>
                <input title="Please Enter Valid Facebook URL" type="text" id="facebooklink" name="facebooklink" class="form-control" value="{{ old('facebooklink', isset($mod) ? $mod->facebooklink : '') }}" pattern="(?:https?:\/\/)?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)">
                @if($errors->has('facebooklink'))
                    <em class="invalid-feedback">
                        {{ $errors->first('facebooklink') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.fblink_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('instagramlink') ? 'has-error' : '' }}">
                <label for="instagramlink">{{ trans('cruds.mod.fields.instalink') }}</label>
                <input title="Please Enter Valid Instagram URL" type="text" id="instagramlink" name="instagramlink" class="form-control" value="{{ old('instagramlink', isset($mod) ? $mod->instagramlink : '') }}" pattern="(?:https?:\/\/)?(?:www\.)?(mbasic.instagram|m\.instagram|instagram)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)">
                @if($errors->has('instagramlink'))
                    <em class="invalid-feedback">
                        {{ $errors->first('instagramlink') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.instalink_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('youtubelink') ? 'has-error' : '' }}">
                <label for="youtubelink">{{ trans('cruds.mod.fields.youtubelink') }}</label>
                <input title="Please Enter Valid YouTube URL" type="text" id="youtubelink" name="youtubelink" class="form-control" value="{{ old('youtubelink', isset($mod) ? $mod->youtubelink : '') }}" pattern="^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$">
                @if($errors->has('youtubelink'))
                    <em class="invalid-feedback">
                        {{ $errors->first('youtubelink') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.ytlink_helper') }}
                </p>
            </div>

            <div class="form-group ">
                <label for="logo">{{ trans('cruds.mod.fields.logo') }}</label>
                <input type="file" name="filepath" class="form-control" placeholder="file">
                @if($errors->has('logo'))
                    <em class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.logo_helper') }}
                </p>
                <p>{{ $mod->filename}}</p>
            </div>
            <div class="form-group ">
                <label for="image">{{ trans('cruds.mod.fields.modimage') }}</label>
                <input type="file" name="image" class="form-control" placeholder="file">
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.modimage_helper') }}
                </p>
               <img src="{{ $mod->image}}" style="height:100px; width:100px;">
               <p>images with 300X300 resolution will be more suitable</p>
            </div>
            <div class="form-group ">
                <label for="sliderimages">{{ trans('cruds.mod.fields.modsliderimages') }}</label>
                <input type="file" name="sliderimages[]" class="form-control" placeholder="file" multiple>
                @if($errors->has('sliderimages'))
                    <em class="invalid-feedback">
                        {{ $errors->first('sliderimages') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.modsliderimages_helper') }}
                </p>
                <?php 
                foreach ($mod->sliderimages as $sliderimages) {?>
                  <img src={{$sliderimages}} style="height:100px; width:100px;">
                 <?php  }?>
                 <p>images with 300X300 resolution will be more suitable</p>
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