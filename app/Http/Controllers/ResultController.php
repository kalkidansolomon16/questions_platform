<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::get();
        return response()->json([
            'result' => $results
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'score' => 'required|numeric',
        ]);

        $result = Result::create($validated);
        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Result::findOrFail($id);
        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'score' => 'required|numeric',
        ]);

        $result = Result::findOrFail($id);
        $result->update($validated);

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return response()->json([
            'message' => 'Result deleted successfully'
        ]);
    }
}
