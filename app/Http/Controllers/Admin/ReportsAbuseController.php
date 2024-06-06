<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ReportsAbuseController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('reports_abuse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ReportsAbuse::with(['user', 'post'])->select(sprintf('%s.*', (new ReportsAbuse())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'reports_abuse_show';
                $editGate = 'reports_abuse_edit';
                $deleteGate = 'reports_abuse_delete';
                $crudRoutePart = 'reports-abuses';

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

        return view('admin.reportsAbuses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('reports_abuse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reportsAbuses.create', compact('posts', 'users'));
    }

    public function store(StoreReportsAbuseRequest $request)
    {
        $reportsAbuse = ReportsAbuse::create($request->all());

        return redirect()->route('admin.reports-abuses.index');
    }

    public function edit(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reportsAbuse->load('user', 'post');

        return view('admin.reportsAbuses.edit', compact('posts', 'reportsAbuse', 'users'));
    }

    public function update(UpdateReportsAbuseRequest $request, ReportsAbuse $reportsAbuse)
    {
        $reportsAbuse->update($request->all());

        return redirect()->route('admin.reports-abuses.index');
    }

    public function show(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportsAbuse->load('user', 'post');

        return view('admin.reportsAbuses.show', compact('reportsAbuse'));
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
