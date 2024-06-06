<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Http\Resources\Admin\BreedResource;
use App\Models\Breed;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreedApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('breed_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BreedResource(Breed::with(['team'])->get());
    }

    public function store(StoreBreedRequest $request)
    {
        $breed = Breed::create($request->all());

        return (new BreedResource($breed))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Breed $breed)
    {
        abort_if(Gate::denies('breed_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BreedResource($breed->load(['team']));
    }

    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        $breed->update($request->all());

        return (new BreedResource($breed))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Breed $breed)
    {
        abort_if(Gate::denies('breed_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
