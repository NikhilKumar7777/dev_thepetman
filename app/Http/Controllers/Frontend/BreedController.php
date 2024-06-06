<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBreedRequest;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Models\Breed;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreedController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('breed_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breeds = Breed::with(['team'])->get();

        return view('frontend.breeds.index', compact('breeds'));
    }

    public function create()
    {
        abort_if(Gate::denies('breed_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.breeds.create');
    }

    public function store(StoreBreedRequest $request)
    {
        $breed = Breed::create($request->all());

        return redirect()->route('frontend.breeds.index');
    }

    public function edit(Breed $breed)
    {
        abort_if(Gate::denies('breed_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->load('team');

        return view('frontend.breeds.edit', compact('breed'));
    }

    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        $breed->update($request->all());

        return redirect()->route('frontend.breeds.index');
    }

    public function show(Breed $breed)
    {
        abort_if(Gate::denies('breed_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->load('team');

        return view('frontend.breeds.show', compact('breed'));
    }

    public function destroy(Breed $breed)
    {
        abort_if(Gate::denies('breed_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->delete();

        return back();
    }

    public function massDestroy(MassDestroyBreedRequest $request)
    {
        Breed::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
