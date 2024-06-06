<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class DislikeController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('dislike_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Dislike::with(['user', 'post'])->select(sprintf('%s.*', (new Dislike())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'dislike_show';
                $editGate = 'dislike_edit';
                $deleteGate = 'dislike_delete';
                $crudRoutePart = 'dislikes';

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

        return view('admin.dislikes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('dislike_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dislikes.create', compact('posts', 'users'));
    }

    public function store(StoreDislikeRequest $request)
    {
        $dislike = Dislike::create($request->all());

        return redirect()->route('admin.dislikes.index');
    }

    public function edit(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dislike->load('user', 'post');

        return view('admin.dislikes.edit', compact('dislike', 'posts', 'users'));
    }

    public function update(UpdateDislikeRequest $request, Dislike $dislike)
    {
        $dislike->update($request->all());

        return redirect()->route('admin.dislikes.index');
    }

    public function show(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dislike->load('user', 'post');

        return view('admin.dislikes.show', compact('dislike'));
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
