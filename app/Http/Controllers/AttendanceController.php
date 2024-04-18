<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\StudentAttendanceModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AttendanceController extends Controller
{
    public function attendance_student(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        if (!empty($request->get('class_id'))) {
            $data['getSubject'] = ClassSubjectModel::mySubject($request->get('class_id'));
        }
        if (!empty($request->get('subject_id'))) {
            $data['getSubjectAttendance'] = SubjectModel::single($request->get('subject_id'));
        }

        $data['header_title'] = 'Điểm danh';
        return view('admin.attendance.student', $data);
    }
    function teacher_attendance_student()
    {
        $teacher_id = Auth::user()->id;
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup($teacher_id);
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        if (!empty($request->get('class_id'))) {
            $data['getSubject'] = ClassSubjectModel::teacherClassSubject($request->get('class_id'), $teacher_id);
        }
        if (!empty($request->get('subject_id'))) {
            $data['getSubjectAttendance'] = SubjectModel::single($request->get('subject_id'));
        }

        $data['header_title'] = 'Điểm danh';
        return view('admin.attendance.student', $data);
    }
    public function PostAttendaceStudent(Request $request)
    {
        $current = StudentAttendanceModel::getByForeign($request->student_id, $request->class_id, $request->subject_id, $request->attendance_date);
        if (empty($current)) {
            $attendance = new StudentAttendanceModel;
            $attendance->student_id = $request->student_id;
            $attendance->class_id = $request->class_id;
            $attendance->subject_id = $request->subject_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->attendance_type = $request->attendance_type;
            $attendance->created_by = Auth::user()->id;
            $attendance->save();
        } else {
            $current->attendance_type = $request->attendance_type;
            $current->save();
        }
        $json['message'] = "Cập nhật thành công!";
        echo json_encode($json);
    }

    public function attendance_report(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->get('class_id')) && !empty($request->get('attendance_date'))) {
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }
        if (!empty($request->get('class_id'))) {
            $data['getSubject'] = ClassSubjectModel::mySubject($request->get('class_id'));
        }
        $data['getRecord'] = StudentAttendanceModel::getRecord();
        $data['header_title'] = 'Điểm danh';
        return view('admin.attendance.report', $data);
    }
}
