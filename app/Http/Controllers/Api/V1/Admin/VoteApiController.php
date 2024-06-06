<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoteRequest;
use App\Http\Requests\UpdateVoteRequest;
use App\Http\Resources\Admin\VoteResource;
use App\Models\Vote;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VoteApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VoteResource(Vote::with(['user', 'post'])->get());
    }

    public function store(StoreVoteRequest $request)
    {
        $vote = Vote::create($request->all());

        return (new VoteResource($vote))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Vote $vote)
    {
        abort_if(Gate::denies('vote_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VoteResource($vote->load(['user', 'post']));
    }

    public function update(UpdateVoteRequest $request, Vote $vote)
    {
        $vote->update($request->all());

        return (new VoteResource($vote))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Vote $vote)
    {
        abort_if(Gate::denies('vote_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $vote->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
