<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFollowRequest;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;
use App\Models\Follow;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FollowController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('follow_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Follow::with(['follower', 'following'])->select(sprintf('%s.*', (new Follow())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'follow_show';
                $editGate = 'follow_edit';
                $deleteGate = 'follow_delete';
                $crudRoutePart = 'follows';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('follower_name', function ($row) {
                return $row->follower ? $row->follower->name : '';
            });

            $table->addColumn('following_name', function ($row) {
                return $row->following ? $row->following->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'follower', 'following']);

            return $table->make(true);
        }

        return view('admin.follows.index');
    }

    public function create()
    {
        abort_if(Gate::denies('follow_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followers = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followings = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.follows.create', compact('followers', 'followings'));
    }

    public function store(StoreFollowRequest $request)
    {
        $follow = Follow::create($request->all());

        return redirect()->route('admin.follows.index');
    }

    public function edit(Follow $follow)
    {
        abort_if(Gate::denies('follow_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followers = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followings = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follow->load('follower', 'following');

        return view('admin.follows.edit', compact('follow', 'followers', 'followings'));
    }

    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        $follow->update($request->all());

        return redirect()->route('admin.follows.index');
    }

    public function show(Follow $follow)
    {
        abort_if(Gate::denies('follow_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follow->load('follower', 'following');

        return view('admin.follows.show', compact('follow'));
    }

    public function destroy(Follow $follow)
    {
        abort_if(Gate::denies('follow_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follow->delete();

        return back();
    }

    public function massDestroy(MassDestroyFollowRequest $request)
    {
        Follow::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
