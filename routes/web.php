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
use App\Http\Controllers\SuspensionController;
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
Route::get('vStudent/paypal/payment_cancel', [FeeCollectitonController::class, 'paymenft_cancel']);
Route::post('vAdmin/class_timeable/get_subject', [ClassTimeableController::class, 'getSubject']);
Route::get('vStudent/paypal/payment_success', [FeeCollectitonController::class, 'payment_success']);
Route::get('vStudent/payTransferFee', [ClassTransferController::class, 'payment_success']);


Route::middleware(['common'])->group(function () {
    Route::get('download/student_template', [StudentController::class, 'downloadTemplateImport']);
    Route::get('chat', [ChatController::class, 'chat']);
    Route::post('get_chat_windows', [ChatController::class, 'get_chat_windows']);
    Route::post('submit_message', [ChatController::class, 'submit_message']);
    Route::post('get_chat_search_user', [ChatController::class, 'get_chat_search_user']);
    Route::post('vAdmin/attendance/student', [AttendanceController::class, 'PostAttendaceStudent']);
    Route::post('vStudent/transfer/cancel/{request_id}', [ClassTransferController::class, 'cancelRequest']);
    Route::post('vAdmin/suspension/cancel/{request_id}', [SuspensionController::class, 'cancelRequest']);
    Route::get('vAdmin/homework/submitted/{id}', [HomeworkController::class, 'submitted']);
});

