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
    
    Route::get('upload1', function () { return view('excel/upload1'); })->name('upload1');
    Route::get('upload2', function () { return view('excel/upload2'); })->name('upload2');
    Route::get('upload3', function () { return view('excel/upload3'); })->name('upload3');
    Route::get('upload4', function () { return view('excel/upload4'); })->name('upload4');
    Route::get('upload5', function () { return view('excel/upload5'); })->name('upload5');
    Route::get('upload0', function () { return view('excel/upload0'); })->name('upload0');
    Route::get('uploadEx1', function () { return view('excel/uploadEx1')->with('file_type','csv'); })->name('uploadEx1');

    Route::post('excel/upload1', [ExcelController::class, 'upload1']);
    Route::post('excel/upload2', [ExcelController::class, 'upload2']);
    Route::post('excel/upload3', [ExcelController::class, 'upload3']);
    Route::post('excel/upload4', [ExcelController::class, 'upload4']);
    Route::post('excel/upload5', [ExcelController::class, 'upload5']);
    Route::post('excel/upload0', [ExcelController::class, 'upload0']);
    Route::post('excel/uploadEx1', [ExcelController::class, 'uploadEx1'])->name('uploadEx1_post');


    




    Route::get('request', function () { return view('quiz/request'); })->name('request');
    
    Route::get('request1', function () { return view('quiz/request1'); })->name('request1');
    Route::get('request1_m', function () { return view('quiz/request1_m'); })->name('request1_m');
    Route::get('request2', function () { return view('quiz/request2'); })->name('request2');
    Route::get('request3', function () { return view('quiz/request3'); })->name('request3');
    Route::get('request3_1', function () { return view('quiz/request3_1'); })->name('request3_1');

    Route::get('request1_s', function () { return view('quiz/request1_s'); })->name('request1_s');
    Route::get('request2_s', function () { return view('quiz/request2_s'); })->name('request2_s');
    Route::get('request3_s', function () { return view('quiz/request3_s'); })->name('request3_s');

    Route::get('explain', function () { return view('quiz/explain'); })->name('explain');

    Route::get('explain1', function () { return view('quiz/explain1'); })->name('explain1');
    Route::get('explain1_m', function () { return view('quiz/explain1_m'); })->name('explain1_m');
    Route::get('explain2', function () { return view('quiz/explain2'); })->name('explain2');
    Route::get('explain3', function () { return view('quiz/explain3'); })->name('explain3');
    Route::get('explain3_1', function () { return view('quiz/explain3_1'); })->name('explain3_1');

    Route::get('explain1_s', function () { return view('quiz/explain1_s'); })->name('explain1_s');
    Route::get('explain2_s', function () { return view('quiz/explain2_s'); })->name('explain2_s');
    Route::get('explain3_s', function () { return view('quiz/explain3_s'); })->name('explain3_s');

    Route::get('quiz', [UserController::class, 'viewQuiz'])->name('quiz');
    
    
    Route::get('quiz1', [UserController::class, 'viewQuiz1'])->name('quiz1');
    Route::get('quiz2', [UserController::class, 'viewQuiz2'])->name('quiz2');
    Route::get('quiz3', [UserController::class, 'viewQuiz3'])->name('quiz3');
    
    Route::get('quiz3_1', [UserController::class, 'viewQuiz3_1'])->name('quiz3_1');
    Route::post('quiz3_2', [UserController::class, 'viewQuiz3_2'])->name('quiz3_2');
    Route::post('quiz3_3', [UserController::class, 'viewQuiz3_3'])->name('quiz3_3');

    Route::get('quiz1_s', [UserController::class, 'viewQuiz1_s'])->name('quiz1_s');
    Route::get('quiz2_s', [UserController::class, 'viewQuiz2_s'])->name('quiz2_s');
    Route::get('quiz3_s', [UserController::class, 'viewQuiz3_s'])->name('quiz3_s');

    Route::get('quiz1_m', [UserController::class, 'viewQuiz1_m'])->name('quiz1_m');
    Route::post('quiz2_m', [UserController::class, 'viewQuiz2_m'])->name('quiz2_m');
    Route::post('quiz3_m', [UserController::class, 'viewQuiz3_m'])->name('quiz3_m');
    






    Route::post('express', [UserController::class, 'viewExpress'])->name('express');
    
    Route::post('result', [UserController::class, 'viewResult'])->name('result');

    Route::post('result1', [UserController::class, 'viewResult1'])->name('result1');
    Route::post('result2', [UserController::class, 'viewResult2'])->name('result2');
    Route::post('result3', [UserController::class, 'viewResult3'])->name('result3');
    Route::post('result3_1', [UserController::class, 'viewResult3_1'])->name('result3_1');
    
    Route::post('result1_s', [UserController::class, 'viewResult1_s'])->name('result1_s');
    Route::post('result2_s', [UserController::class, 'viewResult2_s'])->name('result2_s');
    Route::post('result3_s', [UserController::class, 'viewResult3_s'])->name('result3_s');
    
    Route::post('result3_m', [UserController::class, 'viewResult3_m'])->name('result3_m');

    
    Route::get('data', function () { return view('quiz/data'); })->name('data');
    













    Route::get('admin', [UserController::class, 'recruimentUser'])->name('admin');
    Route::get('admin/sales', [UserController::class, 'salesUser'])->name('admin.sales');
    Route::get('admin/management', [UserController::class, 'managementUser'])->name('admin.management');

    Route::get('admin/quiz', [UserController::class, 'recruimentQuiz'])->name('admin.quiz');
    Route::get('admin/quiz/sales', [UserController::class, 'salesQuiz'])->name('admin.quiz.sales');
    Route::get('admin/quiz/management', [UserController::class, 'managementQuiz'])->name('admin.quiz.management');





    Route::post('add/quiz', [UserController::class, 'addQuiz'])->name('add.quiz');
    Route::post('update/quiz', [UserController::class, 'updateQuiz'])->name('update.quiz');
    Route::post('del/quiz', [UserController::class, 'delQuiz'])->name('del.quiz');



    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('add/user', [UserController::class, 'addUser'])->name('add.user');
    Route::get('del/user', [UserController::class, 'delUser'])->name('del.user');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');




});

require __DIR__ . '/auth.php';
