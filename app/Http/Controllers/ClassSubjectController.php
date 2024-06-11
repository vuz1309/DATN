<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;

use Auth;
use App\Models\ClassSubjectModel;
use App\Models\User;

class ClassSubjectController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Lớp-Khóa học';
        $data['getRecord'] = ClassSubjectModel::getRecord();
        return view("admin.assign_subject.list", $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['getTeacher'] = User::getTeachers();
        $data['header_title'] = 'Thêm mới môn-lớp học';
        return view("admin.assign_subject.add", $data);
    }

    public function PostAdd(Request $request)
    {
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $index => $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::countAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->teacher_id = $request->teacher_id[$index];
                    $getAlreadyFirst->is_delete = 0;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $subject_id;
                    $save->teacher_id = $request->teacher_id[$index];
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect("admin/assign_subject/list")->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->back()->with('error', 'Khóa học cho lớp không được rỗng!');
        }
    }


    public function edit($id)
    {
        $record = ClassSubjectModel::single($id);
        if (!empty($record)) {
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($record->class_id);
            $data['getRecord'] = $record;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['getTeacher'] = User::getTeachers();
            $data['header_title'] = 'Sửa';
            return view('admin.assign_subject.edit', $data);
        } else {
            abort(404);
        }
    }

    public function PostEdit(Request $request)
    {
        ClassSubjectModel::deleteSubject(($request->class_id));
        if (!empty($request->subject_id)) {


            foreach ($request->subject_id as $index => $subject_id) {
                $getAlreadyFirst = ClassSubjectModel::countAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->teacher_id = $request->teacher_id[$index];
                    $getAlreadyFirst->is_delete = 0;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassSubjectModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $request->teacher_id[$index];
                    $save->subject_id = $subject_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }

            return redirect('admin/assign_subject/list')->with('success', 'Sửa thông tin lớp học thành công');
        } else {
            abort(404);
        }
    }

    public function delete($id, Request $request)
    {
        $record = ClassSubjectModel::single($id);
        if (!empty($record)) {
            $record->is_delete = 1;
            $record->save();
            return redirect('admin/assign_subject/list')->with('success', 'Xóa lớp học thành công');
        } else {
            abort(404);
        }
    }

    public function editSingle($id)
    {
        $record = ClassSubjectModel::single($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['getTeacher'] = User::getTeachers();
            $data['header_title'] = 'Sửa thông tin';
            return view('admin.assign_subject.edit_signle', $data);
        } else {
            abort(404);
        }
    }
    public function PostEditSingle($id, Request $request)
    {
        $getAlreadyFirst = ClassSubjectModel::countAlreadyFirst($request->class_id, $request->subject_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->teacher_id = $request->teacher_id;
            $getAlreadyFirst->is_delete = 0;
            $getAlreadyFirst->save();
        } else {
            $save = new ClassSubjectModel;
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->created_by = Auth::user()->id;
            $save->save();
        }

        return redirect('admin/assign_subject/list')->with('success', 'Cập nhật thành công!');
    }
}
