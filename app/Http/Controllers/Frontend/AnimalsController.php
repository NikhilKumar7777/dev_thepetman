<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAnimalRequest;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\Animal;
use App\Models\Pet;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AnimalsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('animal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $animals = Animal::with(['breed', 'user', 'media'])->get();

        return view('frontend.animals.index', compact('animals'));
    }

    public function create()
    {
        abort_if(Gate::denies('animal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breeds = Pet::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.animals.create', compact('breeds', 'users'));
    }

    public function store(StoreAnimalRequest $request)
    {
        $animal = Animal::create($request->all());

        if ($request->input('icon', false)) {
            $animal->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $animal->id]);
        }

        return redirect()->route('frontend.animals.index');
    }

    public function edit(Animal $animal)
    {
        abort_if(Gate::denies('animal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breeds = Pet::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $animal->load('breed', 'user');

        return view('frontend.animals.edit', compact('animal', 'breeds', 'users'));
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

        return redirect()->route('frontend.animals.index');
    }

    public function show(Animal $animal)
    {
        abort_if(Gate::denies('animal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $animal->load('breed', 'user', 'animalUsers');

        return view('frontend.animals.show', compact('animal'));
    }

    public function destroy(Animal $animal)
    {
        abort_if(Gate::denies('animal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $animal->delete();

        return back();
    }

    public function massDestroy(MassDestroyAnimalRequest $request)
    {
        Animal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('animal_create') && Gate::denies('animal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Animal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
