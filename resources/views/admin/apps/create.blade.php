@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <h2 class="title-main"> {{ trans('global.create') }} {{ trans('cruds.app.title_singular') }} </h2>
    </div>

    <div class="card-body card-body-common">
        <form action="{{ route("admin.apps.store") }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.app.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="" required>
                
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
             
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