<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\EnrollmentModel;
use App\Models\User;
use Illuminate\Http\Request;

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
                return redirect("admin/class/addStudent/" . $class_id)->with('success', 'Đăng ký học thành công!');
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        } else {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }
}
