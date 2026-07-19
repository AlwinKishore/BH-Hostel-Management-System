<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HostellerController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
 
Route::get('/', function () {
    return redirect()->route('login');
});
 
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Global Search
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    // Academic Setup
    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('batches', BatchController::class);
    Route::resource('categories', CategoryController::class);

    // Hostel Core
    Route::resource('rooms', RoomController::class);
    Route::resource('students', HostellerController::class);
 
    // Operations
    Route::resource('leaves', LeaveController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('remarks', RemarkController::class);
 
    // Users Module
    Route::resource('users', UserController::class);
});
 
require __DIR__.'/auth.php';
