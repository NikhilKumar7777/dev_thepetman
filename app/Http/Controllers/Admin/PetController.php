<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPetRequest;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PetController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('pet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Pet::query()->select(sprintf('%s.*', (new Pet())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'pet_show';
                $editGate = 'pet_edit';
                $deleteGate = 'pet_delete';
                $crudRoutePart = 'pets';

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
            $table->editColumn('type', function ($row) {
                return $row->type ? Pet::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('breed', function ($row) {
                return $row->breed ? $row->breed : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.pets.index');
    }

    public function create()
    {
        abort_if(Gate::denies('pet_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pets.create');
    }

    public function store(StorePetRequest $request)
    {
        $pet = Pet::create($request->all());

        return redirect()->route('admin.pets.index');
    }

    public function edit(Pet $pet)
    {
        abort_if(Gate::denies('pet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pets.edit', compact('pet'));
    }

    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $pet->update($request->all());

        return redirect()->route('admin.pets.index');
    }

    public function show(Pet $pet)
    {
        abort_if(Gate::denies('pet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pets.show', compact('pet'));
    }

    public function destroy(Pet $pet)
    {
        abort_if(Gate::denies('pet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pet->delete();

        return back();
    }

    public function massDestroy(MassDestroyPetRequest $request)
    {
        Pet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
