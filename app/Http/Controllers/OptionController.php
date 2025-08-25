<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::all();
        return response()->json([
            'options' => $options
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
        'question_id' => 'required|exists:questions,id',
        'options' => 'required|array|min:1',
        'options.*.option_text' => 'required|string',
        'options.*.is_correct' => 'required|boolean',
        ]);

        $options = [];
        foreach ($validated['options'] as $optionData) {
            $options[] = new Option($optionData);
        }

        $question = Question::findOrFail($validated['question_id']);
        $question->options()->saveMany($options);

        return response()->json([
            'message' => 'Options created successfully',
        ]);
    }

  
 

    
    public function show(string $id)
    {
        $option = Option::findOrFail($id);
        return response()->json([
            'option' => $option
        ]);
    }

  
    public function edit(string $id)
    {
        //
    }

  
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $option = Option::findOrFail($id);
        $option->update($validated);

        return response()->json([
            'option' => $option,
            'message' => 'Option updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $option = Option::findOrFail($id);
        $option->delete();

        return response()->json([
            'message' => 'Option deleted successfully',
        ]);
    }
}
