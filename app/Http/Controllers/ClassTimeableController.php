<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\WeekModel;
use App\Models\ClassSubjectTimeableModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassTimeableController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = 'Thời khóa biểu';
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->class_id))
            $data['getSubject'] = ClassSubjectModel::mySubject($request->class_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $value) {
            $dataW = [];
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if (!empty($request->class_id) && !empty($request->subject_id)) {
                $class_subject_timeable = ClassSubjectTimeableModel::getClassSujectTimable($request->class_id, $request->subject_id, $value->id);
                if (!empty($class_subject_timeable)) {
                    $dataW['start_time'] = $class_subject_timeable->start_time;
                    $dataW['end_time'] = $class_subject_timeable->end_time;
                    $dataW['room_number'] = $class_subject_timeable->room_number;
                } else {
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
            }

            $week[] = $dataW;
        }
        $data['week'] = $week;
        return view("admin.class_timeable.list", $data);
    }

    public function getSubject(Request $request)
    {
        $getSubject = ClassSubjectModel::mySubject($request->class_id);
        if ($getSubject->count() < 1) {
            $html = "<option value = ''>Không có Khóa học</option>";
        } else {
            $html = "<option value = ''>Chọn Khóa học</option>";
            foreach ($getSubject as $subject) {
                $html .= "<option value = '" . $subject->subject_id . "'>" . $subject->subject_name . "</option>";
            }
        }


        $json['html'] = $html;
        echo json_encode($json);
    }

    public function getTeacherClassSubject(Request $request)
    {
        $getSubject = ClassSubjectModel::teacherClassSubject($request->class_id, Auth::user()->id);
        if ($getSubject->count() < 1) {
            $html = "<option value = ''>Không có Khóa học</option>";
        } else {
            $html = "<option value = ''>Chọn Khóa học</option>";
            foreach ($getSubject as $subject) {
                $html .= "<option value = '" . $subject->subject_id . "'>" . $subject->subject_name . "</option>";
            }
        }


        $json['html'] = $html;
        echo json_encode($json);
    }

    public function PostAdd(Request $request)
    {

        ClassSubjectTimeableModel::where('class_id', '=', $request->class_id)->where('subject_id', '=', $request->subject_id)->delete();
        foreach ($request->timeable as $timeable) {


            if (!empty($timeable['week_id']) && !empty($timeable['start_time']) && !empty($timeable['end_time']) && !empty($timeable['room_number'])) {
                $save = new ClassSubjectTimeableModel;
                $save->class_id = $request->class_id;
                $save->subject_id = $request->subject_id;
                $save->start_time = $timeable['start_time'];
                $save->end_time = $timeable['end_time'];
                $save->room_number = $timeable['room_number'];
                $save->week_id = $timeable['week_id'];
                $save->save();
            }
        }
        return redirect()->back()->with('success', 'Tạo thời khóa biểu thành công!');
    }


    public function studentTimeable()
    {
        $getWeek = WeekModel::getRecord();
        $data['header_title'] = 'Thời khóa biểu';
        $data['getWeek'] = $getWeek;
        $data['getSubject'] = SubjectModel::getStudentSubject(Auth::user()->id);
        if (!empty($data['getSubject'])) {
            $subjectTimeable = [];

            foreach ($data['getSubject'] as $subject) {
                $subjectWeekTimeable = array();
                foreach ($getWeek as $week) {

                    $studentSubjectTimeable = ClassSubjectTimeableModel::getStudentSubjectTimeable($subject->class_id, $subject->id, $week->id);
                    $dataW = [];
                    $dataW['week_id'] = $week->id;
                    $dataW['week_name'] = $week->name;
                    if (!empty($studentSubjectTimeable)) {
                        $dataW['start_time'] = $studentSubjectTimeable->start_time;
                        $dataW['end_time'] = $studentSubjectTimeable->end_time;
                        $dataW['room_number'] = $studentSubjectTimeable->room_number;
                    } else {
                        $dataW['start_time'] = null;
                        $dataW['end_time'] = null;
                        $dataW['room_number'] = null;
                    }

                    $subjectWeekTimeable[] = $dataW;
                }
                $subjectTimeable[$subject->id] = $subjectWeekTimeable;
            }
        }
        $data['getSubjectTimeable'] = $subjectTimeable;

        return view('student.my_timeable', $data);
    }

    public function teacherClassSubjectTimeable($subject_id, $class_id)
    {
        $data['header_title'] = 'Thời khóa biểu';
        $data['getClass'] = ClassModel::single($class_id);
        if (!empty($subject_id))
            $data['getSubject'] = SubjectModel::single($subject_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $value) {
            $dataW = [];
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if (!empty($class_id) && !empty($subject_id)) {
                $class_subject_timeable = ClassSubjectTimeableModel::getClassSujectTimable($class_id, $subject_id, $value->id);
                if (!empty($class_subject_timeable)) {
                    $dataW['start_time'] = $class_subject_timeable->start_time;
                    $dataW['end_time'] = $class_subject_timeable->end_time;
                    $dataW['room_number'] = $class_subject_timeable->room_number;
                } else {
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
            }

            $week[] = $dataW;
        }
        $data['week'] = $week;

        return view('teacher.my_class_subject.subject_timeable', $data);
    }

    public function parentClassSubjectTimeable($subject_id, $class_id, $student_id)
    {
        $data['header_title'] = 'Thời khóa biểu Khóa học';
        $data['getSubject'] = SubjectModel::single($subject_id);
        $data['getClass'] = ClassModel::single($class_id);
        $data['getStudent'] = User::getSingle($student_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $value) {
            $dataW = [];
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if (!empty($class_id) && !empty($subject_id)) {
                $class_subject_timeable = ClassSubjectTimeableModel::getClassSujectTimable($class_id, $subject_id, $value->id);
                if (!empty($class_subject_timeable)) {
                    $dataW['start_time'] = $class_subject_timeable->start_time;
                    $dataW['end_time'] = $class_subject_timeable->end_time;
                    $dataW['room_number'] = $class_subject_timeable->room_number;
                } else {
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }
            }

            $week[] = $dataW;
        }
        $data['week'] = $week;
        return view('parent.my_student.class_subject_timeable', $data);
    }
}
