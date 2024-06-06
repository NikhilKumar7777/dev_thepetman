<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDislikeRequest;
use App\Http\Requests\UpdateDislikeRequest;
use App\Http\Resources\Admin\DislikeResource;
use App\Models\Dislike;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DislikeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dislike_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DislikeResource(Dislike::with(['user', 'post'])->get());
    }

    public function store(StoreDislikeRequest $request)
    {
        $dislike = Dislike::create($request->all());

        return (new DislikeResource($dislike))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DislikeResource($dislike->load(['user', 'post']));
    }

    public function update(UpdateDislikeRequest $request, Dislike $dislike)
    {
        $dislike->update($request->all());

        return (new DislikeResource($dislike))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Dislike $dislike)
    {
        abort_if(Gate::denies('dislike_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dislike->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
