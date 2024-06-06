<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBreedRequest;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Models\Breed;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BreedController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('breed_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Breed::with(['team'])->select(sprintf('%s.*', (new Breed())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'breed_show';
                $editGate = 'breed_edit';
                $deleteGate = 'breed_delete';
                $crudRoutePart = 'breeds';

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
                return $row->type ? Breed::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('breed', function ($row) {
                return $row->breed ? $row->breed : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.breeds.index');
    }

    public function create()
    {
        abort_if(Gate::denies('breed_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.breeds.create');
    }

    public function store(StoreBreedRequest $request)
    {
        $breed = Breed::create($request->all());

        return redirect()->route('admin.breeds.index');
    }

    public function edit(Breed $breed)
    {
        abort_if(Gate::denies('breed_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->load('team');

        return view('admin.breeds.edit', compact('breed'));
    }

    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        $breed->update($request->all());

        return redirect()->route('admin.breeds.index');
    }

    public function show(Breed $breed)
    {
        abort_if(Gate::denies('breed_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breed->load('team');

        return view('admin.breeds.show', compact('breed'));
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
