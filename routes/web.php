<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [ActivityController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
|  (ผู้ใช้ทั่วไป)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student,admin_club,staff,admin'])->group(function () {

    Route::get('/activities', [ActivityController::class, 'index'])->name('activities');

    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');

    Route::post('/activities/{id}/register', [RegistrationController::class,'register'])->name('activities.register');

    Route::get('/my-activities', [RegistrationController::class,'myActivities'])->name('My-activities');
});

/*
|--------------------------------------------------------------------------
| ADMIN CLUB (คนสร้างกิจกรรม)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin_club'])->group(function () {

    Route::get('/create-activity', [ActivityController::class, 'create'])->name('activities.create');

    Route::post('/create-activity', [ActivityController::class, 'store'])->name('activities.store');

    Route::get('/my-created-activities', [ActivityController::class, 'myActivities']);

    // เส้นทางสำหรับแสดงหน้าฟอร์มแก้ไข
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit']);
    // เส้นทางสำหรับรับข้อมูลที่แก้ไขแล้วไปบันทึก (ใช้ PUT หรือ PATCH)
    Route::put('/activities/{id}', [ActivityController::class, 'update']);

    Route::post('/registrations/{id}/approve', [ActivityController::class, 'approveParticipant']);

    Route::post('/registrations/{id}/reject', [ActivityController::class, 'rejectParticipant']);

});

/*
|--------------------------------------------------------------------------
| STAFF (คนอนุมัติกิจกรรม)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staff'])->group(function () {

    // Registrations
    Route::get('/admin/registrations', [RegistrationController::class, 'adminIndex']);
    Route::post('/admin/registrations/{id}/approve', [RegistrationController::class, 'approve']);
    Route::post('/admin/registrations/{id}/reject', [RegistrationController::class, 'reject']);

    // Activities
    Route::get('/admin/activities', [ActivityController::class, 'adminIndex']);
    Route::post('/admin/activities/{id}/approve', [ActivityController::class, 'approve']);
    Route::post('/admin/activities/{id}/reject', [ActivityController::class, 'reject']);
    Route::delete('/admin/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // Review & Analytics
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.review');
});

/*
|--------------------------------------------------------------------------
| ADMIN (จัดการ role ของ user + เข้าถึง review)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{id}/role', [App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');

    // Admin ดู review ได้ด้วย
    Route::get('/admin/review', [AdminReviewController::class, 'index'])->name('admin.review.admin');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';