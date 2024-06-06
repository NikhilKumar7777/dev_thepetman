<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;
use App\Http\Resources\Admin\FollowResource;
use App\Models\Follow;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follow_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowResource(Follow::with(['follower', 'following'])->get());
    }

    public function store(StoreFollowRequest $request)
    {
        $follow = Follow::create($request->all());

        return (new FollowResource($follow))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Follow $follow)
    {
        abort_if(Gate::denies('follow_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowResource($follow->load(['follower', 'following']));
    }

    public function update(UpdateFollowRequest $request, Follow $follow)
    {
        $follow->update($request->all());

        return (new FollowResource($follow))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Follow $follow)
    {
        abort_if(Gate::denies('follow_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $follow->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
