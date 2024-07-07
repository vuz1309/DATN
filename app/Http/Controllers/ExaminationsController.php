<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use Illuminate\Http\Request;

use App\Models\ExamModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\MarkRegisterModel;
use App\Models\MarksGradeModel;
use App\Models\User;
use Auth;

class ExaminationsController extends Controller
{
    public function exam_list()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = 'Danh sách bài thi';

        return view('admin.examinations.exam.list', $data);
    }

    public function exam_add()
    {
        $data['header_title'] = 'Thêm mới bài thi';
        $data['getClass'] = ClassModel::getClass();
        return view('admin.examinations.exam.add', $data);
    }

    public function PostExaxmAdd(Request $request)
    {

        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->is_all = $request->allCheckbox === 'on' ? 1 : 0;
        $exam->class_id = trim($request->class_id);
        $exam->subject_id = trim($request->subject_id);
        $exam->created_by = Auth::user()->id;
        $exam->save();
        return redirect('vAdmin/examinations/exam/list')->with('success', 'Tạo bài thi thành công!');
    }
    public function exam_edit($id)
    {
        $exam = ExamModel::getSingle($id);
        if (!empty($exam)) {
            $data['header_title'] = "Sửa bài thi";
            $data['getRecord'] = $exam;
            return view('admin.examinations.exam.edit', $data);
        } else {
            abort(404);
        }
    }
    public function PostEditExam($id, Request $request)
    {
        $exam = ExamModel::find($id);
        if (!empty($exam)) {

            $exam->name = trim($request->name);
            $exam->note = trim($request->note);

            $exam->save();
            return redirect('vAdmin/examinations/exam/list')->with('success', 'Cập nhật bài thi thành công!');
        } else {
            abort(404);
        }
    }
    public function exam_delete($id)
    {
        $exam = ExamModel::getSingle($id);

        if (!empty($exam)) {
            $exam->is_delete = 1;
            $exam->save();
            return redirect('vAdmin/examinations/exam/list')->with('success', 'Xóa bài thi thành công!');
        } else {
            abort(404);
        }
    }

    public function exam_schedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();
        $data['noUseTools'] = true;

        $result = array();
        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $getSubject = ClassSubjectModel::mySubject($request->get('class_id'));
            foreach ($getSubject as $value) {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;
                $dataS['class_id'] = $value->class_id;

                $ExamSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'), $request->get('class_id'),  $value->subject_id);

                if (!empty($ExamSchedule)) {
                    $dataS['exam_date'] = $ExamSchedule->exam_date;
                    $dataS['start_time'] =  $ExamSchedule->start_time;
                    $dataS['end_time'] = $ExamSchedule->end_time;
                    $dataS['full_marks'] = 10;
                    $dataS['passing_mark'] = $ExamSchedule->passing_mark;
                    $dataS['room_number'] = $ExamSchedule->room_number;
                } else {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['full_marks'] = '';
                    $dataS['passing_mark'] = '';
                    $dataS['room_number'] = '';
                }

                $result[] = $dataS;
            }
        }

        $data['getRecord'] = $result;


        $data['header_title'] = 'Lịch thi';
        return view('admin.examinations.exam_schedule', $data);
    }

    public function PostAddExamSchedule(Request $request)
    {


        if (!empty($request->schedule)) {
            foreach ($request->schedule as $schedule) {

                if (
                    !empty($schedule['subject_id'])
                    && !empty($schedule['exam_date'])
                    && !empty($schedule['full_marks'])
                ) {

                    $exam = new ExamScheduleModel;
                    $exam->exam_id = $request->exam_id;
                    $exam->class_id = $request->class_id;
                    ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id, $schedule['subject_id']);
                    $exam->subject_id = $schedule['subject_id'];
                    $exam->exam_date = $schedule['exam_date'];
                    $exam->start_time = $schedule['start_time'];
                    $exam->end_time = $schedule['end_time'];
                    $exam->room_number = $schedule['room_number'];
                    $exam->full_marks = $schedule['full_marks'];
                    $exam->passing_mark = $schedule['passing_mark'];
                    $exam->created_by = Auth::user()->id;
                    $exam->save();
                }
            }
        }

        return redirect()->back()->with('sucess', 'Cập nhật lịch thi thành công!');
    }

    public function student_exam_schedule(Request $request)
    {
        $class_id = Auth::user()->id;

        $getExam  = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $E = array();
            $E['name'] = $value->exam_name;
            $getExamSchedule = ExamScheduleModel::getExamSchedule($value->exam_id, $value->class_id);
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

        $data['header_title'] = 'Lịch thi';
        $data['getRecord'] = $result;

        return view('student.my_exam_schedule', $data);
    }

    public function marks_register(Request $request)
    {
        $data['header_title'] = 'Điểm';
        $data['useSearch'] = true;
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        return view('admin.examinations.marks_register', $data);
    }
    public function marks_register_teacher(Request $request)
    {
        $data['header_title'] = 'Điểm';
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::user()->id);

        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        return view('teacher.marks_register', $data);
    }


    public function submit_marks_register(Request $request)
    {
        $validation = 0;
        if (!empty($request->mark)) {
            foreach ($request->mark as $mark) {
                $getExamSchedule = ExamScheduleModel::getSingle($mark['id']);
                $class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                $home_work =  !empty($mark['home_work']) ? $mark['home_work'] : 0;
                $test_work = !empty($mark['test_work']) ? $mark['test_work'] : 0;
                $exam = !empty($mark['exam']) ? $mark['exam'] : 0;
                $full_marks = $getExamSchedule->full_marks;
                $total_mark = $class_work + $home_work + $test_work + $exam;
                if ($full_marks >= $total_mark) {
                    $getMark = MarkRegisterModel::getSingleByWork($request->student_id, $request->exam_id, $request->class_id, $mark['subject_id']);
                    if (!empty($getMark)) {
                        $save = $getMark;
                    } else {
                        $save = new MarkRegisterModel;
                        $save->created_by = Auth::user()->id;
                    }

                    $save->student_id   = $request->student_id;
                    $save->exam_id      = $request->exam_id;
                    $save->class_id      = $request->class_id;
                    $save->subject_id = $mark['subject_id'];
                    $save->class_work = $class_work;
                    $save->home_work = $home_work;
                    $save->test_work = $test_work;
                    $save->exam = $exam;

                    $save->save();
                } else {
                    $validation = 1;
                }
            }
        }

        $json['message'] = $validation == 0 ? 'Điểm đã được cập nhật thành công!' : 'Lưu thành công, nhưng tồn tại Khóa học có tổng điểm lớn hơn điểm tối đa!';
        echo json_encode($json);
    }

    public function teacher_exam_schedule()
    {
        $id = Auth::user()->id;

        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup($id);

        $result = array();
        foreach ($getClass as $class) {
            $dataC = array();
            $dataC['class_name'] = $class->class_name;

            $getExam  = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();
            foreach ($getExam as $exam) {
                $E = array();
                $E['exam_name'] = $exam->exam_name;
                $getExamSchedule = ExamScheduleModel::getExamSchedule($exam->exam_id, $class->class_id);
                $subjectArray = [];
                foreach ($getExamSchedule as $valueS) {
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_marks'] = $valueS->full_marks;
                    $dataS['passing_mark'] = $valueS->passing_mark;

                    $subjectArray[] = $dataS;
                }
                $E['subject'] = $subjectArray;

                $examArray[] = $E;
            }
            $dataC['exam'] = $examArray;
            $result[] = $dataC;
        }

        $data['header_title'] = 'Lịch thi';

        $data['getRecord'] = $result;

        return view('teacher.my_exam_schedule', $data);
    }

    public function parentStudentExamSchedule($student_id)
    {
        $getStudent = User::getSingle($student_id);

        $class_id = $getStudent->class_id;
        if (!empty($class_id)) {
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
            $data['header_title'] = 'Lịch thi';
            $data['getRecord'] = $result;
            $data['getStudent'] = $getStudent;


            return view('parent.my_student_exam_schedule', $data);
        }
    }

    public function single_submit_marks_register(Request $request)
    {
        $id = $request->id;

        if (!empty($request->student_id)) {
            $getExamSchedule = ExamScheduleModel::getSingle($id);
            $class_work = !empty($request->class_work) ? $request->class_work : 0;
            $home_work =  !empty($request->home_work) ? $request->home_work : 0;
            $test_work = !empty($request->test_work) ? $request->test_work : 0;
            $exam = !empty($request->exam) ? $request->exam : 0;
            $full_marks = 10;

            $total_mark = $class_work + $home_work + $test_work + $exam;
            // dd($full_marks, $total_mark);
            if ($full_marks >= $total_mark) {
                $getMark = MarkRegisterModel::getSingleByWork($request->student_id, $request->exam_id, $request->class_id, $request->subject_id);
                if (!empty($getMark)) {
                    $save = $getMark;
                } else {
                    $save = new MarkRegisterModel;
                    $save->created_by = Auth::user()->id;
                    $save->exam_id = $request->exam_id;
                    $save->student_id = $request->student_id;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $request->subject_id;
                }

                $save->class_work = $class_work;
                $save->home_work = $home_work;
                $save->test_work = $test_work;
                $save->exam = $exam;


                $save->save();

                $json['message'] = 'Điểm đã được cập nhật thành công!';
            } else {
                $json['message'] = 'Tổng điểm lớn hơn điểm tối đa của Khóa học!';
            }

            echo json_encode($json);
        } else {
            $json['message'] = 'Có lỗi xảy ra, vui lòng thử lại sau!';
            echo json_encode($json);
        }
    }


    public function my_exam_result()
    {
        $getExam = MarkRegisterModel::getExam(Auth::user()->id);
        $data['header_title'] = 'Điểm';
        $result = array();

        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id, Auth::user()->id);
            $dataSubject = array();
            foreach ($getExamSubject as $exam) {
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_mark'] = $exam['passing_mark'];
                $dataS['total'] = $exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
                $dataS['grade'] = MarksGradeModel::getGrade($dataS['total'] * 10 / $dataS['full_marks']);
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        return view('student.my_exam_result', $data);
    }

    public function my_exam_result_print($id, Request $request)
    {
        $exam_id = $id;

        $data['getStudent'] = User::getSingle(Auth::user()->id);

        $getExamSubject = MarkRegisterModel::getExamSubject($exam_id, Auth::user()->id);
        $dataSubject = array();
        foreach ($getExamSubject as $exam) {
            $dataS = array();
            $dataS['subject_name'] = $exam['subject_name'];
            $dataS['class_work'] = $exam['class_work'];
            $dataS['home_work'] = $exam['home_work'];
            $dataS['test_work'] = $exam['test_work'];
            $dataS['exam'] = $exam['exam'];
            $dataS['full_marks'] = $exam['full_marks'];
            $dataS['passing_mark'] = $exam['passing_mark'];
            $dataS['total'] = $exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
            $dataS['grade'] = MarksGradeModel::getGrade($dataS['total'] * 10 / $dataS['full_marks']);
            $dataSubject[] = $dataS;
            $data['exam_name'] = $exam['exam_name'];
        }
        $data['getExamMark'] = $dataSubject;


        return view('exam_result_print', $data);
    }

    public function parent_student_exam_result($student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $getExam = MarkRegisterModel::getExam($student_id);
        $data['header_title'] = 'Điểm';
        $result = array();

        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarkRegisterModel::getExamSubject($value->exam_id, $student_id);
            $dataSubject = array();
            foreach ($getExamSubject as $exam) {
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['home_work'] = $exam['home_work'];
                $dataS['test_work'] = $exam['test_work'];
                $dataS['exam'] = $exam['exam'];
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['passing_mark'] = $exam['passing_mark'];
                $dataS['total'] = $exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
                $dataS['grade'] = MarksGradeModel::getGrade($dataS['total'] * 10 / $dataS['full_marks']);
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        return view('parent.my_student.exam_result', $data);
    }

    public function marks_grade_list()
    {
        $data['header_title'] = 'Thang điểm';
        $data['getRecord'] = MarksGradeModel::getRecord();
        return view('admin.examinations.marks_grade.list', $data);
    }
    public function marks_grade_add()
    {
        $data['header_title'] = 'Thang điểm';
        return view('admin.examinations.marks_grade.add', $data);
    }
    public function PostMarkAdd(Request $request)
    {
        $mark = new MarksGradeModel;
        $mark->name = trim($request->name);
        $mark->percent_from = ($request->percent_from);
        $mark->percent_to = ($request->percent_to);
        $mark->created_by = Auth::user()->id;
        $mark->save();
        return redirect('vAdmin/examinations/marks_grade')->with('sucess', 'Thêm mới thành công!');
    }
    public function marks_grade_edit($id)
    {
        $data['header_title'] = 'Thang điểm';
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        return view('admin.examinations.marks_grade.edit', $data);
    }
    public function PostMarksGradEdit($id, Request $request)
    {
        $mark = MarksGradeModel::getSingle($id);
        if (!empty($mark)) {
            $mark->name = trim($request->name);
            $mark->percent_from = ($request->percent_from);
            $mark->percent_to = ($request->percent_to);

            $mark->save();
            return redirect('vAdmin/examinations/marks_grade')->with('sucess', 'Cập nhật thành công!');
        } else {
            abort(404);
        }
    }
    public function marks_grade_delete($id)
    {
        $mark = MarksGradeModel::getSingle($id);
        if (!empty($mark)) {
            $mark->delete();
            return redirect()->back()->with('sucess', 'Thêm mới thành công!');
        } else {
            abort(404);
        }
    }
}
