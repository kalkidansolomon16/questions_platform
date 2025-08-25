<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $per_page = request()->query('per_page', 10);
        $students = Student::paginate($per_page);
        return response()->json([
            'students' => $students,
            'message' => 'Student list retrieved successfully.'
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);
     $validatedData['password'] = Hash::make($validatedData['password']);
        $student = Student::create($validatedData);

        return response()->json([
            'student' => $student,
            'message' => 'Student created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        return response()->json([
            'student' => $student
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
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:students,email,' . $student->id,
            'password' => 'sometimes|required|string|min:8',
            'phone' => 'sometimes|required|string|max:15',
            'address' => 'sometimes|nullable|string|max:255',
        ]);

        $student->update($validatedData);

        return response()->json([
            'student' => $student,
            'message' => 'Student updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.'
        ]);

    }
    public function count(){
        $count = Student::count();
        return response()->json([
            'count' => $count
        ]);
    }
}
