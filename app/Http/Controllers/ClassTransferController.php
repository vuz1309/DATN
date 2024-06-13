<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassTransferModel;
use App\Models\EnrollmentModel;
use App\Models\Transaction;
use App\Models\VnPayModel;
use Illuminate\Http\Request;
use Auth;

class ClassTransferController extends Controller
{
    public function student_list()
    {
        $student_id = Auth::user()->id;
        $data['header_title'] = 'Yêu cầu chuyển lớp';
        $getListTransfer = ClassTransferModel::getMyRequest($student_id);
        $data['listTransfer'] = $getListTransfer;
        return view('student.class_transfer.list', $data);
    }

    public function admin_list()
    {
        $data['header_title'] = 'Yêu cầu chuyển lớp';
        $getListTransfer = ClassTransferModel::getTransfers();
        $data['listTransfer'] = $getListTransfer;
        return view('admin.class_transfer.list', $data);
    }

    public function cancelRequest($request_id, Request $request)
    {
        $getTransfer = ClassTransferModel::getSingle($request_id);
        $json['success'] = false;
        if (!empty($getTransfer)) {
            $getTransfer->description =  $request->description;
            $getTransfer->status =  4;
            $getTransfer->save();
            $json['success'] = true;
        }
        echo json_encode($json);
    }

    public function acceptRequest($request_id)
    {
        $getTransfer = ClassTransferModel::getSingle($request_id);
        $data['header_title'] = 'Yêu cầu chuyển lớp';
        $data['getTransfer'] = $getTransfer;
        $data['getFromClass'] = ClassModel::single($getTransfer->from_class_id);
        $data['getToClass'] = ClassModel::single($getTransfer->to_class_id);
        return view('admin.class_transfer.accept', $data);
    }

    public function PostAcceptRequest($request_id, Request $request)
    {
        $getTransfer = ClassTransferModel::getSingle($request_id);
        if (!empty($getTransfer)) {
            $getTransfer->approved_by = Auth::user()->id;
            $getTransfer->amount = $request->amount;
            $getTransfer->description = $request->description;
            if (!empty($request->approved_date)) {
                $getTransfer->approved_date = now();
            } else
                $getTransfer->approved_date = $request->approved_date;

            if (empty($request->amount) || $request->amount <= 0) {
                $getTransfer->status = 3; // Chuyển lớp luôn
                $this->transferStudent($getTransfer);
            } else {
                $getTransfer->status = 2; // Chờ thanh toán
            }
            $getTransfer->save();
            return redirect('admin/class_transfers/admin_list')->with('success', 'Xác nhận yêu cầu chuyển lớp thành công!');
        } else {
            abort(404);
        }
    }
    private static function transferStudent($getTransfer)
    {
        $getEnroll = EnrollmentModel::getByStudentAndClass($getTransfer->student_id, $getTransfer->from_class_id);
        if (!empty($getTransfer)) {
            $getEnroll->class_id = $getTransfer->to_class_id;
            $getEnroll->save();
        }
    }
    public function removeRequest($request_id)
    {
        $getTransfer = ClassTransferModel::getSingle($request_id);

        if (!empty($getTransfer)) {
            $getTransfer->delete();
            return redirect('student/move')->with('success', 'Xóa yêu cầu thành công!');
        } else {
            abort(404);
        }
    }

    public function payFee($request_id)
    {
        $getTransfer = ClassTransferModel::getSingle($request_id);

        if (!empty($getTransfer)) {
            if ($getTransfer->amount <= 0) {
                $this->transferStudent($getTransfer);
                exit();
                return;
            }
            $params = array();
            $paypalService = new VnPayModel;


            $params['amount'] = $getTransfer->amount;
            $params['id'] = $getTransfer->id;
            $params['bankCode'] = '';
            $params['ReturnURL'] = url('student/payTransferFee');
            $query_string = $paypalService->buildQuery($params);

            header('Location: ' . $query_string);
            exit();
        } else {
            abort(404);
        }
    }

    public function addTransfer()
    {
        $student_id = Auth::user()->id;
        $data['header_title'] = 'Yêu cầu chuyển lớp';
        $getMyClass = EnrollmentModel::getMyClass($student_id);
        $getNotMyClass = EnrollmentModel::getNotMyClass($student_id);
        $data['getMyClass'] = $getMyClass;
        $data['getNotMyClass'] = $getNotMyClass;
        return view('student.class_transfer.add', $data);
    }

    public function PostAddTransfer(Request $request)
    {
        $student_id = Auth::user()->id;
        $newRequest = new ClassTransferModel;
        $newRequest->student_id = $student_id;
        $newRequest->request_date = $request->request_date;
        $newRequest->from_class_id = $request->from_class_id;
        $newRequest->to_class_id = $request->to_class_id;
        $newRequest->reason = $request->reason;
        $newRequest->status = 1;
        $newRequest->save();

        return redirect('student/move')->with('success', 'Yêu cầu chuyển lớp đã được gửi đi.');
    }

    public function payment_success(Request $request)
    {
        $trans = new Transaction;
        $trans->amount = $request->vnp_Amount;
        $trans->pay_date = $request->vnp_PayDate;
        $trans->transaction_no = $request->vnp_TransactionNo;
        $trans->description = $request->vnp_OrderInfo;
        $trans->order_id = $request->vnp_TxnRef;
        $trans->transaction_status = $request->vnp_TransactionStatus;
        $trans->save();
        if ($request->vnp_ResponseCode == "00" && $request->vnp_TransactionStatus == '00') { // Thanh toán thành công
            $items = explode('|', $request->vnp_OrderInfo);
            $request_id = end($items);
            $getTransfer = ClassTransferModel::getSingle($request_id);
            if (!empty($getTransfer)) {
                $getTransfer->status = 3;
                $getTransfer->save();

                // Chuyển học sinh sang lớp mới
                $getEnroll = EnrollmentModel::getByStudentAndClass($getTransfer->student_id, $getTransfer->from_class_id);
                if (!empty($getTransfer)) {
                    $getEnroll->class_id = $getTransfer->to_class_id;
                    $getEnroll->save();
                }
            }


            return redirect('student/move')->with('success', 'Thanh toán thành công, Bạn đã được chuyển sang lớp mới!');
        } else {
            return redirect('student/move')->with('error', 'Thanh toán chưa thành công!');
        }
    }
}
