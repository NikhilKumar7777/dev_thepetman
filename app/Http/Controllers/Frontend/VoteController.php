<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVoteRequest;
use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VoteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $votes = Vote::with(['user', 'post'])->get();

        return view('frontend.votes.index', compact('votes'));
    }

    public function create()
    {
        abort_if(Gate::denies('vote_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.votes.create', compact('posts', 'users'));
    }

    public function store(StoreVoteRequest $request)
    {
        $vote = Vote::create($request->all());

        return redirect()->route('frontend.votes.index');
    }

    public function edit(Vote $vote)
    {
        abort_if(Gate::denies('vote_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vote->load('user', 'post');

        return view('frontend.votes.edit', compact('posts', 'users', 'vote'));
    }

    public function update(UpdateVoteRequest $request, Vote $vote)
    {
        $vote->update($request->all());

        return redirect()->route('frontend.votes.index');
    }

    public function show(Vote $vote)
    {
        abort_if(Gate::denies('vote_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vote->load('user', 'post');

        return view('frontend.votes.show', compact('vote'));
    }

    public function destroy(Vote $vote)
    {
        abort_if(Gate::denies('vote_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vote->delete();

        return back();
    }

    public function massDestroy(MassDestroyVoteRequest $request)
    {
        Vote::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
