<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;

class ClassController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Lớp học';
        $data['getRecord'] = ClassModel::getRecord();
        return view("admin.class.list", $data);
    }

    public function add()
    {
        $data['header_title'] = 'Thêm mới lớp học';
        return view("admin.class.add", $data);
    }

    public function PostAdd(Request $request)
    {

        // $request->validate([
        //     'name' => 'unique:class,name'
        // ], [
        //     'name.unique' => 'Lớp học đã tồn tại'
        // ]);
        $save = new ClassModel;
        $save->name = $request->name;
        $save->fee = $request->fee;
        $save->status = $request->status;
        $save->start_date = $request->start_date;
        $save->end_date = $request->end_date;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect("vAdmin/class/list")->with('success', 'Thêm mới lớp học thành công');
    }

    public function edit($id)
    {
        $record = ClassModel::single($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['header_title'] = 'Sửa lớp học';

            return view('admin.class.edit', $data);
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
        $record = ClassModel::single($id);
        if (!empty($record)) {
            $record->name = $request->name;
            $record->fee = $request->fee;
            $record->status = $request->status;
            $record->start_date = $request->start_date;
            $record->end_date = $request->end_date;
            $record->save();
            return redirect('vAdmin/class/list')->with('success', 'Sửa thông tin lớp học thành công');
        } else {
            abort(404);
        }
    }

    public function delete($id, Request $request)
    {
        $record = ClassModel::single($id);
        if (!empty($record)) {
            $record->is_delete = 1;
            $record->save();
            return redirect('vAdmin/class/list')->with('success', 'Xóa lớp học thành công');
        } else {
            abort(404);
        }
    }
}
