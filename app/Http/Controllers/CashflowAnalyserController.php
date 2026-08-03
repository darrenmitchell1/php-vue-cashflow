<?php

namespace App\Http\Controllers;

use App\Ai\Agents\CashflowAnalyser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CashflowAnalyserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(): Response
    {
        return Inertia::render('CashflowAnalyser/Show');
    }

    /**
     * Provision a new web server.
     */
    public function prompt(Request $request): JsonResponse
    {
        // $request->validate([
        //     'prompt' => 'required|string|max:200',
        // ]);

        $response = (new CashflowAnalyser)->prompt('Blah');

        return response()->json([(string) $response]);
    }
}
