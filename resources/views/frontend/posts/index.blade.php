@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('post_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.posts.create') }}">
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
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Post">
                            <thead>
                                <tr>
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
                            <tbody>
                                @foreach($posts as $key => $post)
                                    <tr data-entry-id="{{ $post->id }}">
                                        <td>
                                            {{ $post->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->title ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($post->images as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $post->slug ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->like_count ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->unlike_count ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->view_count ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $post->is_report ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $post->is_report ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $post->answer_count ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Post::TYPE_SELECT[$post->type] ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($post->categories as $key => $item)
                                                <span>{{ $item->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $post->option_1 ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->option_2 ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->option_3 ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->option_4 ?? '' }}
                                        </td>
                                        <td>
                                            {{ $post->user->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('post_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.posts.show', $post->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('post_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.posts.edit', $post->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('post_delete')
                                                <form action="{{ route('frontend.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.posts.massDestroy') }}",
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
  let table = $('.datatable-Post:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection