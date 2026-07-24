<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementShowRequest;
use App\Services\StatementService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class StatementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Statement/Index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatementShowRequest $request): JsonResponse
    {
        $request->validated();

        $periodFrom = $request->date('period_from');
        $periodTo = $request->date('period_to');

        return response()->json(['statement' => StatementService::buildStatementData($periodFrom, $periodTo)]);
    }
}
