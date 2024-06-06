<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPetRequest;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pets = Pet::all();

        return view('frontend.pets.index', compact('pets'));
    }

    public function create()
    {
        abort_if(Gate::denies('pet_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pets.create');
    }

    public function store(StorePetRequest $request)
    {
        $pet = Pet::create($request->all());

        return redirect()->route('frontend.pets.index');
    }

    public function edit(Pet $pet)
    {
        abort_if(Gate::denies('pet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pets.edit', compact('pet'));
    }

    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $pet->update($request->all());

        return redirect()->route('frontend.pets.index');
    }

    public function show(Pet $pet)
    {
        abort_if(Gate::denies('pet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pets.show', compact('pet'));
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
