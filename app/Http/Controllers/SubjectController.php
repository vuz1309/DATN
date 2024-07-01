<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SubjectModel;
use App\Models\ClassSubjectModel;
use App\Models\User;

class SubjectController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Khóa học';
        $data['getRecord'] = SubjectModel::getRecord();
        return view("admin.subject.list", $data);
    }
    public function listStudent($id)
    {
        $data['header_title'] = 'Khóa học';
        $data['getRecord'] = SubjectModel::getSubjectByClass($id);
        $data['isView'] = true;
        return view("admin.subject.list", $data);
    }
    public function add()
    {
        $data['header_title'] = 'Thêm mới Khóa học';
        return view("admin.subject.add", $data);
    }

    public function PostAdd(Request $request)
    {

        $request->validate([
            'name' => 'unique:class,name'
        ], [
            'name.unique' => 'Lớp học đã tồn tại'
        ]);
        $save = new SubjectModel;
        $save->name = $request->name;
        $save->status = $request->status;
        $save->type = $request->type;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect("vAdmin/subject/list")->with('success', 'Thêm mới Khóa học thành công');
    }

    public function edit($id)
    {
        $record = SubjectModel::single($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['header_title'] = 'Sửa Khóa học';
            return view('admin.subject.edit', $data);
        } else {
            abort(404);
        }
    }

    public function PostEdit($id, Request $request)
    {
        $request->validate([
            'name' => 'unique:class,name,' . $id
        ], [
            'name.unique' => 'Lớp học đã tồn tại'
        ]);
        $record = SubjectModel::single($id);
        if (!empty($record)) {
            $record->name = $request->name;
            $record->status = $request->status;
            $record->type = $request->type;
            $record->save();
            return redirect('vAdmin/subject/list')->with('success', 'Sửa thông tin lớp học thành công');
        } else {
            abort(404);
        }
    }

    public function delete($id, Request $request)
    {
        $record = SubjectModel::single($id);
        if (!empty($record)) {
            $record->is_delete = 1;
            $record->save();
            return redirect('vAdmin/subject/list')->with('success', 'Xóa lớp học thành công');
        } else {
            abort(404);
        }
    }


    // TODO navigate 404 page
    public function myStudentSubject()
    {
        // $class_id = Auth::user()->class_id;
        $data['header_title'] = 'Khóa học';
        if (!empty($class_id)) {
            $data['getRecord'] = ClassSubjectModel::mySubject($class_id);

            return view('student.my_subject', $data);
        } else {
            abort(404);
        }
    }

    public function parentStudentSubject($student_id)
    {
        $data['header_title'] = 'Khóa học';
        $std = User::getSingle($student_id);

        if (!empty($std) && !empty($std->class_id)) {
            $data['student'] = $std;

            $data['getRecord'] = ClassSubjectModel::mySubject($std->class_id);

            return view('parent.my_student.subject', $data);
        } else {
            abort(404);
        }
    }
}
