<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReportsAbuseRequest;
use App\Http\Requests\StoreReportsAbuseRequest;
use App\Http\Requests\UpdateReportsAbuseRequest;
use App\Models\Post;
use App\Models\ReportsAbuse;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsAbuseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reports_abuse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportsAbuses = ReportsAbuse::with(['user', 'post'])->get();

        return view('frontend.reportsAbuses.index', compact('reportsAbuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('reports_abuse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.reportsAbuses.create', compact('posts', 'users'));
    }

    public function store(StoreReportsAbuseRequest $request)
    {
        $reportsAbuse = ReportsAbuse::create($request->all());

        return redirect()->route('frontend.reports-abuses.index');
    }

    public function edit(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reportsAbuse->load('user', 'post');

        return view('frontend.reportsAbuses.edit', compact('posts', 'reportsAbuse', 'users'));
    }

    public function update(UpdateReportsAbuseRequest $request, ReportsAbuse $reportsAbuse)
    {
        $reportsAbuse->update($request->all());

        return redirect()->route('frontend.reports-abuses.index');
    }

    public function show(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportsAbuse->load('user', 'post');

        return view('frontend.reportsAbuses.show', compact('reportsAbuse'));
    }

    public function destroy(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportsAbuse->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportsAbuseRequest $request)
    {
        ReportsAbuse::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
