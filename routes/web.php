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
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassTimeableController;
use App\Http\Controllers\ClassTransferController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\FeeCollectitonController;
use App\Http\Controllers\HomeworkController;
use App\Models\MarksGradeModel;
use Illuminate\Http\Request;
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
Route::get('student/paypal/payment_cancel', [FeeCollectitonController::class, 'paymenft_cancel']);
Route::post('admin/class_timeable/get_subject', [ClassTimeableController::class, 'getSubject']);
Route::get('student/paypal/payment_success', [FeeCollectitonController::class, 'payment_success']);
Route::get('student/payTransferFee', [ClassTransferController::class, 'payment_success']);


Route::middleware(['common'])->group(function () {
    Route::get('download/student_template', [StudentController::class, 'downloadTemplateImport']);
    Route::get('chat', [ChatController::class, 'chat']);
    Route::post('get_chat_windows', [ChatController::class, 'get_chat_windows']);
    Route::post('submit_message', [ChatController::class, 'submit_message']);
    Route::post('get_chat_search_user', [ChatController::class, 'get_chat_search_user']);
    Route::post('admin/attendance/student', [AttendanceController::class, 'PostAttendaceStudent']);
    Route::post('student/transfer/cancel/{request_id}', [ClassTransferController::class, 'cancelRequest']);
});

