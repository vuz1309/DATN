<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;


class AssignClassTeacherController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Giáo viên - Lớp';
        $data['getRecord'] = AssignClassTeacherModel::getTeacherClass();
        return view('admin.assign_class_teacher.list', $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();
        $data['header_title'] = 'Thêm giáo viên - Lớp';
        return view('admin.assign_class_teacher.add', $data);
    }

    public function PostAdd(Request $request)
    {
        if (!empty($request->teacher_id)) {
            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->is_delete = 0;
                    $getAlreadyFirst->save();
                } else {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }

            return redirect('admin/assign_class_teacher/list')->with('success', 'Thêm mới thành công');
        } else {
            abort(404);
        }
    }

    public function edit($id)
    {
        $record = AssignClassTeacherModel::getSingle($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['getClass'] = ClassModel::getClass();
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getByClass($record->class_id);
            $data['getTeachers'] = User::getTeacherClass();
            $data['header_title'] = 'Sửa giáo viên - Lớp';
            return view('admin.assign_class_teacher.edit', $data);
        } else {
            abort(404);
        }
    }


    public function PostEdit(Request $request)
    {
        AssignClassTeacherModel::deleteOldAssign($request->class_id);
        if (!empty($request->teacher_id)) {


            foreach ($request->teacher_id as $teacher_id) {
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->is_delete = 0;
                    $getAlreadyFirst->save();
                } else {
                    $save = new AssignClassTeacherModel;
                    $save->class_id = $request->class_id;
                    $save->teacher_id = $teacher_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }

            return redirect('admin/assign_class_teacher/list')->with('success', 'Sửa thông tin thành công');
        } else {
            abort(404);
        }
    }


    public function delete($id, Request $request)
    {
        $record = AssignClassTeacherModel::getSingle($id);
        if (!empty($record)) {
            $record->is_delete = 1;
            $record->save();
            return redirect('admin/assign_class_teacher/list')->with('success', 'Xóa thành công');
        } else {
            abort(404);
        }
    }

    public function editSingle($id)
    {
        $record = AssignClassTeacherModel::getSingle($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Sửa giáo viên - lớp học';
            return view('admin.assign_class_teacher.edit_signle', $data);
        } else {
            abort(404);
        }
    }
    public function PostEditSingle($id, Request $request)
    {
        $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $request->teacher_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->is_delete = 0;
            $getAlreadyFirst->save();
        } else {
            $save = new AssignClassTeacherModel;
            $save->class_id = $request->class_id;
            $save->teacher_id = $request->teacher_id;
            $save->status = $request->status;
            $save->created_by = Auth::user()->id;
            $save->save();
        }

        return redirect('admin/assign_class_teacher/list')->with('success', 'Cập nhật thành công!');
    }

    public function myClassSubject()
    {
        $data['header_title']  = 'Môn học - lớp';
        $data['getRecord'] = AssignClassTeacherModel::getMyClassSubject(Auth::user()->id);
        return view('teacher.my_class_subject', $data);
    }
}
