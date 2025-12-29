<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TestController::class, 'index']);
Route::middleware('auth')->group(function () {
Route::get('/', [AuthController::class, 'index']);



Route::get('/', [AuthorController::class, 'index']);
Route::get('/find', [AuthorController::class, 'find']);
Route::post('/find', [AuthorController::class, 'search']);
Route::get('/add', [AuthorController::class, 'add']);
Route::post('/add', [AuthorController::class, 'create']);
Route::get('/edit', [AuthorController::class, 'edit']);
Route::post('/edit', [AuthorController::class, 'update']);
Route::get('/delete', [AuthorController::class, 'delete']);
Route::post('/delete', [AuthorController::class, 'remove']);
Route::get('/verror', [AuthorController::class, 'verror']);


 });