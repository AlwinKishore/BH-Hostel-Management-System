<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MaintenanceRequestController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeStructureController;
use Illuminate\Support\Facades\Route;
 
Route::get('/', function () {
    return redirect()->route('login');
});
 
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    // Buildings Module
    Route::resource('buildings', BuildingController::class);
 
    // Rooms Module
    Route::resource('rooms', RoomController::class);
 
    // Furniture Module
    Route::resource('furniture', FurnitureController::class);
 
    // Students Module
    Route::resource('students', StudentController::class);
 
    // Attendance Module
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
 
    // Payments Module
    Route::resource('payments', PaymentController::class);
 
    // Maintenance Module
    Route::resource('maintenance', MaintenanceRequestController::class);
    Route::patch('/maintenance/{maintenance}/status', [MaintenanceRequestController::class, 'updateStatus'])->name('maintenance.updateStatus');

    // Expenses Module
    Route::resource('expenses', ExpenseController::class);
    Route::patch('/expenses/{expense}/status', [ExpenseController::class, 'updateStatus'])->name('expenses.updateStatus');

    // Fee Structures (Prices Palette)
    Route::resource('fee-structures', FeeStructureController::class);
 
    // Complaints Module
    Route::resource('complaints', ComplaintController::class);
 
    // Users Module
    Route::resource('users', UserController::class);
 
    // Reports Module
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
    Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});
 
require __DIR__.'/auth.php';
