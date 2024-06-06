<div class="m-3">
    @can('vote_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.votes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.vote.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.vote.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-postVotes">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.vote.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.vote.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.vote.fields.post') }}
                            </th>
                            <th>
                                {{ trans('cruds.vote.fields.vote') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($votes as $key => $vote)
                            <tr data-entry-id="{{ $vote->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $vote->id ?? '' }}
                                </td>
                                <td>
                                    {{ $vote->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $vote->post->title ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Vote::VOTE_SELECT[$vote->vote] ?? '' }}
                                </td>
                                <td>
                                    @can('vote_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.votes.show', $vote->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('vote_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.votes.edit', $vote->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('vote_delete')
                                        <form action="{{ route('admin.votes.destroy', $vote->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('vote_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.votes.massDestroy') }}",
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
  let table = $('.datatable-postVotes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection