<?php

use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\GenerateMatchesController;
use App\Http\Controllers\MatchResultController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('start');
});

Route::get('/championship', ChampionshipController::class);
Route::get('/match-results/{week?}', MatchResultController::class);
//Route::get('/generate', GenerateMatchesController::class);
Route::get('/generate', GenerateMatchesController::class)->middleware('generate');
//Route::get('/generate/{amount?}', GenerateMatchesController::class);
