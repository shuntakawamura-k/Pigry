<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// ゲストのみアクセス可能（会員登録・ログイン）
Route::middleware(['guest'])->group(function () {
    // 会員登録 Step 1
    Route::get('/register', [RegisterController::class, 'showStep1'])->name('register.step1');
    Route::post('/register', [RegisterController::class, 'postStep1']);

    // 会員登録 Step 2（ゲストグループに配置）
    Route::get('/register/step2', [RegisterController::class, 'showStep2'])->name('register.step2');
    Route::post('/register/step2', [RegisterController::class, 'postStep2']);

    // ログイン
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ログイン済みユーザーのみアクセス可能
Route::middleware(['auth'])->group(function () {
    // 体重管理画面（一覧・検索）
    Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs.index');

    // 体重ログ追加
    Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->name('weight_logs.create');
    Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store');

    // 目標体重設定
    Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'showGoalSetting'])->name('weight_logs.goal_setting');
    Route::put('/weight_logs/goal_setting', [WeightLogController::class, 'updateGoalSetting'])->name('weight_logs.update_goal');

    // 体重ログ詳細・更新・削除
    Route::get('/weight_logs/{id}', [WeightLogController::class, 'show'])->name('weight_logs.show');
    Route::put('/weight_logs/{id}', [WeightLogController::class, 'update'])->name('weight_logs.update');
    Route::delete('/weight_logs/{id}', [WeightLogController::class, 'destroy'])->name('weight_logs.destroy');

    // ログアウト
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
});
