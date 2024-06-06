<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportsAbuseRequest;
use App\Http\Requests\UpdateReportsAbuseRequest;
use App\Http\Resources\Admin\ReportsAbuseResource;
use App\Models\ReportsAbuse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsAbuseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reports_abuse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportsAbuseResource(ReportsAbuse::with(['user', 'post'])->get());
    }

    public function store(StoreReportsAbuseRequest $request)
    {
        $reportsAbuse = ReportsAbuse::create($request->all());

        return (new ReportsAbuseResource($reportsAbuse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportsAbuseResource($reportsAbuse->load(['user', 'post']));
    }

    public function update(UpdateReportsAbuseRequest $request, ReportsAbuse $reportsAbuse)
    {
        $reportsAbuse->update($request->all());

        return (new ReportsAbuseResource($reportsAbuse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReportsAbuse $reportsAbuse)
    {
        abort_if(Gate::denies('reports_abuse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportsAbuse->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
