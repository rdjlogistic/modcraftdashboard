@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h2 class="title-main"> {{ trans('global.edit') }} {{ trans('cruds.mod.title_singular') }}</h2>
    </div>

    <div class="card-body card-body-common">
        <form id="editModForm" action="{{ route("admin.mods.update", [$mod->id]) }}" method="POST"
            enctype="multipart/form-data" class="row">
            @csrf
            @method('PUT')
            <div class="col-lg-6">
                <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.mod.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($mod) ? $mod->name : '') }}" required>
                    @if($errors->has('name'))
                    <div class="error">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.mod.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group  {{ $errors->has('platform') ? 'has-error' : '' }}">
                    <label for="platform">{{ trans('cruds.mod.fields.platform') }}</label>

                    <select name="platform" id="platform" class="form-control select2" required>
                        <option value="" {{ $mod->platform == ' ' ? 'selected' : '' }}>Select Platform</option>
                        <option value="android" {{ $mod->platform == 'android' ? 'selected' : '' }}>Android</option>
                        <option value="ios" {{ $mod->platform == 'ios' ? 'selected' : '' }}>Ios</option>
                        <option value="both" {{ $mod->platform == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                    <div class="platformError"></div>
                    @if($errors->has('platform'))
                    <div class="error">
                        {{ $errors->first('platform') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="form-group col-lg-6 {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">{{ trans('cruds.mod.fields.description') }}</label>
                <textarea id="description" name="description"
                    class="form-control ">{{ old('description', isset($mod) ? $mod->description : '') }}</textarea>
                @if($errors->has('description'))
                <div class="error">
                    {{ $errors->first('description') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.description_helper') }}
                </p>
            </div>


            <div class="form-group col-lg-6 {{ $errors->has('app_id') ? 'has-error' : '' }}">
                <label for="app">{{ trans('cruds.mod.fields.apps') }}</label>
                <select name="app_id" id="app" class="form-control select2" required>
                    @foreach($apps as $id => $app)
                    <option value="{{ $id }}"
                        {{ (isset($mod) && $mod->app ? $mod->app->id : old('app_id')) == $id ? 'selected' : '' }}>
                        {{ $app }}</option>
                    @endforeach
                </select>
                <div class="appIdError"></div>
                @if($errors->has('app_id'))
                <div class="error">
                    {{ $errors->first('app_id') }}
                </div>
                @endif
            </div>
            <div class="form-group col-lg-6 {{ $errors->has('createdby') ? 'has-error' : '' }}">
                <label for="createdby">{{ trans('cruds.mod.fields.createdby') }}*</label>
                <input type="text" id="createdby" name="createdby" class="form-control"
                    value="{{ old('createdby', isset($mod) ? $mod->createdby : '') }}" required>
                @if($errors->has('createdby'))
                <div class="error">
                    {{ $errors->first('createdby') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.createdby_helper') }}
                </p>
            </div>
            <div class="form-group col-lg-6 {{ $errors->has('facebooklink') ? 'has-error' : '' }}">
                <label for="facebooklink">{{ trans('cruds.mod.fields.facebooklink') }}</label>
                <input title="Please Enter Valid Facebook URL" type="text" id="facebooklink" name="facebooklink"
                    class="form-control" value="{{ old('facebooklink', isset($mod) ? $mod->facebooklink : '') }}"
                    pattern="(?:https?:\/\/)?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)">
                @if($errors->has('facebooklink'))
                <div class="error">
                    {{ $errors->first('facebooklink') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.fblink_helper') }}
                </p>
            </div>
            <div class="form-group col-lg-6 {{ $errors->has('instagramlink') ? 'has-error' : '' }}">
                <label for="instagramlink">{{ trans('cruds.mod.fields.instalink') }}</label>
                <input title="Please Enter Valid Instagram URL" type="text" id="instagramlink" name="instagramlink"
                    class="form-control" value="{{ old('instagramlink', isset($mod) ? $mod->instagramlink : '') }}"
                    pattern="(?:https?:\/\/)?(?:www\.)?(mbasic.instagram|m\.instagram|instagram)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)">
                @if($errors->has('instagramlink'))
                <div class="error">
                    {{ $errors->first('instagramlink') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.instalink_helper') }}
                </p>
            </div>

            <div class="form-group col-lg-6 {{ $errors->has('youtubelink') ? 'has-error' : '' }}">
                <label for="youtubelink">{{ trans('cruds.mod.fields.youtubelink') }}</label>
                <input title="Please Enter Valid YouTube URL" type="text" id="youtubelink" name="youtubelink"
                    class="form-control" value="{{ old('youtubelink', isset($mod) ? $mod->youtubelink : '') }}"
                    pattern="^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$">
                @if($errors->has('youtubelink'))
                <div class="error">
                    {{ $errors->first('youtubelink') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.ytlink_helper') }}
                </p>
            </div>

            <div class="form-group col-lg-6 ">
                <label for="logo">{{ trans('cruds.mod.fields.logo') }}</label>
                <input type="file" name="filepath" class="form-control" placeholder="file">
                <div class="filePathError"></div>
                @if($errors->has('logo'))
                <div class="error">
                    {{ $errors->first('logo') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.logo_helper') }}
                </p>
                <p>{{ $mod->filename}}</p>
            </div>
            <div class="form-group col-lg-6 ">
                <label for="image">{{ trans('cruds.mod.fields.modimage') }}</label>
                <input type="file" name="image" class="form-control" placeholder="file">
                @if($errors->has('image'))
                <div class="error">
                    {{ $errors->first('image') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.modimage_helper') }}
                </p>
                <img src="{{ $mod->image}}" style="height:100px; width:100px;">
                <p>images with 300X300 resolution will be more suitable</p>
            </div>
            <div class="form-group col-lg-6 ">
                <label for="sliderimages">{{ trans('cruds.mod.fields.modsliderimages') }}</label>
                <input type="file" name="sliderimages[]" class="form-control" placeholder="file" multiple>
                @if($errors->has('sliderimages'))
                <div class="error">
                    {{ $errors->first('sliderimages') }}
                </div>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.mod.fields.modsliderimages_helper') }}
                </p>
                <?php
                foreach ($mod->sliderimages as $sliderimages) {?>
                <img src="{{$sliderimages}}" style="height:100px; width:100px;">
                <?php  }?>
                <p>images with 300X300 resolution will be more suitable</p>
            </div>
            <div class="col-lg-12">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param) }, 'File size must be less than 5 mb' );
        $("#editModForm").validate({
            ignore: [],
            errorElement: 'p',
            errorClass: 'text-danger',
            rules: {
                name: {
                    required: true
                },
                app_id: {
                    required: true
                },
                platform: {
                    required: true
                },
                createdby: {
                    required: true
                },
                filepath: {
                    required: {{ $mod->filename ? 'false' : 'true' }}
                },
                image: {
                    accept: "image/*"
                },
                'sliderimages[]': {
                    accept: "image/*"
                }
            },
            errorPlacement: function (error, element) {
            switch (element.attr("name")) {
            case "platform":
                error.insertAfter(".platformError");
            break;
            case "app_id":
                error.insertAfter(".appIdError");
            break;
            case "filepath":
                error.insertAfter(".filePathError");
                break;
            // case "image":
            //     error.insertAfter(".imageError");
               // break;
            default:
            error.insertAfter(element);
            }
        }

        });
    });
    //     Dropzone.options.logoDropzone = {
//     url: '{{ route('admin.mods.storeMedia') }}',
//     maxFilesize: 2, // MB
//     acceptedFiles: '.jpeg,.jpg,.png,.gif',
//     maxFiles: 1,
//     addRemoveLinks: true,
//     headers: {
//       'X-CSRF-TOKEN': "{{ csrf_token() }}"
//     },
//     params: {
//       size: 2,
//       width: 4096,
//       height: 4096
//     },
//     success: function (file, response) {
//       $('form').find('input[name="logo"]').remove()
//       $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
//     },
//     removedfile: function (file) {
//       file.previewElement.remove()
//       if (file.status !== 'error') {
//         $('form').find('input[name="logo"]').remove()
//         this.options.maxFiles = this.options.maxFiles + 1
//       }
//     },
//     init: function () {
// @if(isset($mod) && $mod->logo)
//       var file = {!! json_encode($mod->logo) !!}
//           this.options.addedfile.call(this, file)
//       this.options.thumbnail.call(this, file, file.url)
//       file.previewElement.classList.add('dz-complete')
//       $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
//       this.options.maxFiles = this.options.maxFiles - 1
// @endif
//     },
//     error: function (file, response) {
//         if ($.type(response) === 'string') {
//             var message = response
//         } else {
//             var message = response.errors.file
//         }
//         file.previewElement.classList.add('dz-error')
//         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
//         _results = []
//         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
//             node = _ref[_i]
//             _results.push(node.textContent = message)
//         }

//         return _results
//     }
// }
</script>
@stop
