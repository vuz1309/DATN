<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassTimeableController;
use App\Http\Controllers\ExaminationsController;
use App\Models\ExamScheduleModel;

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



Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotpassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);


Route::group(['middware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'PostAdd']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'PostEdit']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);


    // class
    Route::get('admin/class/list', [ClassController::class, 'list']);
    Route::get('admin/class/add', [ClassController::class, 'add']);

    Route::post('admin/class/add', [ClassController::class, 'PostAdd']);

    Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('admin/class/edit/{id}', [ClassController::class, 'PostEdit']);
    Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

    // subject
    Route::get('admin/subject/list', [SubjectController::class, 'list']);
    Route::get('admin/subject/add', [SubjectController::class, 'add']);

    Route::post('admin/subject/add', [SubjectController::class, 'PostAdd']);

    Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('admin/subject/edit/{id}', [SubjectController::class, 'PostEdit']);
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // assign_subject
    Route::get('admin/assign_subject/list', [ClassSubjectController::class, 'list']);
    Route::get('admin/assign_subject/add', [ClassSubjectController::class, 'add']);

    Route::post('admin/assign_subject/add', [ClassSubjectController::class, 'PostAdd']);

    Route::get('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
    Route::get('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'editSingle']);
    Route::post('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'PostEditSingle']);
    Route::post('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'PostEdit']);
    Route::get('admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete']);

    Route::get('admin/change_password', [UserController::class, 'changePassword']);
    Route::post('admin/change_password', [UserController::class, 'PostChangePassword']);

    // teacher
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::get('admin/teacher/add', [TeacherController::class, 'add']);

    Route::post('admin/teacher/add', [TeacherController::class, 'PostAdd']);

    Route::get('admin/teacher/edit/{id}', [TeacherController::class, 'edit']);
    Route::post('admin/teacher/edit/{id}', [TeacherController::class, 'PostEdit']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'delete']);


    // student
    Route::get('admin/student/list', [StudentController::class, 'list']);
    Route::get('admin/student/add', [StudentController::class, 'add']);

    Route::post('admin/student/add', [StudentController::class, 'PostAdd']);

    Route::get('admin/student/edit/{id}', [StudentController::class, 'edit']);
    Route::post('admin/student/edit/{id}', [StudentController::class, 'PostEdit']);
    Route::get('admin/student/delete/{id}', [StudentController::class, 'delete']);

    // parent
    Route::get('admin/parent/list', [ParentController::class, 'list']);
    Route::get('admin/parent/add', [ParentController::class, 'add']);

    Route::post('admin/parent/add', [ParentController::class, 'PostAdd']);

    Route::get('admin/parent/edit/{id}', [ParentController::class, 'edit']);
    Route::post('admin/parent/edit/{id}', [ParentController::class, 'PostEdit']);
    Route::get('admin/parent/delete/{id}', [ParentController::class, 'delete']);
    Route::get('admin/parent/my-student/{id}', [ParentController::class, 'myStudent']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'assignStudentParent']);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}', [ParentController::class, 'deleteAssignStudentParent']);


    // account
    Route::get('admin/account', [UserController::class, 'myAccount']);

    Route::post('admin/account', [UserController::class, 'PostUpdateMyAccountAdmin']);


    // assign teacher class
    Route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list']);
    Route::get('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'add']);

    Route::post('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'PostAdd']);

    Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'edit']);
    Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'PostEdit']);
    Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);

    Route::get('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'editSingle']);
    Route::post('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'PostEditSingle']);

    Route::get('admin/class_timeable/list', [ClassTimeableController::class, 'list']);
    Route::get('admin/class_timeable/add', [ClassTimeableController::class, 'add']);
    Route::post('admin/class_timeable/get_subject', [ClassTimeableController::class, 'getSubject']);
    Route::post('admin/class_timeable/add', [ClassTimeableController::class, 'PostAdd']);

    // exam
    Route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);

    Route::post('admin/examinations/exam/add', [ExaminationsController::class, 'PostExaxmAdd']);

    Route::get('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);

    Route::post('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'PostEditExam']);
    Route::get('admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);

    // lich
    // admin/examinations/exam_schedule/list
    Route::get('admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('admin/examinaions/schedule/add', [ExaminationsController::class, 'PostAddExamSchedule']);
});

Route::group(['middware' => 'teacher'], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('teacher/change_password', [UserController::class, 'changePassword']);
    Route::post('teacher/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('teacher/account', [UserController::class, 'myAccount']);

    Route::post('teacher/account', [UserController::class, 'UpdateMyAccount']);


    Route::get('teacher/my_class_subject', [AssignClassTeacherController::class, 'myClassSubject']);
    Route::get('teacher/my_student', [StudentController::class, 'teacherStudent']);
    Route::get('teacher/my_class_subject/timeable/{subject_id}/{class_id}', [ClassTimeableController::class, 'teacherClassSubjectTimeable']);

    Route::get('teacher/my_timeable', [ClassTimeableController::class, 'teacherTimeable']);

    Route::get('teacher/my_exam_schedule', [ExaminationsController::class, 'teacher_exam_schedule']);
    Route::get('teacher/calendar', [CalendarController::class, 'teacher_calendar']);
});

Route::group(['middware' => 'student'], function () {
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('student/change_password', [UserController::class, 'changePassword']);
    Route::post('student/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('student/account', [UserController::class, 'myAccount']);

    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('student/my_subject', [SubjectController::class, 'myStudentSubject']);
    Route::get('student/my_timeable', [ClassTimeableController::class, 'studentTimeable']);

    Route::get('student/my_exam_schedule', [ExaminationsController::class, 'student_exam_schedule']);
    Route::get('student/my_calendar', [CalendarController::class, 'student_my_calendar']);
});

Route::group(['middware' => 'parent'], function () {
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('parent/change_password', [UserController::class, 'changePassword']);
    Route::post('parent/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('parent/account', [UserController::class, 'myAccount']);

    Route::post('parent/account', [UserController::class, 'UpdateMyAccountParent']);
    Route::get('parent/my_student/subject/{student_id}', [SubjectController::class, 'parentStudentSubject']);
    Route::get('parent/my_student', [ParentController::class, 'myStudentParent']);
    Route::get('parent/my_student/class_subject_timeable/{subject_id}/{class_id}/{student_id}', [ClassTimeableController::class, 'parentClassSubjectTimeable']);
    Route::get('parent/my_student/exam_schedule/{student_id}', [ExaminationsController::class, 'parentStudentExamSchedule']);
    Route::get('parent/my_student/calendar/{student_id}', [CalendarController::class, 'parent_student_calendar']);
});
