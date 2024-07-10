<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimeableModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\User;
use App\Models\WeekModel;
use Illuminate\Http\Request;
use Auth;

class CalendarController extends Controller
{
    public function student_my_calendar()
    {
        // $class_id = Auth::user()->class_id;

        $data['getMyTimeable'] = $this->getTimeable(Auth::user()->id);
        $data['getExamTimeable'] = $this->getExamTimeable(Auth::user()->id);

        $data['header_title'] = 'Lịch học';
        return view('student.my_calendar', $data);
    }

    public function parent_student_calendar($student_id)
    {
        $student = User::getSingle($student_id);
        if (!empty($student)) {
            $class_id = $student->class_id;
            if (!empty($class_id)) {
                $data['getMyTimeable'] = $this->getTimeable($class_id);
                $data['getExamTimeable'] = $this->getExamTimeable($class_id);

                $data['header_title'] = 'Lịch học';
                $data['getStudent'] = $student;
                return view('parent.my_student.calendar', $data);
            }
        }
    }

    public function teacher_calendar()
    {
        $teacher_id = Auth::user()->id;

        $getClassTimeable = AssignClassTeacherModel::getCalendarTeacher($teacher_id);
        $getExamTimeable = ExamScheduleModel::getCalendarTeacher($teacher_id);


        $data['header_title'] = 'Lịch học';
        $data['getClassTimeable'] = $getClassTimeable;
        $data['getExamTimeable'] = $getExamTimeable;
        return view('teacher.my_calendar', $data);
    }

    private function getExamTimeable($class_id)
    {

        $getExam  = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $E = array();
            $E['name'] = $value->exam_name;
            $getExamSchedule = ExamScheduleModel::getExamSchedule($value->exam_id, $class_id);
            $resultS = [];
            foreach ($getExamSchedule as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_mark'] = $valueS->passing_mark;

                $resultS[] = $dataS;
            }
            $E['exam'] = $resultS;

            $result[] = $E;
        }
        return $result;
    }

    private function getTimeable($student_id)
    {
        $mySubject = ClassSubjectModel::studentSubject($student_id);
        $result = array();
        foreach ($mySubject as $subject) {
            $dataS['name'] = $subject->subject_name;
            $getWeek = WeekModel::getRecord();
            $week = array();
            foreach ($getWeek as $value) {
                $dataW = array();

                $dataW['week_id'] = $value->id;
                $dataW['week_name'] = $value->name;
                $dataW['fullcalendar_day'] = $value->fullcalendar_day;

                $class_subject_timeable = ClassSubjectTimeableModel::getClassSujectTimable($subject->class_id, $subject->subject_id, $value->id);

                if (!empty($class_subject_timeable)) {
                    $dataW['start_time'] = $class_subject_timeable->start_time;
                    $dataW['end_time'] = $class_subject_timeable->end_time;
                    $dataW['start_date'] = date('m-d-Y', strtotime($class_subject_timeable->class_start_date));
                    $dataW['end_date'] = date('m-d-Y', strtotime($class_subject_timeable->class_end_date));
                    $dataW['room_number'] = $class_subject_timeable->room_number;
                    $week[] = $dataW;
                }
            }

            $dataS['week'] = $week;
            $result[] = $dataS;
        }
        // dd($result);
        return $result;
    }
}
