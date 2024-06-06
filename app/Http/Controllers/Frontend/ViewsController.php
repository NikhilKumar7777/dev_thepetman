<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyViewRequest;
use App\Http\Requests\StoreViewRequest;
use App\Http\Requests\UpdateViewRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\View;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $views = View::with(['user', 'post'])->get();

        return view('frontend.views.index', compact('views'));
    }

    public function create()
    {
        abort_if(Gate::denies('view_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.views.create', compact('posts', 'users'));
    }

    public function store(StoreViewRequest $request)
    {
        $view = View::create($request->all());

        return redirect()->route('frontend.views.index');
    }

    public function edit(View $view)
    {
        abort_if(Gate::denies('view_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $view->load('user', 'post');

        return view('frontend.views.edit', compact('posts', 'users', 'view'));
    }

    public function update(UpdateViewRequest $request, View $view)
    {
        $view->update($request->all());

        return redirect()->route('frontend.views.index');
    }

    public function show(View $view)
    {
        abort_if(Gate::denies('view_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $view->load('user', 'post');

        return view('frontend.views.show', compact('view'));
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
