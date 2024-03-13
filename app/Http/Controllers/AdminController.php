<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Danh sách admin';
        return view("admin.admin.list", $data);
    }

    public function add()
    {

        $data['header_title'] = 'Thêm mới';
        return view("admin.admin.add", $data);
    }

    public function PostAdd(Request $request)
    {
        request()->validate([
            'email' => "required|email|unique:users"
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->save();
        return redirect(url('admin/admin/list'))->with("success", "Thêm mới quản lý thành công!");
    }

    public function edit($id)
    {
        $data['header_title'] = 'Sửa thông tin';
        $data['getUserRecord'] = User::getSingle($id);

        if (!empty($data['getUserRecord'])) {
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    public function PostEdit(Request $request, $id)
    {
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);

        $user->save();
        return redirect(url('admin/admin/list'))->with('success', 'Cập nhật thông tin thành công');
    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect(url('admin/admin/list'))->with('success', 'Xóa thành công!');
    }
}
