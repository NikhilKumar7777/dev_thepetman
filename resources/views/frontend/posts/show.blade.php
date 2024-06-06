@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.post.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.posts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $post->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $post->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.body') }}
                                    </th>
                                    <td>
                                        {!! $post->body !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.images') }}
                                    </th>
                                    <td>
                                        @foreach($post->images as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.slug') }}
                                    </th>
                                    <td>
                                        {{ $post->slug }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.like_count') }}
                                    </th>
                                    <td>
                                        {{ $post->like_count }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.unlike_count') }}
                                    </th>
                                    <td>
                                        {{ $post->unlike_count }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.view_count') }}
                                    </th>
                                    <td>
                                        {{ $post->view_count }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.is_report') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $post->is_report ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.answer_count') }}
                                    </th>
                                    <td>
                                        {{ $post->answer_count }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Post::TYPE_SELECT[$post->type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.category') }}
                                    </th>
                                    <td>
                                        @foreach($post->categories as $key => $category)
                                            <span class="label label-info">{{ $category->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.option_1') }}
                                    </th>
                                    <td>
                                        {{ $post->option_1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.option_2') }}
                                    </th>
                                    <td>
                                        {{ $post->option_2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.option_3') }}
                                    </th>
                                    <td>
                                        {{ $post->option_3 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.option_4') }}
                                    </th>
                                    <td>
                                        {{ $post->option_4 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.post.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $post->user->name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.posts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection