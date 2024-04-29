<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\SettingModel;
use Auth;
use Hash;
use Str;

class UserController extends Controller
{
    public function changePassword()
    {
        $data['header_title'] = 'Đổi mật khẩu';
        return view("profile.change_password", $data);
    }

    public function PostChangePassword(Request $request)
    {
        if ($request->new_password != $request->confirm_new_password) {
            return redirect()->back()->with('error', 'Mật khẩu không trùng khớp!');
        }
        $user = User::getSingle(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with("success", "Đổi mật khẩu thành công!");
        } else {
            return redirect()->back()->with("error", "Mật khẩu cũ không chính xác!");
        }
    }

    public function myAccount()
    {
        $data['header_title'] = 'Tài khoản';
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        if (Auth::user()->user_type == 2) {
            return view("teacher.my_account", $data);
        } else if (Auth::user()->user_type == 3) {
            $data['getClass'] = ClassModel::getClass();
            return view("student.my_account", $data);
        } else if (Auth::user()->user_type == 4) {
            return view("parent.my_account", $data);
        } else if (Auth::user()->user_type == 1) {
            return view("admin.my_account", $data);
        }
    }

    public function UpdateMyAccount(Request $request)
    {
        $id  = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required',
            'last_name' => 'required',
            'class_id' => 'required',

            'mobile_number' => 'max:15|min:8|nullable',
        ]);


        $save = User::getSingle($id);
        if (!empty($save)) {
            $save->name = trim($request->name);
            $save->last_name = trim($request->last_name);

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

            $save->address = trim($request->address);
            $save->gender = $request->gender;
            $save->mobile_number = trim($request->mobile_number);

            $save->work_experience = trim($request->work_experience);
            $save->note = trim($request->note);
            $save->qualification = trim($request->qualification);
            $save->permanent_address = trim($request->permanent_address);
            $save->email = trim($request->email);



            $save->status = $request->status;

            $save->save();

            return redirect('teacher/account')->with('success', 'Sửa thông tin thành công!');
        } else {
            abort(404);
        }
    }

    public function UpdateMyAccountStudent(Request $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'weight' => 'max:10',
            'height' => 'max:10',
            'mobile_number' => 'max:15|min:8|nullable',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'admission_number' => 'max:50',
            'roll_number' => 'max:50',
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
            $save->caste = trim($request->caste);
            $save->gender = $request->gender;
            $save->mobile_number = trim($request->mobile_number);

            $save->blood_group = trim($request->blood_group);
            $save->height = trim($request->height);
            $save->weight = trim($request->weight);
            $save->email = trim($request->email);

            $save->status = $request->status;

            $save->save();

            return redirect('student/account')->with('success', 'Sửa thông tin thành công!');
        } else {
            abort(404);
        }
    }

    public function UpdateMyAccountParent(Request $request)
    {

        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'mobile_number' => 'max:15|min:8|nullable',
            'address' => 'max:100|nullable',
            'occupation' => 'max:50|nullable',
            'status' => 'required',
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
            $save->status = $request->status;

            $save->save();

            return redirect('parent/account')->with('success', 'Sửa thông tin thành công!');
        } else {
            abort(404);
        }
    }

    public function PostUpdateMyAccountAdmin(Request $request)
    {

        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
        ]);
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);

        $user->save();
        return redirect(url('admin/account'))->with('success', 'Cập nhật thông tin thành công');
    }

    public function settings()
    {
        $data['header_title'] = 'Cài đặt';
        $data['getRecord'] = SettingModel::getSetting();
        return view('admin.setting', $data);
    }
    public function PostSetting(Request $request)
    {
        request()->validate([
            'paypal_email' => 'required|email|',
        ]);
        $user = SettingModel::getSetting();
        if (!empty($user)) {

            $user->paypal_email = trim($request->paypal_email);
            $user->save();
        } else {
            $user = new SettingModel;
            $user->paypal_email = trim($request->paypal_email);
            $user->save();
        }

        return redirect('admin/settings')->with('success', 'Cập nhật thông tin thành công');
    }
}
