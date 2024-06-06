@extends('layouts.admin')
@section('content')
@can('post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.posts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.post.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Post">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.post.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.images') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.slug') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.like_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.unlike_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.view_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.is_report') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.answer_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.option_1') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.option_2') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.option_3') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.option_4') }}
                    </th>
                    <th>
                        {{ trans('cruds.post.fields.user') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.posts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.posts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'title', name: 'title' },
{ data: 'images', name: 'images', sortable: false, searchable: false },
{ data: 'slug', name: 'slug' },
{ data: 'like_count', name: 'like_count' },
{ data: 'unlike_count', name: 'unlike_count' },
{ data: 'view_count', name: 'view_count' },
{ data: 'is_report', name: 'is_report' },
{ data: 'answer_count', name: 'answer_count' },
{ data: 'type', name: 'type' },
{ data: 'category', name: 'categories.title' },
{ data: 'option_1', name: 'option_1' },
{ data: 'option_2', name: 'option_2' },
{ data: 'option_3', name: 'option_3' },
{ data: 'option_4', name: 'option_4' },
{ data: 'user_name', name: 'user.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Post').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection