<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDislikeRequest;
use App\Http\Requests\StoreDislikeRequest;
use App\Http\Requests\UpdateDislikeRequest;
use App\Models\Dislike;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DislikeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('dislike_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dislikes = Dislike::with(['user', 'post'])->get();

        return view('frontend.dislikes.index', compact('dislikes'));
    }

    public function create()
    {
        abort_if(Gate::denies('dislike_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.dislikes.create', compact('posts', 'users'));
    }

    public function store(StoreDislikeRequest $request)
    {
        $dislike = Dislike::create($request->all());

        return redirect()->route('frontend.dislikes.index');
    }

    public function edit(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dislike->load('user', 'post');

        return view('frontend.dislikes.edit', compact('dislike', 'posts', 'users'));
    }

    public function update(UpdateDislikeRequest $request, Dislike $dislike)
    {
        $dislike->update($request->all());

        return redirect()->route('frontend.dislikes.index');
    }

    public function show(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dislike->load('user', 'post');

        return view('frontend.dislikes.show', compact('dislike'));
    }

    public function destroy(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dislike->delete();

        return back();
    }

    public function massDestroy(MassDestroyDislikeRequest $request)
    {
        Dislike::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
