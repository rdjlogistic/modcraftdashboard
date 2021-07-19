@extends('layouts.admin')
@section('content')

<?php if(isset($_GET['app_id'])) { $appid = $_GET['app_id']; } else { $appid = ''; }?>
    <form action="{{ route('admin.maps.index') }}" method="GET" style="margin-top: 20px;" enctype="multipart/form-data">
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
            <a class="btn btn-success" href="{{ route("admin.maps.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.map.title_singular') }}
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.map.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
    
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Map">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.map.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.map.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.map.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.map.fields.platform') }}
                        </th>
                        <th>
                            {{ trans('cruds.map.fields.apps') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.map.fields.logo') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.map.fields.mapimage') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maps as $key => $map)
                        <?php if($map->app->id == $appid){?>
                        <tr data-entry-id="{{ $map->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $map->id ?? '' }}
                            </td>
                            <td>
                                {{ $map->name ?? '' }}
                            </td>
                            <td>
                                {{ $map->description ?? '' }}
                            </td>
                            <td>
                                {{ $map->platform ?? '' }}
                            </td>
                            <td>
                                {{ $map->app->name ?? '' }}
                            </td>
                            <!-- <td>{{ $map->filename}}</td> -->
                            <td><img src="{{ $map->image}}" style="height:50px; width:70px;"></td>
                            <!-- <td>
                                @if($map->logo)
                                    <a href="{{ $map->logo->getUrl() }}" target="_blank">
                                        <img src="{{ $map->logo->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td> -->
                            <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.maps.edit', $map->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                
                                    <form action="{{ route('admin.maps.destroy', $map->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    url: "{{ route('admin.maps.massDestroy') }}",
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
  $('.datatable-Map:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection