@extends('layouts.admin')
@section('content')

<?php if(isset($_GET['app_id'])) { $appid = $_GET['app_id']; } else { $appid = ''; }?>
    <form action="{{ route('admin.mods.index') }}" method="GET" style="margin-top: 20px;" enctype="multipart/form-data">
        <div class="row">
            <div class="form-group col-md-9">
                <select name="app_id" id="input" class="form-control select2">
                    <option value=""  selected>Select App</option>
                    @foreach($apps as $id => $app)
                        <option value="{{ $id }}" {{ $id == $appid ? 'selected' : '' }}>{{ $app }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
            <input type="submit" class="btn btn-danger btn-sm" value="Filter" style="padding:5px 30px;">
            </div>
        </div>
    </form>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.mods.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.mod.title_singular') }}
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.mod.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
    
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mod">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.mod.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.mod.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.mod.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.mod.fields.platform') }}
                        </th>
                        <th>
                            {{ trans('cruds.mod.fields.apps') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.mod.fields.logo') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.mod.fields.modimage') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mods as $key => $mod)
                        <?php if($mod->app->id == $appid){?>
                        <tr data-entry-id="{{ $mod->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $mod->id ?? '' }}
                            </td>
                            <td>
                                {{ $mod->name ?? '' }}
                            </td>
                            <td>
                                {{ $mod->description ?? '' }}
                            </td>
                            <td>
                                {{ $mod->platform ?? '' }}
                            </td>
                            <td>
                                {{ $mod->app->name ?? '' }}
                            </td>
                            <!-- <td>{{ $mod->filename}}</td> -->
                            <td><img src="{{ $mod->image}}" style="height:50px; width:70px;"></td>
                            <!-- <td>
                                @if($mod->logo)
                                    <a href="{{ $mod->logo->getUrl() }}" target="_blank">
                                        <img src="{{ $mod->logo->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td> -->
                            <td>
                                    <a class="btn btn-xs btn-info btn-edit" href="{{ route('admin.mods.edit', $mod->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                
                                    <form class="btn-delete-form" action="{{ route('admin.mods.destroy', $mod->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                            </td>
                            
                        </tr>
                       <?php }?>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.mods.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)


  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Mod:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection