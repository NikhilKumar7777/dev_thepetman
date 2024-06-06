<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
// use Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'categories', 'team'])->select(sprintf('%s.*', (new User())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $verifyGate = 'user_verify';
                $code = $row-> verified;
                $crudRoutePart = 'users';

                return view('partials.verifymail', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'verifyGate',
                'code',
                'crudRoutePart',
                'row'
            )); 
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->verified ? 'checked' : null) . '>';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('social_token', function ($row) {
                return $row->social_token ? $row->social_token : '';
            });
            $table->editColumn('social_platform', function ($row) {
                return $row->social_platform ? $row->social_platform : '';
            });
            $table->editColumn('category', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('profile_status', function ($row) {
                return $row->profile_status ? User::PROFILE_STATUS_SELECT[$row->profile_status] : '';
            });
            $table->editColumn('city', function ($row) {
                return $row->city ? $row->city : '';
            });
            $table->editColumn('about', function ($row) {
                return $row->about ? $row->about : '';
            });
            $table->editColumn('bio', function ($row) {
                return $row->bio ? $row->bio : '';
            });

            $table->editColumn('age',function($row){
                return $row->age ? $row->age : '';

            });

            $table->rawColumns(['actions', 'placeholder', 'approved', 'verified', 'roles', 'category']);

            return $table->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $categories = Category::pluck('title', 'id');

        $teams = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('categories', 'roles', 'teams'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $categories = Category::pluck('title', 'id');

        $teams = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('roles', 'categories', 'team');

        return view('admin.users.edit', compact('categories', 'roles', 'teams', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'categories', 'team', 'userAnswers', 'userVotes', 'userComments', 'followerFollows', 'followingFollows', 'userAnimals', 'userPosts', 'userUserAddresses', 'userLikes', 'userDislikes', 'userViews', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }
    
    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function verify(User $user){
        abort_if(Gate::denies('user_verify'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $user->sendEmailVerificationNotification();
    }

}
