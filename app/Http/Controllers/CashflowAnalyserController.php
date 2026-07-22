<?php

namespace App\Http\Controllers;

use App\Ai\Agents\CashflowAnalyser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CashflowAnalyserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('CashflowAnalyser/Show');
    }

    /**
     * Provision a new web server.
     */
    public function prompt(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:200',
        ]);

        $response = (new CashflowAnalyser)->prompt($request->validated());

        return response()->json(['reply' => (string) $response]);
    }
}
