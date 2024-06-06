<div class="m-3">
    @can('reports_abuse_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.reports-abuses.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.reportsAbuse.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.reportsAbuse.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-postReportsAbuses">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.reportsAbuse.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.reportsAbuse.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.reportsAbuse.fields.post') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportsAbuses as $key => $reportsAbuse)
                            <tr data-entry-id="{{ $reportsAbuse->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $reportsAbuse->id ?? '' }}
                                </td>
                                <td>
                                    {{ $reportsAbuse->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $reportsAbuse->post->title ?? '' }}
                                </td>
                                <td>
                                    @can('reports_abuse_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.reports-abuses.show', $reportsAbuse->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('reports_abuse_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.reports-abuses.edit', $reportsAbuse->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('reports_abuse_delete')
                                        <form action="{{ route('admin.reports-abuses.destroy', $reportsAbuse->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('reports_abuse_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.reports-abuses.massDestroy') }}",
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
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-postReportsAbuses:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection