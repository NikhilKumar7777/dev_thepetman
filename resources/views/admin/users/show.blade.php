@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.phone') }}
                        </th>
                        <td>
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.social_token') }}
                        </th>
                        <td>
                            {{ $user->social_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.social_platform') }}
                        </th>
                        <td>
                            {{ $user->social_platform }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.category') }}
                        </th>
                        <td>
                            @foreach($user->categories as $key => $category)
                                <span class="label label-info">{{ $category->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.profile_status') }}
                        </th>
                        <td>
                            {{ App\Models\User::PROFILE_STATUS_SELECT[$user->profile_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.city') }}
                        </th>
                        <td>
                            {{ $user->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.about') }}
                        </th>
                        <td>
                            {{ $user->about }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.bio') }}
                        </th>
                        <td>
                            {{ $user->bio }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.age') }}
                        </th>
                        <td>
                            {{ $user->age }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.users.index') }}">
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
            <a class="nav-link" href="#user_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.answer.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_votes" role="tab" data-toggle="tab">
                {{ trans('cruds.vote.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_comments" role="tab" data-toggle="tab">
                {{ trans('cruds.comment.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#follower_follows" role="tab" data-toggle="tab">
                {{ trans('cruds.follow.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#following_follows" role="tab" data-toggle="tab">
                {{ trans('cruds.follow.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_animals" role="tab" data-toggle="tab">
                {{ trans('cruds.animal.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.post.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.userAddress.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_likes" role="tab" data-toggle="tab">
                {{ trans('cruds.like.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_dislikes" role="tab" data-toggle="tab">
                {{ trans('cruds.dislike.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_views" role="tab" data-toggle="tab">
                {{ trans('cruds.view.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                {{ trans('cruds.userAlert.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="user_answers">
            @includeIf('admin.users.relationships.userAnswers', ['answers' => $user->userAnswers])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_votes">
            @includeIf('admin.users.relationships.userVotes', ['votes' => $user->userVotes])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_comments">
            @includeIf('admin.users.relationships.userComments', ['comments' => $user->userComments])
        </div>
        <div class="tab-pane" role="tabpanel" id="follower_follows">
            @includeIf('admin.users.relationships.followerFollows', ['follows' => $user->followerFollows])
        </div>
        <div class="tab-pane" role="tabpanel" id="following_follows">
            @includeIf('admin.users.relationships.followingFollows', ['follows' => $user->followingFollows])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_animals">
            @includeIf('admin.users.relationships.userAnimals', ['animals' => $user->userAnimals])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_posts">
            @includeIf('admin.users.relationships.userPosts', ['posts' => $user->userPosts])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_addresses">
            @includeIf('admin.users.relationships.userUserAddresses', ['userAddresses' => $user->userUserAddresses])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_likes">
            @includeIf('admin.users.relationships.userLikes', ['likes' => $user->userLikes])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_dislikes">
            @includeIf('admin.users.relationships.userDislikes', ['dislikes' => $user->userDislikes])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_views">
            @includeIf('admin.users.relationships.userViews', ['views' => $user->userViews])
        </div>
        <div class="tab-pane" role="tabpanel" id="user_user_alerts">
            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
        </div>
    </div>
</div>

@endsection