Route::post('vAdmin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

Route::get('/validate-percent', function (Request $request) {
    $percent = $request->input('percent');
    $isValid = MarksGradeModel::validatePercent($percent);

    return $isValid ? 'true' : 'false';
});

Route::middleware(['admin'])->group(function () {
    Route::get('vAdmin/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('vAdmin/vAdmin/list', [AdminController::class, 'list']);
    Route::get('vAdmin/vAdmin/add', [AdminController::class, 'add']);
    Route::post('vAdmin/vAdmin/add', [AdminController::class, 'PostAdd']);
    Route::get('vAdmin/vAdmin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('vAdmin/vAdmin/edit/{id}', [AdminController::class, 'PostEdit']);
    Route::get('vAdmin/vAdmin/delete/{id}', [AdminController::class, 'delete']);

    // class
    Route::get('vAdmin/class/list', [ClassController::class, 'list']);
    Route::get('vAdmin/class/add', [ClassController::class, 'add']);

    Route::post('vAdmin/class/add', [ClassController::class, 'PostAdd']);

    Route::get('vAdmin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('vAdmin/class/edit/{id}', [ClassController::class, 'PostEdit']);
    Route::get('vAdmin/class/delete/{id}', [ClassController::class, 'delete']);

    // subject
    Route::get('vAdmin/subject/list', [SubjectController::class, 'list']);
    Route::get('vAdmin/subject/add', [SubjectController::class, 'add']);

    Route::post('vAdmin/subject/add', [SubjectController::class, 'PostAdd']);

    Route::get('vAdmin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('vAdmin/subject/edit/{id}', [SubjectController::class, 'PostEdit']);
    Route::get('vAdmin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // assign_subject
    Route::get('vAdmin/assign_subject/list', [ClassSubjectController::class, 'list']);
    Route::get('vAdmin/assign_subject/add', [ClassSubjectController::class, 'add']);

    Route::post('vAdmin/assign_subject/add', [ClassSubjectController::class, 'PostAdd']);

    Route::get('vAdmin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
    Route::get('vAdmin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'editSingle']);
    Route::post('vAdmin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'PostEditSingle']);
    Route::post('vAdmin/assign_subject/edit/{id}', [ClassSubjectController::class, 'PostEdit']);
    Route::get('vAdmin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete']);

    Route::get('vAdmin/change_password', [UserController::class, 'changePassword']);
    Route::post('vAdmin/change_password', [UserController::class, 'PostChangePassword']);

    // teacher
    Route::get('vAdmin/vTeacher/list', [TeacherController::class, 'list']);
    Route::get('vAdmin/vTeacher/add', [TeacherController::class, 'add']);

    Route::post('vAdmin/vTeacher/add', [TeacherController::class, 'PostAdd']);

    Route::get('vAdmin/vTeacher/edit/{id}', [TeacherController::class, 'edit']);
    Route::post('vAdmin/vTeacher/edit/{id}', [TeacherController::class, 'PostEdit']);
    Route::get('vAdmin/vTeacher/delete/{id}', [TeacherController::class, 'delete']);


    // student
    Route::get('vAdmin/vStudent/list', [StudentController::class, 'list']);
    Route::get('vAdmin/vStudent/add', [StudentController::class, 'add']);

    Route::post('vAdmin/vStudent/add', [StudentController::class, 'PostAdd']);

    Route::get('vAdmin/vStudent/edit/{id}', [StudentController::class, 'edit']);
    Route::post('vAdmin/vStudent/edit/{id}', [StudentController::class, 'PostEdit']);
    Route::get('vAdmin/vStudent/delete/{id}', [StudentController::class, 'delete']);
    Route::post('vAdmin/vStudent/import', [StudentController::class, 'import']);
    Route::post('vAdmin/vStudent/export', [StudentController::class, 'export']);

    // parent
    Route::get('vAdmin/vParent/list', [ParentController::class, 'list']);
    Route::get('vAdmin/vParent/add', [ParentController::class, 'add']);

    Route::post('vAdmin/vParent/add', [ParentController::class, 'PostAdd']);

    Route::get('vAdmin/vParent/edit/{id}', [ParentController::class, 'edit']);
    Route::post('vAdmin/vParent/edit/{id}', [ParentController::class, 'PostEdit']);
    Route::get('vAdmin/vParent/delete/{id}', [ParentController::class, 'delete']);
    Route::get('vAdmin/vParent/my-vStudent/{id}', [ParentController::class, 'myStudent']);
    Route::get('vAdmin/vParent/assign_student_vParent/{student_id}/{parent_id}', [ParentController::class, 'assignStudentParent']);
    Route::get('vAdmin/vParent/assign_student_parent_delete/{student_id}', [ParentController::class, 'deleteAssignStudentParent']);


    // account
    Route::get('vAdmin/account', [UserController::class, 'myAccount']);

    Route::post('vAdmin/account', [UserController::class, 'PostUpdateMyAccountAdmin']);


    // assign teacher class
    Route::get('vAdmin/assign_class_vTeacher/list', [AssignClassTeacherController::class, 'list']);
    Route::get('vAdmin/assign_class_vTeacher/add', [AssignClassTeacherController::class, 'add']);

    Route::post('vAdmin/assign_class_vTeacher/add', [AssignClassTeacherController::class, 'PostAdd']);

    Route::get('vAdmin/assign_class_vTeacher/edit/{id}', [AssignClassTeacherController::class, 'edit']);
    Route::post('vAdmin/assign_class_vTeacher/edit/{id}', [AssignClassTeacherController::class, 'PostEdit']);
    Route::get('vAdmin/assign_class_vTeacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);

    Route::get('vAdmin/assign_class_vTeacher/edit_single/{id}', [AssignClassTeacherController::class, 'editSingle']);
    Route::post('vAdmin/assign_class_vTeacher/edit_single/{id}', [AssignClassTeacherController::class, 'PostEditSingle']);

    Route::get('vAdmin/class_timeable/list', [ClassTimeableController::class, 'list']);
    Route::get('vAdmin/class_timeable/add', [ClassTimeableController::class, 'add']);
    // Route::post('vAdmin/exam/get_class', [ExamModel::class, 'exam_get_class']);

    Route::post('vAdmin/class_timeable/add', [ClassTimeableController::class, 'PostAdd']);

    // exam
    Route::get('vAdmin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('vAdmin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);

    Route::post('vAdmin/examinations/exam/add', [ExaminationsController::class, 'PostExaxmAdd']);

    Route::get('vAdmin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);

    Route::post('vAdmin/examinations/exam/edit/{id}', [ExaminationsController::class, 'PostEditExam']);
    Route::get('vAdmin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);

    // mark_grade
    // exam
    Route::get('vAdmin/examinations/marks_grade', [ExaminationsController::class, 'marks_grade_list']);
    Route::get('vAdmin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_add']);

    Route::post('vAdmin/examinations/marks_grade/add', [ExaminationsController::class, 'PostMarkAdd']);

    Route::get('vAdmin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_edit']);

    Route::post('vAdmin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'PostMarksGradEdit']);
    Route::get('vAdmin/examinations/marks_grade/delete/{id}', [ExaminationsController::class, 'marks_grade_delete']);

    // lich
    // vAdmin/examinations/exam_schedule/list
    Route::get('vAdmin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('vAdmin/examinaions/schedule/add', [ExaminationsController::class, 'PostAddExamSchedule']);

    Route::get('vAdmin/examinations/marks_register', [ExaminationsController::class, 'marks_register']);
    Route::post('vAdmin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);



    Route::get('vAdmin/attendance/student', [AttendanceController::class, 'attendance_student']);
    Route::get('vAdmin/attendance/report', [AttendanceController::class, 'attendance_report']);

    Route::get('vAdmin/comunicate/send_email', [CommunicateController::class, 'send_email']);
    Route::post('vAdmin/comunicate/send_email', [CommunicateController::class, 'PostSendEmail']);
    Route::get('vAdmin/communicate/search_user', [CommunicateController::class, 'search_user']);
    Route::get('vAdmin/homework/homework', [HomeworkController::class, 'list']);
    Route::get('vAdmin/homework/homework/add', [HomeworkController::class, 'add']);
    Route::post('vAdmin/homework/homework/add', [HomeworkController::class, 'PostAdd']);

    Route::get('vAdmin/homework/homework/edit/{id}', [HomeworkController::class, 'edit']);

    Route::post('vAdmin/homework/homework/edit/{id}', [HomeworkController::class, 'PostEdit']);
    Route::get('vAdmin/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);
    Route::get('vAdmin/homework/view_submit/{id}', [HomeworkController::class, 'view_submitted']);
    Route::get('vAdmin/homework/report', [HomeworkController::class, 'homework_report']);
    Route::get('vAdmin/fee/fee_collect', [FeeCollectitonController::class, 'collect_fees']);
    Route::get('vAdmin/fee/add_fees/{id}', [FeeCollectitonController::class, 'add_fees']);
    Route::post('vAdmin/fee/add_fees/{id}', [FeeCollectitonController::class, 'PostAddFee']);
    Route::get('vAdmin/settings', [UserController::class, 'settings']);
    Route::post('vAdmin/settings', [UserController::class, 'PostSetting']);
    Route::get('vAdmin/fee/fee_collect_report', [FeeCollectitonController::class, 'fee_collect_report']);

    Route::post('vAdmin/fee/fee_collection_report_export', [FeeCollectitonController::class, 'ExportFeeCollectionReport']);
    Route::post('vAdmin/fee/fee_collection_export', [FeeCollectitonController::class, 'ExportFeeCollection']);
    Route::get('vAdmin/fee/add_fees/delete/{id}', [FeeCollectitonController::class, 'delete_fee_collect']);
    Route::get('vAdmin/class/addvStudent/{id}', [EnrollmentController::class, 'listEnrollments']);
    Route::get('vAdmin/enrollments/addvStudent/{student_id}/{class_id}', [EnrollmentController::class, 'addStudentEnroll']);
    Route::get('vAdmin/enrollments/removevStudent/{student_id}/{class_id}', [EnrollmentController::class, 'removeStudent']);
    Route::get('vAdmin/class_transfers/admin_list', [ClassTransferController::class, 'admin_list']);
    Route::get('vAdmin/class_transfers/accept/{request_id}', [ClassTransferController::class, 'acceptRequest']);
    Route::post('vAdmin/class_transfers/accept/{request_id}', [ClassTransferController::class, 'PostAcceptRequest']);

    //suspension
    Route::get('/vAdmin/suspension/list', [SuspensionController::class, 'list']);
    Route::get('vAdmin/suspension/accept/{request_id}', [SuspensionController::class, 'acceptRequest']);
    Route::post('vAdmin/suspension/accept/{request_id}', [SuspensionController::class, 'PostAcceptRequest']);
    Route::get('vAdmin/suspension/comeback/{request_id}', [SuspensionController::class, 'comeback']);
    Route::post('vAdmin/suspension/comeback/{request_id}', [SuspensionController::class, 'PostComeback']);
});

Route::middleware(['teacher'])->group(function () {
    Route::get('vTeacher/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('vTeacher/change_password', [UserController::class, 'changePassword']);
    Route::post('vTeacher/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('vTeacher/account', [UserController::class, 'myAccount']);

    Route::post('vTeacher/account', [UserController::class, 'UpdateMyAccount']);


    Route::get('vTeacher/my_class_subject', [AssignClassTeacherController::class, 'myClassSubject']);
    Route::get('vTeacher/my_student', [StudentController::class, 'teacherStudent']);
    Route::get('vTeacher/my_class_subject/timeable/{subject_id}/{class_id}', [ClassTimeableController::class, 'teacherClassSubjectTimeable']);

    Route::get('vTeacher/my_timeable', [ClassTimeableController::class, 'teacherTimeable']);

    Route::get('vTeacher/my_exam_schedule', [ExaminationsController::class, 'teacher_exam_schedule']);
    Route::get('vTeacher/calendar', [CalendarController::class, 'teacher_calendar']);

    Route::get('vTeacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']);
    Route::post('vAdmin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
    // Route::post('vAdmin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

    Route::get('vTeacher/attendance/student', [AttendanceController::class, 'teacher_attendance_student']);
    Route::post('vTeacher/attendance/student', [AttendanceController::class, 'PostAttendaceStudent']);
    Route::get('vTeacher/attendance/report', [AttendanceController::class, 'teacher_attendance_report']);


    Route::get('vTeacher/homework/homework', [HomeworkController::class, 'list_teacher']);
    Route::get('vTeacher/homework/homework/add', [HomeworkController::class, 'add_teacher']);
    Route::post('vTeacher/homework/homework/add', [HomeworkController::class, 'PostAdd']);

    Route::get('vTeacher/homework/homework/edit/{id}', [HomeworkController::class, 'edit_teacher']);

    Route::post('vTeacher/homework/homework/edit/{id}', [HomeworkController::class, 'PostEdit']);
    Route::get('vTeacher/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);

    Route::post('vTeacher/class_timeable/get_teacher_subject_class', [ClassTimeableController::class, 'getTeacherClassSubject']);
});

Route::middleware(['student'])->group(function () {

    Route::get('vStudent/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('vStudent/change_password', [UserController::class, 'changePassword']);
    Route::post('vStudent/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('vStudent/account', [UserController::class, 'myAccount']);

    Route::post('vStudent/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('vStudent/my_class', [EnrollmentController::class, 'myStudentSubject']);
    Route::get('vStudent/my_timeable', [ClassTimeableController::class, 'studentTimeable']);

    Route::get('vStudent/my_exam_schedule', [ExaminationsController::class, 'student_exam_schedule']);
    Route::get('vStudent/my_calendar', [CalendarController::class, 'student_my_calendar']);
    Route::get('vStudent/my_exam_result', [ExaminationsController::class, 'my_exam_result']);
    Route::get('vStudent/my_exam_result_print/{id}', [ExaminationsController::class, 'my_exam_result_print']);
    Route::get('vStudent/my_attendance_report', [AttendanceController::class, 'attendance_report']);
    Route::get('vStudent/my_homework', [HomeworkController::class, 'student_my_homework']);
    Route::get('vStudent/homework/submit/{id}', [HomeworkController::class, 'student_submit_homework']);
    Route::get('vStudent/homework/submitted', [HomeworkController::class, 'student_my_submited_homework']);
    Route::post('vStudent/homework/submit/{id}', [HomeworkController::class, 'PostSubmitHomework']);
    Route::get('vStudent/homework_submit/edit/{id}', [HomeworkController::class, 'edit_homework_submitted']);
    Route::post('vStudent/homework_submit/edit/{id}', [HomeworkController::class, 'PostEditSubmitHomework']);
    Route::get('vStudent/fee_collect', [FeeCollectitonController::class, 'student_fee_collection']);
    Route::post('vStudent/fee_collect', [FeeCollectitonController::class, 'PostAddFeeStudent']);
    Route::get('vStudent/move', [ClassTransferController::class, 'student_list']);
    Route::get('vStudent/move/add', [ClassTransferController::class, 'addTransfer']);
    Route::get('vStudent/transfer/remove/{request_id}', [ClassTransferController::class, 'removeRequest']);
    Route::get('vStudent/transfer/payFee/{request_id}', [ClassTransferController::class, 'payFee']);
    Route::post('vStudent/move/add', [ClassTransferController::class, 'PostAddTransfer']);
    Route::get('vStudent/suspension/list', [SuspensionController::class, 'student_list']);
    Route::get('vStudent/suspension/add', [SuspensionController::class, 'student_add']);
    Route::post('vStudent/suspension/add', [SuspensionController::class, 'PostStudentAdd']);
    Route::get('vStudent/class_subject/{id}', [SubjectController::class, 'listStudent']);
});

Route::middleware(['parent'])->group(function () {
    Route::get('vParent/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('vParent/change_password', [UserController::class, 'changePassword']);
    Route::post('vParent/change_password', [UserController::class, 'PostChangePassword']);

    Route::get('vParent/account', [UserController::class, 'myAccount']);

    Route::post('vParent/account', [UserController::class, 'UpdateMyAccountParent']);
    Route::get('vParent/my_vStudent/subject/{student_id}', [SubjectController::class, 'parentStudentSubject']);
    Route::get('vParent/my_student', [ParentController::class, 'myStudentParent']);
    Route::get('vParent/my_vStudent/class_subject_timeable/{subject_id}/{class_id}/{student_id}', [ClassTimeableController::class, 'parentClassSubjectTimeable']);
    Route::get('vParent/my_vStudent/exam_schedule/{student_id}', [ExaminationsController::class, 'parentStudentExamSchedule']);
    Route::get('vParent/my_vStudent/calendar/{student_id}', [CalendarController::class, 'parent_student_calendar']);
    Route::get('vParent/my_vStudent/exam_result/{student_id}', [ExaminationsController::class, 'parent_student_exam_result']);
    Route::get('vParent/my_attendance_report', [AttendanceController::class, 'attendance_report']);
});
