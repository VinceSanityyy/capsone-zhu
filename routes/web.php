<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
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
      Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
      Route::post('/users/create', [UserController::class, 'store'])->name('users.store');

      Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcement.index');
      Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcement.create');
      Route::post('/announcements/create', [AnnouncementController::class, 'store'])->name('announcement.store');
    });
    Route::get('/profile', [UserController::class, 'showProfile'])->name('users.profile');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('/profile/update', [UserController::class, 'updateUserDetails'])->name('users.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/filters', [DashboardController::class, 'dataTableFilter']);

    Route::prefix('student')->group(function(){
      Route::get('/my-submissions', [StudentController::class, 'showSubmissions'])->name('student.submissions');
    });
    // Route::get('/users/filter', [DashboardController::class, 'filterUsers']);
});
