<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('landing'); // Kita akan menimpa file welcome bawaan Laravel
})->name('home');

Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/generate', [QuizController::class, 'generate'])->name('quiz.generate');

Route::get('/history', [QuizController::class, 'history'])->name('quiz.history');
Route::get('/history/{id}', [QuizController::class, 'showHistory'])->name('quiz.showHistory');