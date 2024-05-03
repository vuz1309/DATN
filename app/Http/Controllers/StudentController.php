<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Str;
use App\Models\User;

class StudentController extends Controller
{
    public function list()
    {
        $data['header_title'] = 'Học sinh';
        $data['getRecord'] = User::getStudents();
        $data['getClass'] = ClassModel::getClass();

        return view("admin.student.list", $data);
    }

    public function add()
    {
        $data['header_title'] = 'Thêm mới học sinh';
        $data['getClass'] = ClassModel::getClass();
        return view("admin.student.add", $data);
    }

    public function PostAdd(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile_number' => 'max:15|min:8|nullable',
            'admission_number' => 'max:50|unique:users',
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'mobile_number.max' => 'Số điện thoại không được quá 15 ký tự.',
            'mobile_number.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',
            'admission_number.max' => 'Mã học sinh không được quá 50 ký tự.',
            'admission_number.unique' => 'Mã học sinh đã tồn tại trong hệ thống.',
        ]);


        $save = new User;
        $save->name = trim($request->name);
        $save->last_name = trim($request->last_name);
        $save->admission_number = trim($request->admission_number);

        if (!empty($request->date_of_birth)) {
            $save->date_of_birth = trim($request->date_of_birth);
        }


        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile/', $filename);

            $save->profile_pic = $filename;
        }

        if (!empty($request->admission_date)) {
            $save->admission_date = trim($request->admission_date);
        }

        $save->roll_number = trim($request->roll_number);
        $save->class_id = $request->class_id;
        $save->caste = trim($request->caste);
        $save->gender = $request->gender;
        $save->mobile_number = trim($request->mobile_number);

        $save->blood_group = trim($request->blood_group);
        $save->height = trim($request->height);
        $save->weight = trim($request->weight);
        $save->email = trim($request->email);
        $save->password = Hash::make(trim($request->password));
        $save->status = $request->status;
        $save->user_type = 3;

        $save->save();

        return redirect("admin/student/list")->with('success', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $record = User::getSingle($id);
        if (!empty($record)) {
            $data['getRecord'] = $record;
            $data['getClass'] = ClassModel::getClass();

            $data['header_title'] = 'Sửa học sinh';
            return view('admin.student.edit', $data);
        } else {
            abort(404);
        }
    }

    public function PostEdit($id, Request $request)
    {


        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,

            'mobile_number' => 'max:15|min:8|nullable',

            'admission_number' => 'max:50',

        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'mobile_number.max' => 'Số điện thoại không được quá 15 ký tự.',
            'mobile_number.min' => 'Số điện thoại phải có ít nhất 8 ký tự.',
            'admission_number.max' => 'Mã học sinh không được quá 50 ký tự.',
            'admission_number.unique' => 'Mã học sinh đã tồn tại trong hệ thống.',
        ]);


        $save = User::getSingle($id);
        if (!empty($save)) {
            $save->name = trim($request->name);
            $save->last_name = trim($request->last_name);
            $save->admission_number = trim($request->admission_number);

            if (!empty($request->date_of_birth)) {
                $save->date_of_birth = trim($request->date_of_birth);
            }


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

            if (!empty($request->admission_date)) {
                $save->admission_date = trim($request->admission_date);
            }

            $save->roll_number = trim($request->roll_number);
            $save->class_id = $request->class_id;
            $save->caste = trim($request->caste);
            $save->gender = $request->gender;
            $save->mobile_number = trim($request->mobile_number);

            $save->blood_group = trim($request->blood_group);
            $save->height = trim($request->height);
            $save->weight = trim($request->weight);
            $save->email = trim($request->email);
            if (!empty($request->password)) {
                $save->password = Hash::make(trim($request->password));
            }
            $save->status = $request->status;

            $save->save();

            return redirect('admin/student/list')->with('success', 'Sửa thông tin thành công!');
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
            return redirect('admin/student/list')->with('success', 'Xóa thành công!');
        } else {
            abort(404);
        }
    }


    public function teacherStudent()
    {
        $data['header_title'] = 'Học sinh của tôi';
        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);
        $data['getClass'] = ClassModel::getClass();
        return view('teacher.my_student', $data);
    }
}
