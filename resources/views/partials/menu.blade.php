<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }} {{ request()->is("admin/follows*") ? "menu-open" : "" }} {{ request()->is("admin/pets*") ? "menu-open" : "" }} {{ request()->is("admin/teams*") ? "menu-open" : "" }} {{ request()->is("admin/breeds*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }} {{ request()->is("admin/follows*") ? "active" : "" }} {{ request()->is("admin/pets*") ? "active" : "" }} {{ request()->is("admin/teams*") ? "active" : "" }} {{ request()->is("admin/breeds*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('follow_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.follows.index") }}" class="nav-link {{ request()->is("admin/follows") || request()->is("admin/follows/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-angle-up">

                                        </i>
                                        <p>
                                            {{ trans('cruds.follow.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('pet_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.pets.index") }}" class="nav-link {{ request()->is("admin/pets") || request()->is("admin/pets/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-paw">

                                        </i>
                                        <p>
                                            {{ trans('cruds.pet.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('team_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.teams.index") }}" class="nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-users">

                                        </i>
                                        <p>
                                            {{ trans('cruds.team.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('breed_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.breeds.index") }}" class="nav-link {{ request()->is("admin/breeds") || request()->is("admin/breeds/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-paw">

                                        </i>
                                        <p>
                                            {{ trans('cruds.breed.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.userAlert.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('post_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/posts*") ? "menu-open" : "" }} {{ request()->is("admin/categories*") ? "menu-open" : "" }} {{ request()->is("admin/animals*") ? "menu-open" : "" }} {{ request()->is("admin/answers*") ? "menu-open" : "" }} {{ request()->is("admin/reports-abuses*") ? "menu-open" : "" }} {{ request()->is("admin/votes*") ? "menu-open" : "" }} {{ request()->is("admin/comments*") ? "menu-open" : "" }} {{ request()->is("admin/likes*") ? "menu-open" : "" }} {{ request()->is("admin/dislikes*") ? "menu-open" : "" }} {{ request()->is("admin/views*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/posts*") ? "active" : "" }} {{ request()->is("admin/categories*") ? "active" : "" }} {{ request()->is("admin/animals*") ? "active" : "" }} {{ request()->is("admin/answers*") ? "active" : "" }} {{ request()->is("admin/reports-abuses*") ? "active" : "" }} {{ request()->is("admin/votes*") ? "active" : "" }} {{ request()->is("admin/comments*") ? "active" : "" }} {{ request()->is("admin/likes*") ? "active" : "" }} {{ request()->is("admin/dislikes*") ? "active" : "" }} {{ request()->is("admin/views*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-comment">

                            </i>
                            <p>
                                {{ trans('cruds.postManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('post_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.posts.index") }}" class="nav-link {{ request()->is("admin/posts") || request()->is("admin/posts/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-comment">

                                        </i>
                                        <p>
                                            {{ trans('cruds.post.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.categories.index") }}" class="nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-boxes">

                                        </i>
                                        <p>
                                            {{ trans('cruds.category.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('animal_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.animals.index") }}" class="nav-link {{ request()->is("admin/animals") || request()->is("admin/animals/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-paw">

                                        </i>
                                        <p>
                                            {{ trans('cruds.animal.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('answer_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.answers.index") }}" class="nav-link {{ request()->is("admin/answers") || request()->is("admin/answers/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-question-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.answer.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('reports_abuse_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.reports-abuses.index") }}" class="nav-link {{ request()->is("admin/reports-abuses") || request()->is("admin/reports-abuses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-ban">

                                        </i>
                                        <p>
                                            {{ trans('cruds.reportsAbuse.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('vote_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.votes.index") }}" class="nav-link {{ request()->is("admin/votes") || request()->is("admin/votes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-hands-helping">

                                        </i>
                                        <p>
                                            {{ trans('cruds.vote.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('comment_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.comments.index") }}" class="nav-link {{ request()->is("admin/comments") || request()->is("admin/comments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-comments">

                                        </i>
                                        <p>
                                            {{ trans('cruds.comment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('like_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.likes.index") }}" class="nav-link {{ request()->is("admin/likes") || request()->is("admin/likes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-thumbs-up">

                                        </i>
                                        <p>
                                            {{ trans('cruds.like.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('dislike_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.dislikes.index") }}" class="nav-link {{ request()->is("admin/dislikes") || request()->is("admin/dislikes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-thumbs-down">

                                        </i>
                                        <p>
                                            {{ trans('cruds.dislike.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('view_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.views.index") }}" class="nav-link {{ request()->is("admin/views") || request()->is("admin/views/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-eye">

                                        </i>
                                        <p>
                                            {{ trans('cruds.view.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_address_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-addresses.index") }}" class="nav-link {{ request()->is("admin/user-addresses") || request()->is("admin/user-addresses/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-address-card">

                            </i>
                            <p>
                                {{ trans('cruds.userAddress.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @php($unread = \App\Models\QaTopic::unreadCount())
                    <li class="nav-item">
                        <a href="{{ route("admin.messenger.index") }}" class="{{ request()->is("admin/messenger") || request()->is("admin/messenger/*") ? "active" : "" }} nav-link">
                            <i class="fa-fw fa fa-envelope nav-icon">

                            </i>
                            <p>{{ trans('global.messages') }}</p>
                            @if($unread > 0)
                                <strong>( {{ $unread }} )</strong>
                            @endif

                        </a>
                    </li>
                    @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
                        <li class="nav-item">
                            <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "active" : "" }} nav-link" href="{{ route("admin.team-members.index") }}">
                                <i class="fa-fw fa fa-users nav-icon">
                                </i>
                                <p>
                                    {{ trans("global.team-members") }}
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                        @can('profile_password_edit')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                    <i class="fa-fw fas fa-key nav-icon">
                                    </i>
                                    <p>
                                        {{ trans('global.change_password') }}
                                    </p>
                                </a>
                            </li>
                        @endcan
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <p>
                                <i class="fas fa-fw fa-sign-out-alt nav-icon">

                                </i>
                                <p>{{ trans('global.logout') }}</p>
                            </p>
                        </a>
                    </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>