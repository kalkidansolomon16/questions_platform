<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentAuthController extends Controller
{
    // public function login(Request $request){
    //     $credentials = $request->only('email', 'password');
    //     if(!Auth::attempt($credentials)){
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }
    //     $request->session()->regenerate();
    //     return response()->json(['message' => 'Login successful']);
    // }
        public function login(Request $request)
    {
        // $request->validate([
        //     'email'=>'required|email|exists"users',
        //     'password'=>'required'
        // ]);
        // $user = User::where('email',$request->email)->first();
        // if(!$user || !Hash::check($request->password,$user->password)){
        //     return response()->json([
        //         'message'=>'The provided credentials are incorrect'
        
        //         ]);
        // }
        // $token = $user->createToken($user->user_name);
        // return response()->json([
        //     'user'=>$user,
        //     'token'=>$token->plainTextToken
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed ',
                'errors' => $validator->errors(),
            ], 422);
        }

     
        $student = Student::where('email', $request->email)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $randomStr = Str::random(40);
        $token = $student->createToken($randomStr)->plainTextToken;
        $studentID = $student->id;
        $student = Student::find($studentID);
        return response()->json([
            'token' => $token,
            'student_id' => $studentID,
            'student' => $student
        ], 200);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logout successful']);    
    }
    public function student(Request $request){
        return $request->student();
    }
}