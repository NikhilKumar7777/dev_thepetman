@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.post.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
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
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#post_reports_abuses" role="tab" data-toggle="tab">
                {{ trans('cruds.reportsAbuse.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#post_votes" role="tab" data-toggle="tab">
                {{ trans('cruds.vote.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#post_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.comment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#post_likes" role="tab" data-toggle="tab">
                {{ trans('cruds.like.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#post_dislikes" role="tab" data-toggle="tab">
                {{ trans('cruds.dislike.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#post_views" role="tab" data-toggle="tab">
                {{ trans('cruds.view.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="post_reports_abuses">
            @includeIf('admin.posts.relationships.postReportsAbuses', ['reportsAbuses' => $post->postReportsAbuses])
        </div>
        <div class="tab-pane" role="tabpanel" id="post_votes">
            @includeIf('admin.posts.relationships.postVotes', ['votes' => $post->postVotes])
        </div>
        <div class="tab-pane" role="tabpanel" id="post_comments">
            @includeIf('admin.posts.relationships.postComments', ['comments' => $post->postComments])
        </div>
        <div class="tab-pane" role="tabpanel" id="post_likes">
            @includeIf('admin.posts.relationships.postLikes', ['likes' => $post->postLikes])
        </div>
        <div class="tab-pane" role="tabpanel" id="post_dislikes">
            @includeIf('admin.posts.relationships.postDislikes', ['dislikes' => $post->postDislikes])
        </div>
        <div class="tab-pane" role="tabpanel" id="post_views">
            @includeIf('admin.posts.relationships.postViews', ['views' => $post->postViews])
        </div>
    </div>
</div>

@endsection