Route::post('admin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

Route::get('/validate-percent', function (Request $request) {
    $percent = $request->input('percent');
    $isValid = MarksGradeModel::validatePercent($percent);

    return $isValid ? 'true' : 'false';
});

Route::middleware(['admin'])->group(function () {
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
    Route::post('admin/student/import', [StudentController::class, 'import']);
    Route::post('admin/student/export', [StudentController::class, 'export']);

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
    // Route::post('admin/exam/get_class', [ExamModel::class, 'exam_get_class']);

    Route::post('admin/class_timeable/add', [ClassTimeableController::class, 'PostAdd']);

    // exam
    Route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);

    Route::post('admin/examinations/exam/add', [ExaminationsController::class, 'PostExaxmAdd']);

    Route::get('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);

    Route::post('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'PostEditExam']);
    Route::get('admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);

    // mark_grade
    // exam
    Route::get('admin/examinations/marks_grade', [ExaminationsController::class, 'marks_grade_list']);
    Route::get('admin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_add']);

    Route::post('admin/examinations/marks_grade/add', [ExaminationsController::class, 'PostMarkAdd']);

    Route::get('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_edit']);

    Route::post('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'PostMarksGradEdit']);
    Route::get('admin/examinations/marks_grade/delete/{id}', [ExaminationsController::class, 'marks_grade_delete']);

    // lich
    // admin/examinations/exam_schedule/list
    Route::get('admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('admin/examinaions/schedule/add', [ExaminationsController::class, 'PostAddExamSchedule']);

    Route::get('admin/examinations/marks_register', [ExaminationsController::class, 'marks_register']);
    Route::post('admin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);



    Route::get('admin/attendance/student', [AttendanceController::class, 'attendance_student']);
    Route::get('admin/attendance/report', [AttendanceController::class, 'attendance_report']);

    Route::get('admin/comunicate/send_email', [CommunicateController::class, 'send_email']);
    Route::post('admin/comunicate/send_email', [CommunicateController::class, 'PostSendEmail']);
    Route::get('admin/communicate/search_user', [CommunicateController::class, 'search_user']);
    Route::get('admin/homework/homework', [HomeworkController::class, 'list']);
    Route::get('admin/homework/homework/add', [HomeworkController::class, 'add']);
    Route::post('admin/homework/homework/add', [HomeworkController::class, 'PostAdd']);

    Route::get('admin/homework/homework/edit/{id}', [HomeworkController::class, 'edit']);

    Route::post('admin/homework/homework/edit/{id}', [HomeworkController::class, 'PostEdit']);
    Route::get('admin/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);
    Route::get('admin/homework/submitted/{id}', [HomeworkController::class, 'submitted']);
    Route::get('admin/homework/view_submit/{id}', [HomeworkController::class, 'view_submitted']);
    Route::get('admin/homework/report', [HomeworkController::class, 'homework_report']);
    Route::get('admin/fee/fee_collect', [FeeCollectitonController::class, 'collect_fees']);
    Route::get('admin/fee/add_fees/{id}', [FeeCollectitonController::class, 'add_fees']);
    Route::post('admin/fee/add_fees/{id}', [FeeCollectitonController::class, 'PostAddFee']);
    Route::get('admin/settings', [UserController::class, 'settings']);
    Route::post('admin/settings', [UserController::class, 'PostSetting']);
    Route::get('admin/fee/fee_collect_report', [FeeCollectitonController::class, 'fee_collect_report']);

    Route::post('admin/fee/fee_collection_report_export', [FeeCollectitonController::class, 'ExportFeeCollectionReport']);
    Route::post('admin/fee/fee_collection_export', [FeeCollectitonController::class, 'ExportFeeCollection']);
    Route::get('admin/fee/add_fees/delete/{id}', [FeeCollectitonController::class, 'delete_fee_collect']);
    Route::get('admin/class/addStudent/{id}', [EnrollmentController::class, 'listEnrollments']);
    Route::get('admin/enrollments/addStudent/{student_id}/{class_id}', [EnrollmentController::class, 'addStudentEnroll']);
    Route::get('admin/enrollments/removeStudent/{student_id}/{class_id}', [EnrollmentController::class, 'removeStudent']);
    Route::get('admin/class_transfers/admin_list', [ClassTransferController::class, 'admin_list']);
    Route::get('admin/class_transfers/accept/{request_id}', [ClassTransferController::class, 'acceptRequest']);
    Route::post('admin/class_transfers/accept/{request_id}', [ClassTransferController::class, 'PostAcceptRequest']);
});

Route::middleware(['teacher'])->group(function () {
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

    Route::get('teacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']);
    Route::post('admin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
    // Route::post('admin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

    Route::get('teacher/attendance/student', [AttendanceController::class, 'teacher_attendance_student']);
    Route::post('teacher/attendance/student', [AttendanceController::class, 'PostAttendaceStudent']);
    Route::get('teacher/attendance/report', [AttendanceController::class, 'teacher_attendance_report']);


    Route::get('teacher/homework/homework', [HomeworkController::class, 'list_teacher']);
    Route::get('teacher/homework/homework/add', [HomeworkController::class, 'add_teacher']);
    Route::post('teacher/homework/homework/add', [HomeworkController::class, 'PostAdd']);

    Route::get('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'edit_teacher']);

    Route::post('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'PostEdit']);
    Route::get('teacher/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);

    Route::post('teacher/class_timeable/get_teacher_subject_class', [ClassTimeableController::class, 'getTeacherClassSubject']);
});

Route::middleware(['student'])->group(function () {

    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('student/change_password', [UserController::class, 'changePassword']);
    Route::post('student/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('student/account', [UserController::class, 'myAccount']);

    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('student/my_subject', [SubjectController::class, 'myStudentSubject']);
    Route::get('student/my_timeable', [ClassTimeableController::class, 'studentTimeable']);

    Route::get('student/my_exam_schedule', [ExaminationsController::class, 'student_exam_schedule']);
    Route::get('student/my_calendar', [CalendarController::class, 'student_my_calendar']);
    Route::get('student/my_exam_result', [ExaminationsController::class, 'my_exam_result']);
    Route::get('student/my_exam_result_print/{id}', [ExaminationsController::class, 'my_exam_result_print']);
    Route::get('student/my_attendance_report', [AttendanceController::class, 'attendance_report']);
    Route::get('student/my_homework', [HomeworkController::class, 'student_my_homework']);
    Route::get('student/homework/submit/{id}', [HomeworkController::class, 'student_submit_homework']);
    Route::get('student/homework/submitted', [HomeworkController::class, 'student_my_submited_homework']);
    Route::post('student/homework/submit/{id}', [HomeworkController::class, 'PostSubmitHomework']);
    Route::get('student/homework_submit/edit/{id}', [HomeworkController::class, 'edit_homework_submitted']);
    Route::post('student/homework_submit/edit/{id}', [HomeworkController::class, 'PostEditSubmitHomework']);
    Route::get('student/fee_collect', [FeeCollectitonController::class, 'student_fee_collection']);
    Route::post('student/fee_collect', [FeeCollectitonController::class, 'PostAddFeeStudent']);
    Route::get('student/move', [ClassTransferController::class, 'student_list']);
    Route::get('student/move/add', [ClassTransferController::class, 'addTransfer']);
    Route::get('student/transfer/remove/{request_id}', [ClassTransferController::class, 'removeRequest']);
    Route::get('student/transfer/payFee/{request_id}', [ClassTransferController::class, 'payFee']);


    Route::post('student/move/add', [ClassTransferController::class, 'PostAddTransfer']);
});

Route::middleware(['parent'])->group(function () {
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
    Route::get('parent/my_student/exam_result/{student_id}', [ExaminationsController::class, 'parent_student_exam_result']);
    Route::get('parent/my_attendance_report', [AttendanceController::class, 'attendance_report']);
});
