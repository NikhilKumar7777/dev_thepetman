<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('vote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Vote::with(['user', 'post'])->select(sprintf('%s.*', (new Vote())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'vote_show';
                $editGate = 'vote_edit';
                $deleteGate = 'vote_delete';
                $crudRoutePart = 'votes';

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

            $table->editColumn('vote', function ($row) {
                return $row->vote ? Vote::VOTE_SELECT[$row->vote] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'post']);

            return $table->make(true);
        }

        return view('admin.votes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vote_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.votes.create', compact('posts', 'users'));
    }

    public function store(StoreVoteRequest $request)
    {
        $vote = Vote::create($request->all());

        return redirect()->route('admin.votes.index');
    }

    public function edit(Vote $vote)
    {
        abort_if(Gate::denies('vote_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $vote->load('user', 'post');

        return view('admin.votes.edit', compact('posts', 'users', 'vote'));
    }

    public function update(UpdateVoteRequest $request, Vote $vote)
    {
        $vote->update($request->all());

        return redirect()->route('admin.votes.index');
    }

    public function show(Vote $vote)
    {
        abort_if(Gate::denies('vote_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vote->load('user', 'post');

        return view('admin.votes.show', compact('vote'));
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
