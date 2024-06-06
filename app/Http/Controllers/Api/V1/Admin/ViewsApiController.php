<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreViewRequest;
use App\Http\Requests\UpdateViewRequest;
use App\Http\Resources\Admin\ViewResource;
use App\Models\View;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ViewResource(View::with(['user', 'post'])->get());
    }

    public function store(StoreViewRequest $request)
    {
        $view = View::create($request->all());

        return (new ViewResource($view))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(View $view)
    {
        abort_if(Gate::denies('view_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ViewResource($view->load(['user', 'post']));
    }

    public function update(UpdateViewRequest $request, View $view)
    {
        $view->update($request->all());

        return (new ViewResource($view))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(View $view)
    {
        abort_if(Gate::denies('view_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $view->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
