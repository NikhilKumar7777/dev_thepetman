<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Resources\Admin\AnimalResource;
use App\Models\Animal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnimalsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('animal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnimalResource(Animal::with(['breed', 'user'])->get());
    }

    public function store(StoreAnimalRequest $request)
    {
        $animal = Animal::create($request->all());

        if ($request->input('icon', false)) {
            $animal->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        return (new AnimalResource($animal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Animal $animal)
    {
        abort_if(Gate::denies('animal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnimalResource($animal->load(['breed', 'user']));
    }

    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $animal->update($request->all());

        if ($request->input('icon', false)) {
            if (!$animal->icon || $request->input('icon') !== $animal->icon->file_name) {
                if ($animal->icon) {
                    $animal->icon->delete();
                }
                $animal->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($animal->icon) {
            $animal->icon->delete();
        }

        return (new AnimalResource($animal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Animal $animal)
    {
        abort_if(Gate::denies('animal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $animal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
