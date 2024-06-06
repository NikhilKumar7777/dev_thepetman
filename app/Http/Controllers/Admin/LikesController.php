<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class LikesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Like::with(['user', 'post'])->select(sprintf('%s.*', (new Like())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'like_show';
                $editGate = 'like_edit';
                $deleteGate = 'like_delete';
                $crudRoutePart = 'likes';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('post_title', function ($row) {
                return $row->post ? $row->post->title : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'post']);

            return $table->make(true);
        }

        return view('admin.likes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('like_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.likes.create', compact('posts', 'users'));
    }

    public function store(StoreLikeRequest $request)
    {
        $like = Like::create($request->all());

        return redirect()->route('admin.likes.index');
    }

    public function edit(Like $like)
    {
        abort_if(Gate::denies('like_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $like->load('user', 'post');

        return view('admin.likes.edit', compact('like', 'posts', 'users'));
    }

    public function update(UpdateLikeRequest $request, Like $like)
    {
        $like->update($request->all());

        return redirect()->route('admin.likes.index');
    }

    public function show(Like $like)
    {
        abort_if(Gate::denies('like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $like->load('user', 'post');

        return view('admin.likes.show', compact('like'));
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
