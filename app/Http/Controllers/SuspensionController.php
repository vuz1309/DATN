<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\EnrollmentModel;
use App\Models\StudentAddFeesModel;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Str;
use App\Models\SuspensionModel;
use App\Models\User;

class SuspensionController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Học sinh bảo lưu";
        $data['getRecord'] = SuspensionModel::getSuspensionStudents();
        return view("admin.suspension.list", $data);
    }
    public function student_list()
    {
        $student_id = Auth::user()->id;
        $data['header_title'] = "Học sinh bảo lưu";
        $data['getRecord'] = SuspensionModel::getMySuspensions($student_id);
        return view("student.suspensions.list", $data);
    }

    public function student_add()
    {
        $student_id = Auth::user()->id;
        $data['header_title'] = "Yêu cầu  bảo lưu";
        $data['getMyClass'] = EnrollmentModel::getMyClass($student_id);
        return view("student.suspensions.add", $data);
    }

    public function PostStudentAdd(Request $request)
    {
        $student_id = Auth::user()->id;
        $newRequest = new SuspensionModel;
        $newRequest->student_id = $student_id;
        $newRequest->start_date = $request->start_date;
        $newRequest->end_date = $request->end_date;
        $newRequest->class_id = $request->class_id;
        $newRequest->reason = !empty($request->reason) ? $request->reason : ' ';
        $newRequest->status = 1;
        $newRequest->save();

        return redirect('vStudent/suspension/list')->with('success', 'Yêu cầu bảo lưu đã được gửi đi.');
    }

    public function cancelRequest($request_id, Request $request)
    {
        $getRequest = SuspensionModel::getSingle($request_id);
        $json['success'] = false;
        if (!empty($getRequest)) {
            $getRequest->status =  3;
            $getRequest->save();
            $json['success'] = true;
        }
        echo json_encode($json);
    }

    public function acceptRequest($request_id)
    {
        $getSuspension = SuspensionModel::getSuspension($request_id)->get();
        $data['header_title'] = 'Yêu cầu bảo lưu';
        $data['getSuspension'] = $getSuspension[0];
        return view('admin.suspension.accept', ['data' => $data]);
    }

    public function comeback($request_id)
    {
        $getSuspension = SuspensionModel::getSuspension($request_id)->get();
        $getNotMyClass = EnrollmentModel::getNotMyClass($getSuspension[0]->student_id);
        $data['header_title'] = 'Yêu cầu bảo lưu';
        $data['getSuspension'] = $getSuspension[0];
        $data['getNotMyClass'] = $getNotMyClass;

        return view('admin.suspension.comeback', $data);
    }



    public function PostComeback($request_id, Request $request)
    {
        $getRequest = SuspensionModel::getSingle($request_id);
        if (!empty($getRequest)) {
            $getRequest->status =  4; // Đã quay lại sau bảo lưu
            $getRequest->save();
            $class_id = $request->class_id;
            $enroll = EnrollmentModel::getByStudentAndClass($getRequest->student_id, $getRequest->class_id);
            if (empty($enroll)) {

                $new = new EnrollmentModel;
                $new->student_id = $getRequest->student_id;
                $new->class_id = $class_id;
                $new->enrollment_date = now();
                $new->save();
            }
            if ($getRequest->amount > 0) {
                $paid_amount = StudentAddFeesModel::getPaidAmount($getRequest->student_id, $class_id);
                $getStudent = ClassModel::single($class_id);
                $remaing = $getStudent->amount - $paid_amount;
                $payment = new StudentAddFeesModel;
                $payment->student_id = $getRequest->student_id;
                $payment->class_id = $class_id;
                $payment->paid_amount = $getRequest->amount;
                $payment->remaining_amount = $remaing - $getRequest->amount;
                $payment->total_amount = $remaing;
                $payment->payment_type = 1;
                $payment->remark = 'Đóng bởi tiền bảo lưu còn lại trước khi bảo lưu';
                $payment->created_by = Auth::user()->id;
                $payment->is_paid = 1;
                $payment->save();
            }
            return redirect('vAdmin/suspension/list')->with('success', 'Chuyển học sinh sang lớp mới thành công!');
        } else {
            abort(404);
        }
    }



    public function PostAcceptRequest($request_id, Request $request)
    {
        $amount = $request->input('amount');
        $getRequest = SuspensionModel::getSingle($request_id);
        if (!empty($getRequest)) {
            $getRequest->status =  2;
            $getRequest->amount = $amount;
            $getRequest->save();
            $enroll = EnrollmentModel::getByStudentAndClass($getRequest->student_id, $getRequest->class_id);
            if (!empty($enroll)) {
                $enroll->delete();
            }
            return redirect('vAdmin/suspension/list')->with('success', 'Xác nhận yêu cầu bảo lưu thành công!');
        } else {
            abort(404);
        }
    }
}
