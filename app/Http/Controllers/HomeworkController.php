<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Auth;
use Str;

class HomeworkController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Bài tập';
        $data['getRecord'] = HomeworkModel::getHomework();
        return view('admin.homework.list', $data);
    }
    public function list_teacher()
    {
        $teacher_id = Auth::user()->id;
        $data['header_title'] = 'Bài tập';
        $data['getRecord'] = HomeworkModel::getTeacherHomework($teacher_id);
        return view('teacher.homework.list', $data);
    }
    public function add()
    {
        $data['header_title'] = 'Bài tập';
        $data['getClass'] = ClassModel::getClass();
        return view('admin.homework.add', $data);
    }
    public function add_teacher()
    {
        $teacher_id = Auth::user()->id;
        $data['header_title'] = 'Bài tập';
        $data['getClass'] = AssignClassTeacherModel::getClassOfTeacher($teacher_id);
        return view('teacher.homework.add', $data);
    }

    public function edit($id)
    {
        $homework = HomeworkModel::getSingle($id);
        if (!empty($homework)) {
            $data['header_title'] = 'Bài tập';
            $data['getRecord'] = $homework;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = ClassSubjectModel::mySubject($homework->class_id);
            return view('admin.homework.edit', $data);
        } else {
            abort(404);
        }
    }
    public function edit_teacher($id)
    {
        $teacher_id = Auth::user()->id;
        $homework = HomeworkModel::getSingle($id);
        if (!empty($homework)) {
            $data['header_title'] = 'Bài tập';
            $data['getRecord'] = $homework;
            $data['getClass'] = AssignClassTeacherModel::getClassOfTeacher($teacher_id);
            $data['getSubject'] = ClassSubjectModel::mySubject($homework->class_id);
            return view('teacher.homework.edit', $data);
        } else {
            abort(404);
        }
    }
    public function PostAdd(Request $request)
    {
        $homework = new HomeworkModel;
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->description = trim($request->description);
        $homework->homework_date = ($request->homework_date);
        $homework->submission_date = ($request->submission_date);
        $homework->created_by = Auth::user()->id;
        if (!empty($request->file('document_file'))) {
            // if (!empty($homework->getProfile())) {
            //     unlink('upload/document/' . $homework->document_file);
            // }
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/homework/', $filename);

            $homework->document_file = $filename;
        }

        $homework->save();

        return redirect('vAdmin/homework/homework')->with('success', 'Thêm mới thành công!');
    }
    public function PostEdit($id, Request $request)
    {
        $homework = HomeworkModel::getSingle($id);
        if (!empty($homework)) {
            $homework->class_id = trim($request->class_id);
            $homework->subject_id = trim($request->subject_id);
            $homework->description = trim($request->description);
            $homework->homework_date = ($request->homework_date);
            $homework->submission_date = ($request->submission_date);
            if (!empty($request->file('document_file'))) {
                if (!empty($homework->getDocument())) {
                    unlink('upload/homework/' . $homework->document_file);
                }
                $ext = $request->file('document_file')->getClientOriginalExtension();
                $file = $request->file('document_file');
                $randomStr = date('Ymdhis') . Str::random(20);
                $filename = strtolower($randomStr) . '.' . $ext;
                $file->move('upload/homework/', $filename);

                $homework->document_file = $filename;
            }

            $homework->save();

            return redirect('vAdmin/homework/homework')->with('success', 'Cập nhật thành công!');
        } else {
            abort(404);
        }
    }
    public function delete($id)
    {
        $homework = HomeworkModel::getSingle($id);

        if (!empty($homework)) {
            $homework->is_delete = 1;
            $homework->save();
            return redirect('vAdmin/homework/homework')->with('success', 'Xóa thành công!');
        } else {
            abort(404);
        }
    }
    public function student_submit_homework($id)
    {
        $homework = HomeworkModel::getSingle($id);

        if (!empty($homework)) {
            $data['header_title'] = 'Nộp bài tập';
            $data['getRecord'] = $homework;
            return view('student.homework.submit', $data);
        } else {
            abort(404);
        }
    }

    public function submitted($id)
    {

        if (!empty($id)) {
            $data['getRecord'] = HomeworkSubmitModel::getSubmitted($id);
        }
        $data['header_title'] = 'Bài tập';
        return view('admin.homework_submit.list', $data);
    }
    public function student_my_homework()
    {
        $class_id = Auth::user()->id;
        if (!empty($class_id)) {
            $data['getRecord'] = HomeworkModel::getStudentHomework(Auth::user()->id);
        }
        $data['header_title'] = 'Bài tập';
        return view('student.homework.list', $data);
    }
    public function PostSubmitHomework($id, Request $request)
    {

        $submit = new HomeworkSubmitModel;
        if (!empty($request->file('document_file'))) {

            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/homework_submit/', $filename);
            $submit->document_file = $filename;
        }
        $submit->homework_id = $id;
        $submit->student_id = Auth::user()->id;
        $submit->description = $request->description;

        $submit->save();

        return redirect('vStudent/homework')->with('success', 'Nộp bài tập thành công!');
    }

    public function edit_homework_submitted($id)
    {
        $data['header_title'] = 'Bài tập đã nộp';
        $data['getRecord'] = HomeworkSubmitModel::getSingle($id);


        return view('student.homework_submit.edit', $data);
    }
    public function PostEditSubmitHomework($id, Request $request)
    {

        $submit = HomeworkSubmitModel::getSingle($id);
        if (!empty($request->file('document_file'))) {
            if (!empty($submit->getDocument())) {
                unlink('upload/homework_submit/' . $submit->document_file);
            }
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/homework_submit/', $filename);
            $submit->document_file = $filename;
        }
        $submit->description = $request->description;
        $submit->save();

        return redirect('vStudent/homework/submitted')->with('success', 'Sửa thành công!');
    }
    public function student_my_submited_homework()
    {
        $student_id = Auth::user()->id;

        $data['getRecord'] = HomeworkSubmitModel::getMySumited($student_id);

        $data['header_title'] = 'Bài tập';
        return view('student.homework_submit.list', $data);
    }

    public function view_submitted($id)
    {
        $data['header_title'] = 'Bài tập đã nộp';
        $data['getRecord'] = HomeworkSubmitModel::getSingle($id);
        return view('admin.homework_submit.detail', $data);
    }

    public function homework_report()
    {
        $data['header_title'] = 'Báo cáo';
        $data['getRecord'] = HomeworkSubmitModel::getHomeworkReport();

        return view('admin.homework.report', $data);
    }
}
