<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Http\Controllers\OldStudentController;
use App\Http\Controllers\TransfereeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TransfereesController;
use App\Http\Controllers\Admin\StrandsController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\Student;

// Public Routes
Route::get('/', function () {
    // Check if any admin exists in the database
    if (\App\Models\Admin::count() === 0) {
        return redirect()->route('admin.setup');
    }
    return view('welcome');
});

// Transferee Routes
Route::get('/transferee', [TransfereeController::class, 'index'])->name('transferee.index');
Route::post('/transferee', [TransfereeController::class, 'store'])->name('transferee.store');

// Old Student Verification and Registration
Route::get('/verify', [OldStudentController::class, 'verifyForm'])->name('verify.form');
Route::post('/verify', [OldStudentController::class, 'verifyStudent'])->name('verify');
Route::get('/old-student', [OldStudentController::class, 'showRegistrationForm'])->name('old-student');
Route::post('/old-student/register', [OldStudentController::class, 'register'])->name('old-student.register');

// Admin first-time setup (only accessible if no admin exists)
Route::get('/admin/setup', [AdminController::class, 'showSetupForm'])->name('admin.setup');
Route::post('/admin/setup', [AdminController::class, 'setupAdmin'])->name('admin.setup.post');

// Admin Authentication Routes (add middleware to check if admin exists)
Route::get('/admin', [AdminController::class, 'showLoginForm'])->middleware('admin.exists')->name('admin.login');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login.post');
Route::get('/admin/register', function () {
    return view('admin.register');
})->name('admin.register');
Route::post('/admin/register/submit', [AdminController::class, 'register'])->name('admin.register.submit');

// Registration Success Page
Route::get('/registration-success', function () {
    return view('registration-success');
})->name('registration.success');

Route::middleware(['guest'])->group(function () {
    Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Students
    Route::resource('students', StudentController::class);
    Route::post('students/register-old', [StudentController::class, 'registerOldStudent'])->name('students.register-old');

    // Strands
    Route::resource('strands', StrandsController::class);

    // Subjects - properly defined in one place
    Route::resource('subjects', SubjectController::class);

    // Transferees
    Route::resource('transferees', TransfereesController::class);
    Route::put('/transferees/{id}/accept', [TransfereeController::class, 'accept'])->name('transferees.accept');
    Route::delete('/transferees/{id}/decline', [TransfereeController::class, 'decline'])->name('transferees.decline');
    Route::post('/transferees/{id}/enroll', [TransfereesController::class, 'enroll'])->name('transferees.enroll');

    // Faculty
    Route::resource('faculty', FacultyController::class);

    // Enrollment
    Route::resource('enrollment', EnrollmentController::class);
    Route::post('/enrollment/{id}/accept', [EnrollmentController::class, 'acceptTransferee'])->name('enrollment.accept');

    // Sections
    Route::resource('sections', SectionController::class);
    Route::get('/section', [SectionController::class, 'index'])->name('section.index');
    Route::post('/section', [SectionController::class, 'store'])->name('section.store');
    Route::get('/section/create', [SectionController::class, 'create'])->name('section.create');
    Route::get('/section/{section}', [SectionController::class, 'show'])->name('section.show');
    Route::put('/section/{section}', [SectionController::class, 'update'])->name('section.update');
    Route::delete('/section/{section}', [SectionController::class, 'destroy'])->name('section.destroy');

    // Profile Settings
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profileSettings.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profileSettings.update');

    // Old Student Management
    Route::get('/old-students', [Admin\OldStudentController::class, 'index'])->name('old_students.index');
    Route::get('/old-students/grade/{level}', [Admin\OldStudentController::class, 'gradeLevel'])->name('old_students.grade_level');
    Route::get('/old-students/create', [Admin\OldStudentController::class, 'create'])->name('old_students.create');
    Route::post('/old-students', [Admin\OldStudentController::class, 'store'])->name('old_students.store');
    Route::get('/old-students/{id}', [Admin\OldStudentController::class, 'show'])->name('old_students.show');
    Route::get('/old-students/{id}/edit', [Admin\OldStudentController::class, 'edit'])->name('old_students.edit');
    Route::put('/old-students/{id}', [Admin\OldStudentController::class, 'update'])->name('old_students.update');
    Route::delete('/old-students/{id}', [Admin\OldStudentController::class, 'destroy'])->name('old_students.destroy');
    Route::post('/old-students/{id}/approve', [Admin\OldStudentController::class, 'approve'])->name('old_students.approve');
    Route::post('/old-students/promote', [Admin\OldStudentController::class, 'promoteStudents'])->name('old_students.promote');
    Route::post('/old-students/mark-passed', [Admin\OldStudentController::class, 'markAsPassed'])->name('old_students.mark_passed');
    
    // Schedule Management
    Route::get('/schedules', [Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [Admin\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{id}', [Admin\ScheduleController::class, 'show'])->name('schedules.show');
    Route::get('/schedules/{id}/edit', [Admin\ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/schedules/{id}', [Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{id}', [Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::get('/schedules/faculty/{facultyId}', [Admin\ScheduleController::class, 'facultySchedule'])->name('schedules.faculty');
    Route::get('/schedules/section/{sectionId}', [Admin\ScheduleController::class, 'sectionSchedule'])->name('schedules.section');
    Route::get('/schedules/student/{studentId}', [Admin\ScheduleController::class, 'studentSchedule'])->name('schedules.student');
    Route::get('/schedules/generate', [Admin\ScheduleController::class, 'generateSectionSchedules'])->name('schedules.generate');
});

// Strand list API (for AJAX)
Route::get('/admin/strands/list', [App\Http\Controllers\Admin\StrandController::class, 'getStrands'])
    ->middleware(['auth:admin'])
    ->name('admin.strands.list');

// Test Email Sending Route
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel using Gmail SMTP!', function ($message) {
        $message->to('recipient@example.com')
                ->subject('Test Email');
    });
    return 'Email sent!';
});