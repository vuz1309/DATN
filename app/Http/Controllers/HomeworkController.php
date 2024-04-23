<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
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

        return redirect('admin/homework/homework')->with('success', 'Thêm mới thành công!');
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

            return redirect('admin/homework/homework')->with('success', 'Cập nhật thành công!');
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
            return redirect('admin/homework/homework')->with('success', 'Xóa thành công!');
        } else {
            abort(404);
        }
    }
}
