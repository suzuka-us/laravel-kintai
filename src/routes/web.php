<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\AttendanceController;


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
Route::middleware('auth')->group(function () {});

Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create']);
Route::post('/login', [LoginController::class, 'authenticate']);


Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create']);
Route::post('/login', [LoginController::class, 'authenticate']);

// 管理者用ログイン画面
Route::prefix('admin')->group(function () {
Route::get('/login', [AdminLoginController::class, 'create'])->name('admin.login');
Route::post('/login', [AdminLoginController::class, 'authenticate']);
Route::get('/dashboard', function () {
        return view('admin.dashboard'); // 別途Blade作成
    })->middleware('auth')->name('admin.dashboard');
});

// 勤怠登録画面
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/attendance', [AttendanceController::class, 'index'])
    ->middleware('auth'); // ログイン必須