<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

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

Route::get('/', function () {
  return view('welcome');
});

Route::group(['middleware' => ['accepted','auth']], function () {

    Route::prefix('admin')->group(function(){
      Route::get('/users', [DashboardController::class, 'showUsers'])->name('users.index');
      Route::get('/users-pending', [DashboardController::class, 'showInactiveUsers'])->name('users.index.inactive');

      Route::get('/users/user/{user}/show', [UserController::class, 'show'])->name('users.show');
      Route::put('/users/{user}/approve', [UserController::class, 'approveUser']);
      Route::put('/users/{user}/deactivate', [UserController::class, 'deactivateUser']);
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/filters', [DashboardController::class, 'dataTableFilter']);
    // Route::get('/users/filter', [DashboardController::class, 'filterUsers']);
});
