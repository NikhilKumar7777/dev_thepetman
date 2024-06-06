<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyLikeRequest;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $likes = Like::with(['user', 'post'])->get();

        return view('frontend.likes.index', compact('likes'));
    }

    public function create()
    {
        abort_if(Gate::denies('like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.likes.create', compact('posts', 'users'));
    }

    public function store(StoreLikeRequest $request)
    {
        $like = Like::create($request->all());

        return redirect()->route('frontend.likes.index');
    }

    public function edit(Like $like)
    {
        abort_if(Gate::denies('like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like->load('user', 'post');

        return view('frontend.likes.edit', compact('like', 'posts', 'users'));
    }

    public function update(UpdateLikeRequest $request, Like $like)
    {
        $like->update($request->all());

        return redirect()->route('frontend.likes.index');
    }

    public function show(Like $like)
    {
        abort_if(Gate::denies('like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $like->load('user', 'post');

        return view('frontend.likes.show', compact('like'));
    }

    public function destroy(Like $like)
    {
        abort_if(Gate::denies('like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $like->delete();

        return back();
    }

    public function massDestroy(MassDestroyLikeRequest $request)
    {
        Like::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
