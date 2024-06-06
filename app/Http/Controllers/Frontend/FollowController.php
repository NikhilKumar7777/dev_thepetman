<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFollowRequest;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;
use App\Models\Follow;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follow_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follows = Follow::with(['follower', 'following'])->get();

        return view('frontend.follows.index', compact('follows'));
    }

    public function create()
    {
        abort_if(Gate::denies('follow_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followers = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followings = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.follows.create', compact('followers', 'followings'));
    }

    public function store(StoreFollowRequest $request)
    {
        $follow = Follow::create($request->all());

        return redirect()->route('frontend.follows.index');
    }

    public function edit(Follow $follow)
    {
        abort_if(Gate::denies('follow_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followers = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followings = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follow->load('follower', 'following');

        return view('frontend.follows.edit', compact('follow', 'followers', 'followings'));
    }

    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        $follow->update($request->all());

        return redirect()->route('frontend.follows.index');
    }

    public function show(Follow $follow)
    {
        abort_if(Gate::denies('follow_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follow->load('follower', 'following');

        return view('frontend.follows.show', compact('follow'));
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
