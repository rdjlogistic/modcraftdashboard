@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <h2 class="title-main">  {{ trans('global.edit') }} {{ trans('cruds.app.title_singular') }} </h2>
    </div>

    <div class="card-body card-body-common">
        <form action="{{ route("admin.apps.update", [$app->id]) }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">{{ trans('cruds.app.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($app) ? $app->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.app.fields.app_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection