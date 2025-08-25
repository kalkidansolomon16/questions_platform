<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentAuthController;
Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('user',[UserController::class,'update']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
});
Route::get('/students', [StudentController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/sregister', [StudentAuthController::class, 'register']);
Route::post('/slogin', [StudentAuthController::class, 'login']);
Route::post('/slogout', [StudentAuthController::class, 'logout']);


Route::post('/students', [StudentController::class, 'store']);


Route::get('/questions', [QuestionController::class, 'index']);
Route::post('/questions', [QuestionController::class, 'store']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::put('/questions/{id}', [QuestionController::class, 'update']);
Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);

Route::get('/results', [ResultController::class, 'index']);
Route::post('/results', [ResultController::class, 'store']);
Route::get('/results/{id}', [ResultController::class, 'show']);
Route::put('/results/{id}', [ResultController::class, 'update']);
Route::delete('/results/{id}', [ResultController::class, 'destroy']);

Route::get('/studentcount', [StudentController::class, 'count']);


Route::get('/choices', [OptionController::class, 'index']);
Route::post('/choices', [OptionController::class, 'store']);
Route::get('/choices/{id}', [OptionController::class, 'show']);
Route::put('/choices/{id}', [OptionController::class, 'update']);
Route::delete('/choices/{id}', [OptionController::class, 'destroy']);

Route::get('/questioncount', [QuestionController::class, 'count']);
