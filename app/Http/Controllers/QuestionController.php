<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $per_page = request()->query('per_page', 3);
        $questions = Question::with('options')->paginate($per_page);
        return response()->json([
            'questions' => $questions
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
            'question_text' => 'required|string',
            'points' => 'required|integer',
        ]);

        $question = Question::create($validated);
        return response()->json([
            'question' => $question,
            'message' => 'Question created successfully',
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        return response()->json([
            'question' => $question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer',
        ]);

        $question = Question::findOrFail($id);
        $question->update($validated);

        return response()->json([
            'question' => $question,
            'message' => 'Question updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully',
        ]);
    }
    public function count(){
        $count = Question::count();
        return response()->json([
            'count' => $count
        ]);
    }
}
