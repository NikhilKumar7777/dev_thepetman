<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAnswerRequest;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('answer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Answer::with(['post', 'user'])->select(sprintf('%s.*', (new Answer())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'answer_show';
                $editGate = 'answer_edit';
                $deleteGate = 'answer_delete';
                $crudRoutePart = 'answers';

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
            $table->addColumn('post_title', function ($row) {
                return $row->post ? $row->post->title : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('answer', function ($row) {
                return $row->answer ? $row->answer : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'post', 'user']);

            return $table->make(true);
        }

        return view('admin.answers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('answer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.answers.create', compact('posts', 'users'));
    }

    public function store(StoreAnswerRequest $request)
    {
        $answer = Answer::create($request->all());

        return redirect()->route('admin.answers.index');
    }

    public function edit(Answer $answer)
    {
        abort_if(Gate::denies('answer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $answer->load('post', 'user');

        return view('admin.answers.edit', compact('answer', 'posts', 'users'));
    }

    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        $answer->update($request->all());

        return redirect()->route('admin.answers.index');
    }

    public function show(Answer $answer)
    {
        abort_if(Gate::denies('answer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $answer->load('post', 'user', 'answerComments');

        return view('admin.answers.show', compact('answer'));
    }

    public function destroy(Answer $answer)
    {
        abort_if(Gate::denies('answer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $answer->delete();

        return back();
    }

    public function massDestroy(MassDestroyAnswerRequest $request)
    {
        Answer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
