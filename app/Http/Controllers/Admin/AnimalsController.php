<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class AnimalsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('animal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Animal::with(['breed', 'user'])->select(sprintf('%s.*', (new Animal())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'animal_show';
                $editGate = 'animal_edit';
                $deleteGate = 'animal_delete';
                $crudRoutePart = 'animals';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('icon', function ($row) {
                if ($photo = $row->icon) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? Animal::GENDER_SELECT[$row->gender] : '';
            });
            $table->addColumn('breed_type', function ($row) {
                return $row->breed ? $row->breed->type : '';
            });

            $table->editColumn('pet_type', function ($row) {
                return $row->pet_type ? Animal::PET_TYPE_SELECT[$row->pet_type] : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'icon', 'breed', 'user']);

            return $table->make(true);
        }

        return view('admin.animals.index');
    }

    public function create()
    {
        abort_if(Gate::denies('animal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breeds = Pet::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.animals.create', compact('breeds', 'users'));
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

        return redirect()->route('admin.animals.index');
    }

    public function edit(Animal $animal)
    {
        abort_if(Gate::denies('animal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breeds = Pet::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $animal->load('breed', 'user');

        return view('admin.animals.edit', compact('animal', 'breeds', 'users'));
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

        return redirect()->route('admin.animals.index');
    }

    public function show(Animal $animal)
    {
        abort_if(Gate::denies('animal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $animal->load('breed', 'user');

        return view('admin.animals.show', compact('animal'));
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
