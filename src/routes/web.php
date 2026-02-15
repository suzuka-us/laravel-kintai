<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampCorrectionRequestController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [TestController::class, 'index']);

// 一般ユーザー：登録
Route::get('/register', [RegisterController::class, 'create']);
Route::post('/register', [RegisterController::class, 'store']);

// 一般ユーザー：ログイン（★ name 必須）
Route::get('/login', [LoginController::class, 'create'])
    ->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

// 管理者ログイン
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])
        ->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'authenticate']);

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('auth')->name('admin.dashboard');
});

// 勤怠（ログイン必須）
Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])
        ->name('attendance.clockIn');

    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])
        ->name('attendance.clockOut');
    
        Route::post('/attendance/break-start', [AttendanceController::class, 'breakStart'])->name('attendance.breakStart');
    
        Route::post('/attendance/break-end', [AttendanceController::class, 'breakEnd'])->name('attendance.breakEnd');

});

// 勤怠一覧画面
Route::middleware('auth')->group(function () {
    Route::get('/attendance/list', [AttendanceController::class, 'list'])
        ->name('attendance.list');
});

// 勤怠詳細画面
Route::get('/attendance/detail/{id}', [AttendanceController::class, 'detail'])
    ->middleware('auth')
    ->name('attendance.detail');


// ★追加：勤怠更新用
Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
    ->middleware('auth')
    ->name('attendance.update');

// 申請一覧画面 
Route::middleware('auth')->group(function () {
    Route::get(
        '/stamp_correction_request/list',
        [StampCorrectionRequestController::class, 'requestList']
    )->name('stamp_correction_request.request_list');
});