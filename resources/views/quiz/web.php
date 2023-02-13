<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExcelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Imports
Route::post('import/array', [ImportController::class, 'array'])->name('import.array');
Route::post('import/excel', [ImportController::class, 'excel'])->name('import.excel');
Route::post('import/spatie', [ImportController::class, 'spatie'])->name('import.spatie');
Route::post('import/fast-excel', [ImportController::class, 'fastExcel'])->name('import.fast-excel');

// Exports
Route::get('export/array', [ExportController::class, 'array'])->name('export.array');
Route::get('export/excel', [ExportController::class, 'excel'])->name('export.excel');
Route::get('export/spatie', [ExportController::class, 'spatie'])->name('export.spatie');
Route::get('export/fast-excel', [ExportController::class, 'fastExcel'])->name('export.fast-excel');

Route::middleware('auth')->group(function () {

    Route::get('/', function () { return view('home'); })->name('home');
    
    // Route::get('upload1', function () { return view('excel/upload1'); })->name('upload1');
    // Route::get('upload2', function () { return view('excel/upload2'); })->name('upload2');
    // Route::get('upload3', function () { return view('excel/upload3'); })->name('upload3');
    // Route::get('upload4', function () { return view('excel/upload4'); })->name('upload4');
    // Route::get('upload5', function () { return view('excel/upload5'); })->name('upload5');
    // Route::get('upload0', function () { return view('excel/upload0'); })->name('upload0');
    // Route::get('uploadEx1', function () { return view('excel/uploadEx1')->with('file_type','csv'); })->name('uploadEx1');

    // Route::post('excel/upload1', [ExcelController::class, 'upload1']);
    // Route::post('excel/upload2', [ExcelController::class, 'upload2']);
    // Route::post('excel/upload3', [ExcelController::class, 'upload3']);
    // Route::post('excel/upload4', [ExcelController::class, 'upload4']);
    // Route::post('excel/upload5', [ExcelController::class, 'upload5']);
    // Route::post('excel/upload0', [ExcelController::class, 'upload0']);
    // Route::post('excel/uploadEx1', [ExcelController::class, 'uploadEx1'])->name('uploadEx1_post');





    Route::get('request', function () { return view('quiz/request'); })->name('request');
    Route::get('explain', function () { return view('quiz/explain'); })->name('explain');

    Route::get('quiz', [UserController::class, 'viewQuiz'])->name('quiz');
    Route::post('quiz2', [UserController::class, 'viewQuiz2'])->name('quiz2');
    Route::post('quiz3', [UserController::class, 'viewQuiz3'])->name('quiz3');
    Route::post('express', [UserController::class, 'viewExpress'])->name('express');
    Route::post('result', [UserController::class, 'viewResult'])->name('result');
    
    Route::get('data', function () { return view('quiz/data'); })->name('data');
    








    




    Route::get('admin', [UserController::class, 'recruimentUser'])->name('admin');
    Route::get('admin/sales', [UserController::class, 'salesUser'])->name('admin.sales');
    Route::get('admin/management', [UserController::class, 'managementUser'])->name('admin.management');

    Route::get('admin/quiz', [UserController::class, 'recruimentQuiz'])->name('admin.quiz');
    Route::get('admin/quiz/sales', [UserController::class, 'salesQuiz'])->name('admin.quiz.sales');
    Route::get('admin/quiz/management', [UserController::class, 'managementQuiz'])->name('admin.quiz.management');

    Route::post('add/quiz', [UserController::class, 'addRecruimentQuiz'])->name('add.quiz');
    Route::post('del/quiz', [UserController::class, 'delRecruimentQuiz'])->name('del.quiz');












    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('add/user', [UserController::class, 'addUser'])->name('add.user');
    Route::get('del/user', [UserController::class, 'delUser'])->name('del.user');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');




});

require __DIR__ . '/auth.php';
