<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('comment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comments = Comment::with(['user', 'post', 'answer'])->get();

        return view('frontend.comments.index', compact('comments'));
    }

    public function create()
    {
        abort_if(Gate::denies('comment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $answers = Answer::pluck('answer', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.comments.create', compact('answers', 'posts', 'users'));
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->all());

        return redirect()->route('frontend.comments.index');
    }

    public function edit(Comment $comment)
    {
        abort_if(Gate::denies('comment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $answers = Answer::pluck('answer', 'id')->prepend(trans('global.pleaseSelect'), '');

        $comment->load('user', 'post', 'answer');

        return view('frontend.comments.edit', compact('answers', 'comment', 'posts', 'users'));
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());

        return redirect()->route('frontend.comments.index');
    }

    public function show(Comment $comment)
    {
        abort_if(Gate::denies('comment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->load('user', 'post', 'answer');

        return view('frontend.comments.show', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        abort_if(Gate::denies('comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $comment->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommentRequest $request)
    {
        Comment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
