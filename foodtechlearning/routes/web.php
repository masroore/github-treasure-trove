<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MiscellaneousController::class, 'home'])->middleware('auth')->name('home');
Route::get('/download-attachments/{lesson}', [MiscellaneousController::class, 'download_attachments'])->middleware('auth')->name('download.attachments');

Route::middleware('guest')->group(function (): void {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function (): void {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function (): void {
    Route::get('chat', \App\Http\Livewire\ChatIndex::class)->name('chat');
    Route::get('videocall/{room}', \App\Http\Livewire\VideocallIndex::class)->name('videocall');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function (): void {
//    Route::get('dashboard',\App\Http\Livewire\Student\StudentDashboard::class)->name('dashboard');
    Route::get('courses', \App\Http\Livewire\Student\StudentCoursesIndex::class)->name('courses');
    Route::get('gradebook', \App\Http\Livewire\Student\StudentGradebook::class)->name('gradebook');
    Route::get('course/{course}', \App\Http\Livewire\Student\StudentCourseView::class)->name('course.lessons');
    Route::get('lesson/{lesson}', \App\Http\Livewire\Student\StudentLessonView::class)->name('lesson.view');
    Route::get('course/{course}/tasks', \App\Http\Livewire\Student\StudentTasksIndex::class)->name('course.tasks');
    Route::get('task/{task}/answer', \App\Http\Livewire\Student\StudentTaskAnswer::class)->name('task.answer');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function (): void {
//    Route::get('dashboard',\App\Http\Livewire\Teacher\TeacherDashboard::class)->name('dashboard');
    Route::get('courses', \App\Http\Livewire\Teacher\TeacherCoursesIndex::class)->name('courses');
    Route::get('deleted-courses', \App\Http\Livewire\Teacher\TeacherDeletedCourses::class)->name('courses.deleted');
    Route::get('course/{course}/lessons/create', \App\Http\Livewire\Teacher\TeacherLessonCreate::class)->name('lessons.create');
    Route::get('lesson/{lesson}/manage', \App\Http\Livewire\Teacher\TeacherLessonManage::class)->name('lesson.manage');
    Route::get('course/{course}/manage', \App\Http\Livewire\Teacher\TeacherCourseManage::class)->name('course.manage');
    Route::get('course/{course}/students', \App\Http\Livewire\Teacher\TeacherCourseStudents::class)->name('course.students');
    Route::get('course/{course}/tasks', \App\Http\Livewire\Teacher\TeacherTasksIndex::class)->name('tasks.index');
    Route::get('course/{course}/task/create', \App\Http\Livewire\Teacher\TeacherTaskCreate::class)->name('tasks.create');
    Route::get('course/{course}/roll-call', \App\Http\Livewire\Teacher\TeacherRollCall::class)->name('course.roll_call');
    Route::get('/task/{task}/manage', \App\Http\Livewire\Teacher\TeacherTaskManage::class)->name('tasks.manage');
    Route::get('/submission/{submission}/grade', \App\Http\Livewire\Teacher\TeacherSubmissionGrade::class)->name('submission.grade');
    Route::post('course/{course}/restore', [\App\Http\Controllers\TeacherController::class, 'restore_course'])->name('course.restore');
    Route::delete('course/{course}/delete', [\App\Http\Controllers\TeacherController::class, 'delete_course'])->name('course.delete');
    Route::delete('course/{course}/force-delete', [\App\Http\Controllers\TeacherController::class, 'force_delete_course'])->name('course.force_delete');
    Route::get('courses/create', \App\Http\Livewire\Teacher\TeacherCoursesCreate::class)->name('courses.create');
    Route::get('gradebook', \App\Http\Livewire\Teacher\TeacherGradebook::class)->name('gradebook');
});

Route::mediaLibrary();
