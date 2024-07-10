<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\EnrollmentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function listEnrollments($id)
    {
        $data['header_title'] = 'Danh sách học sinh';
        $data['getStudent'] = User::getStudentNeedEnroll($id);
        $data['getClass'] = ClassModel::single($id);
        return view("admin.enrollments.list", $data);
    }

    public function addStudentEnroll($student_id, $class_id)
    {

        if (!empty($student_id) && !empty($class_id)) {
            $exists = EnrollmentModel::getByStudentAndClass($student_id, $class_id);

            if (empty($exists)) {
                $new = new EnrollmentModel;
                $new->student_id = $student_id;
                $new->class_id = $class_id;
                $new->enrollment_date = now();
                $new->save();
                return redirect("vAdmin/class/addvStudent/" . $class_id)->with('success', 'Đăng ký học thành công!');
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    public function removeStudent($student_id, $class_id)
    {
        if (!empty($student_id) && !empty($class_id)) {
            $exists = EnrollmentModel::getByStudentAndClass($student_id, $class_id);

            if (!empty($exists)) {
                $exists->delete();
                return redirect("vAdmin/class/addvStudent/" . $class_id)->with('success', 'Xóa thành công!');
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    public function myStudentSubject()
    {
        $id = Auth::user()->id;
        $myClass = EnrollmentModel::getMyClass($id);
        $data['header_title'] = 'Lớp của tôi';
        $data['getMyClass'] = $myClass;
        return view('student.my_subject', $data);
    }
}
