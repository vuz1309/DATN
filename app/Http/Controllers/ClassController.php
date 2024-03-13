<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;

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
        $save = new ClassModel;
        $save->name = $request->name;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect("admin/class/list")->with('success', 'Thêm mới lớp học thành công');
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
        $record = ClassModel::single($id);
        if (!empty($record)) {
            $record->name = $request->name;
            $record->status = $request->status;
            $record->save();
            return redirect('admin/class/list')->with('success', 'Sửa thông tin lớp học thành công');
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
            return redirect('admin/class/list')->with('success', 'Xóa lớp học thành công');
        } else {
            abort(404);
        }
    }
}
