<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $results = Result::with('student')->paginate($perPage);
        return response()->json([
            'result' => $results
        ]);
    }

  
    public function create()
    {
        
    }


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

   
    public function show(string $id)
    {
        $result = Result::findOrFail($id);
        return response()->json([
            'result' => $result
        ]);
    }

   
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
    public function count(){
        $resultcount = Result::count();
        return response()->json([
            'count' => $resultcount
        ]);
    }
}
