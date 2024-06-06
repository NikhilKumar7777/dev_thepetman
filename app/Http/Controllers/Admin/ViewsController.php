<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyViewRequest;
use App\Http\Requests\StoreViewRequest;
use App\Http\Requests\UpdateViewRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\View;
// use Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ViewsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = View::with(['user', 'post'])->select(sprintf('%s.*', (new View())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'view_show';
                $editGate = 'view_edit';
                $deleteGate = 'view_delete';
                $crudRoutePart = 'views';

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

        return view('admin.views.index');
    }

    public function create()
    {
        abort_if(Gate::denies('view_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.views.create', compact('posts', 'users'));
    }

    public function store(StoreViewRequest $request)
    {
        $view = View::create($request->all());

        return redirect()->route('admin.views.index');
    }

    public function edit(View $view)
    {
        abort_if(Gate::denies('view_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $view->load('user', 'post');

        return view('admin.views.edit', compact('posts', 'users', 'view'));
    }

    public function update(UpdateViewRequest $request, View $view)
    {
        $view->update($request->all());

        return redirect()->route('admin.views.index');
    }

    public function show(View $view)
    {
        abort_if(Gate::denies('view_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $view->load('user', 'post');

        return view('admin.views.show', compact('view'));
    }

    public function destroy(View $view)
    {
        abort_if(Gate::denies('view_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $view->delete();

        return back();
    }

    public function massDestroy(MassDestroyViewRequest $request)
    {
        View::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
