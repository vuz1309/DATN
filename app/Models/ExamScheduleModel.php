<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleModel extends Model
{
    use HasFactory;
    protected $table = 'exam_schedule';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecordSingle($exam_id, $class_id, $subject_id)
    {
        return self::where('exam_id', '=', $exam_id)
            ->where('class_id', '=', $class_id)
            ->where('subject_id', '=', $subject_id)
            ->first();
    }

    static public function deleteRecord($exam_id, $class_id, $subject_id)
    {
        self::where([
            ['exam_id', '=', $exam_id],
            ['class_id', '=', $class_id],
            ['subject_id', '=', $subject_id],
        ])->delete();
    }

    static public function getExam($student_id)
    {
        $return =  self::select('exam_schedule.*', 'exam.name as exam_name')
            ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
            ->join('enrollments', 'enrollments.class_id', '=', 'exam_schedule.class_id')
            ->where('enrollments.student_id', '=', $student_id)
            ->groupBy('exam_schedule.exam_id')
            ->orderBy('exam_schedule.exam_id', 'desc')
            ->get();

        return $return;
    }

    static public function getExamTeacher($teacher_id)
    {
        $return =  self::select('exam.*')
            ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
            ->leftJoin('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
            ->leftJoin('class_subject', 'class_subject.class_id', '=', 'exam_schedule.class_id')
            ->where(function ($q) use ($teacher_id) {
                $q->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                    ->orWhere('class_subject.teacher_id', '=', $teacher_id);
            })
            ->groupBy('exam_schedule.exam_id')
            ->orderBy('exam_schedule.exam_id', 'desc')
            ->get();

        return $return;
    }


    static public function getExamSchedule($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_schedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
            ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
            ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
            ->where('exam_schedule.exam_id', '=', $exam_id)
            ->where('exam_schedule.class_id', '=', $class_id)
            ->get();
    }

    static public function getCalendarTeacher($teacher_id)
    {
        return self::select('exam_schedule.*', 'class.name as class_name', 'subject.name as subject_name', 'exam.name as exam_name')
            ->leftJoin('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
            ->leftJoin('class_subject', 'class_subject.class_id', '=', 'exam_schedule.class_id')
            ->where(function ($q) use ($teacher_id) {
                $q->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                    ->orWhere('class_subject.teacher_id', '=', $teacher_id);
            })
            ->join('class', 'class.id', '=', 'exam_schedule.class_id')
            ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
            ->join('exam', 'exam.id', '=', 'exam_schedule.exam_id')
            ->get();
    }

    static public function getSubject($exam_id, $class_id)
    {
        return ExamScheduleModel::select('exam_schedule.*', 'subject.name as subject_name', 'subject.type as subject_type')
            ->join('subject', 'subject.id', '=', 'exam_schedule.subject_id')
            ->where('exam_schedule.exam_id', '=', $exam_id)
            ->where('exam_schedule.class_id', '=', $class_id)
            ->get();
    }

    static public function getmark($student_id, $exam_id,  $class_id, $subject_id)
    {
        return MarkRegisterModel::getSingleByWork($student_id, $exam_id,  $class_id, $subject_id);
    }
}
