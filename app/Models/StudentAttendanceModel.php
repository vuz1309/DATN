<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;
    protected $table = 'student_attendance';

    public static function getByForeign($student_id, $class_id, $subject_id, $attendance_date)
    {
        return self::where('student_id', '=', $student_id)
            ->where('class_id', '=', $class_id)
            ->where('subject_id', '=', $subject_id)
            ->where('attendance_date', '=', $attendance_date)->first();
    }

    public static function getRecord()
    {
        $return =  self::select('student_attendance.*', 'class.name as class_name', 'subject.name as subject_name', 'student.name as student_name', 'student.last_name as student_last_name', 'users.name as created_by_name', 'users.last_name as created_by_last_name')
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('users', 'users.id', '=', 'student_attendance.created_by', 'left');

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('subject.id', '=', Request::get('subject_id'));
        }
        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('attendance_date.attendance_type', '=', Request::get('attendance_type'));
        }
        if (!empty(Request::get('attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '=', Request::get('attendance_date'));
        }
        if (!empty(Request::get('student_name'))) {
            $student_name = Request::get('student_name');
            $return = $return->where(function ($query) use ($student_name) {
                $query->where('student.name', 'LIKE', '%' . $student_name . '%')
                    ->orWhere('student.last_name', 'LIKE', '%' . $student_name . '%');
            });
        }

        $return = $return->orderBy('student_attendance.id', 'desc')->paginate(50);

        return $return;
    }
}
