<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResearchPaperController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;
use App\Http\Controllers\AdviserController;
use App\Http\Controllers\PanelController;

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
      Route::get('/research-paper/{researchPaper}', [ResearchPaperController::class, 'show'])->name('admin.research-paper.show');

      Route::post('/submissions/{researchPaper}/add-panel-members', [ResearchPaperController::class, 'addPanelMembers'])->name('admin.research-paper.add-panels');
    });
    Route::get('/profile', [UserController::class, 'showProfile'])->name('users.profile');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('/profile/update', [UserController::class, 'updateUserDetails'])->name('users.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/filters', [DashboardController::class, 'dataTableFilter']);

    Route::prefix('student')->group(function(){
      Route::get('/my-submissions', [StudentController::class, 'showSubmissions'])->name('student.submissions');
      Route::post('/my-submissions/submit', [StudentController::class, 'submitResearchPaper'])->name('student.research.submit');
    });

    Route::prefix('adviser')->group(function(){
      Route::get('/advised-papers', [AdviserController::class, 'getAssignedStudents'])->name('adviser.students');
      Route::get('/advised-papers/{id}/show', [AdviserController::class, 'showAssignedPaper'])->name('adviser.students.show');
      Route::post('/advised-papers/{id}/comment', [AdviserController::class, 'addAdviserComment'])->name('adviser.students.comment');
      Route::post('/advised-papers/{id}/approve', [AdviserController::class, 'approvePaper'])->name('adviser.students.approve');
    });

    Route::prefix('panel')->group(function(){
      Route::get('/panelled-papers', [PanelController::class, 'panelledPapers'])->name('panel.students');
      Route::get('/panelled-papers/{id}/show', [PanelController::class, 'showPanelledPaper'])->name('panel.students.show');
      Route::post('/panelled-papers/{id}/comment', [PanelController::class, 'addPanelComment'])->name('panel.students.comment');
    });
    // Route::get('/users/filter', [DashboardController::class, 'filterUsers']);
});
