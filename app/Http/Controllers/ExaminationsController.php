<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

use App\Models\ExamModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
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
        return view('admin.examinations.exam.add', $data);
    }

    public function PostExaxmAdd(Request $request)
    {
        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', 'Tạo bài thi thành công!');
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
            return redirect('admin/examinations/exam/list')->with('success', 'Cập nhật bài thi thành công!');
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
            return redirect('admin/examinations/exam/list')->with('success', 'Xóa bài thi thành công!');
        } else {
            abort(404);
        }
    }

    public function exam_schedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        $result = array();
        if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
            $getSubject = ClassSubjectModel::mySubject($request->get('class_id'));
            foreach ($getSubject as $value) {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;
                $dataS['class_id'] = $value->class_id;

                $ExamSchedule = ExamScheduleModel::getRecordSingle($request->get('class_id'), $request->get('exam_id'), $value->subject_id);

                if (!empty($ExamSchedule)) {
                    $dataS['exam_date'] = $ExamSchedule->exam_date;
                    $dataS['start_time'] =  $ExamSchedule->start_time;
                    $dataS['end_time'] = $ExamSchedule->end_time;
                    $dataS['full_marks'] = $ExamSchedule->full_marks;
                    $dataS['passing_mark'] = $ExamSchedule->passing_mask;
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
        ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id, $request->subject_id);
        if (!empty($request->schedule)) {
            foreach ($request->schedule as $schedule) {

                if (
                    !empty($schedule['subject_id'])
                    && !empty($schedule['exam_date'])
                    && !empty($schedule['start_time'])
                    && !empty($schedule['end_time'])
                    && !empty($schedule['room_number'])
                    && !empty($schedule['full_marks'])
                    && !empty($schedule['passing_mark'])
                ) {
                    $exam = new ExamScheduleModel;
                    $exam->exam_id = $request->exam_id;
                    $exam->class_id = $request->class_id;
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
}
