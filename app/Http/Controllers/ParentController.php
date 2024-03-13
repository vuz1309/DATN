<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Hash;
use Auth;
use Str;

class ParentController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Phụ huynh';
        $data['getRecord'] = User::getParents();


        return view("admin.parent.list", $data);
    }

    public function add()
    {
        $data['header_title'] = 'Thêm mới phụ huynh';
        $data['getClass'] = ClassModel::getClass();
        return view("admin.parent.add", $data);
    }

    public function PostAdd(Request $request)
    {

        request()->validate([
            'email' => 'required|email|unique:users',

            'password' => 'required',
            'mobile_number' => 'max:15|min:8|nullable',
            'address' => 'max:100|nullable',
            'occupation' => 'max:50|nullable',

        ]);


        $save = new User;
        $save->name = trim($request->name);
        $save->last_name = trim($request->last_name);

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);

            $save->profile_pic = $filename;
        }


        $save->gender = $request->gender;
        $save->mobile_number = trim($request->mobile_number);

        $save->occupation = trim($request->occupation);
        $save->address = trim($request->address);

        $save->email = trim($request->email);
        $save->password = Hash::make(trim($request->password));
        $save->status = $request->status;
        $save->user_type = 4;

        $save->save();

        return redirect("admin/parent/list")->with('success', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $record = User::getSingle($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;


            $data['header_title'] = 'Sửa thông tin phụ huynh';
            return view('admin.parent.edit', $data);
        } else {
            abort(404);
        }
    }

    public function PostEdit($id, Request $request)
    {


        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8|nullable',
            'address' => 'max:100|nullable',
            'occupation' => 'max:50|nullable',
        ]);


        $save = User::getSingle($id);
        if (!empty($save)) {
            $save->name = trim($request->name);
            $save->last_name = trim($request->last_name);


            if (!empty($request->file('profile_pic'))) {

                if (!empty($save->getProfile())) {
                    unlink('upload/profile/' . $save->profile_pic);
                }

                $ext = $request->file('profile_pic')->getClientOriginalExtension();
                $file = $request->file('profile_pic');
                $randomStr = date('Ymdhis') . Str::random(20);
                $filename = strtolower($randomStr) . '.' . $ext;
                $file->move('upload/profile/', $filename);

                $save->profile_pic = $filename;
            }



            $save->gender = $request->gender;
            $save->address = trim($request->address);
            $save->occupation = trim($request->occupation);
            $save->mobile_number = trim($request->mobile_number);


            $save->email = trim($request->email);
            if (!empty($request->password)) {
                $save->password = Hash::make(trim($request->password));
            }
            $save->status = $request->status;

            $save->save();

            return redirect('admin/parent/list')->with('success', 'Sửa thông tin thành công!');
        } else {
            abort(404);
        }
    }

    public function delete($id, Request $request)
    {
        $record = User::getSingle($id);
        if (!empty($record)) {
            $record->is_delete = 1;
            $record->save();
            return redirect('admin/parent/list')->with('success', 'Xóa thành công!');
        } else {
            abort(404);
        }
    }

    public function myStudent($id)
    {
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudents'] = User::getSearchStudents();
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'Học sinh phụ huynh';
        return view('admin.parent.my_student', $data);
    }

    public function myStudentParent()
    {
        $id = Auth::user()->id;
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = 'Con cái';
        return view('parent.my_student', $data);
    }

    public function assignStudentParent($student_id, $parent_id)
    {
        $std = User::getSingle($student_id);
        if (!empty($std)) {
            $std->parent_id = $parent_id;
            $std->save();
            return redirect()->back()->with('success', 'Thêm phụ huynh cho học sinh thành công!');
        } else {
            abort(404);
        }
    }

    public function deleteAssignStudentParent($student_id)
    {
        $std = User::getSingle($student_id);
        if (!empty($std)) {
            $std->parent_id = null;
            $std->save();
            return redirect()->back()->with('success', 'Xóa học sinh phụ huynh thành công!');
        } else {
            abort(404);
        }
    }
}
