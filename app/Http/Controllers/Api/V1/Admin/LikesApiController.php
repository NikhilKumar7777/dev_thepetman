<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Http\Resources\Admin\LikeResource;
use App\Models\Like;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('like_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LikeResource(Like::with(['user', 'post'])->get());
    }

    public function store(StoreLikeRequest $request)
    {
        $like = Like::create($request->all());

        return (new LikeResource($like))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Like $like)
    {
        abort_if(Gate::denies('like_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LikeResource($like->load(['user', 'post']));
    }

    public function update(UpdateLikeRequest $request, Like $like)
    {
        $like->update($request->all());

        return (new LikeResource($like))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Like $like)
    {
        abort_if(Gate::denies('like_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $like->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
