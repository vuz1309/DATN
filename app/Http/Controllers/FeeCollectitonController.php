<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\PaypalModel;
use App\Models\SettingModel;
use App\Models\StudentAddFeesModel;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VnPayModel;
use Illuminate\Http\Request;
use Auth;
use Session;
use Excel;
use App\Exports\ExportCollectFees;
use App\Exports\ExportTotalCollectFees;

class FeeCollectitonController extends Controller
{
    public function collect_fees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = 'Học phí';
        $users = User::getCollectFeeStudent();
        if (!empty($users)) {
            foreach ($users as $value) {
                $value->paid_amount = StudentAddFeesModel::getPaidAmount($value->id, $value->class_id);
            }
        }
        $data['getRecord'] = $users;
        return view('admin.fee.collect_fee', $data);
    }
    public function add_fees($id, Request $request)
    {
        $data['header_title'] = 'Học phí';
        $data['getStudent'] = User::getSingleClass($id);
        $data['getRecord'] = StudentAddFeesModel::getFees($id);
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($id, $data['getStudent']->class_id);

        return view('admin.fee.add_collect_fee', $data);
    }

    public function PostAddFee($id, Request $request)
    {

        $getStudent = User::getSingleClass($id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($id, $getStudent->class_id);
        $remaing = $getStudent->amount - $paid_amount;


        if ($remaing >= $request->amount) {
            $payment = new StudentAddFeesModel;
            $payment->student_id = $id;
            $payment->class_id = $getStudent->class_id;
            $payment->paid_amount = $request->amount;
            $payment->remaining_amount = $remaing - $request->amount;
            $payment->total_amount = $remaing;
            $payment->payment_type = $request->payment_type;
            $payment->remark = $request->remark;
            $payment->created_by = Auth::user()->id;
            $payment->is_paid = 1;

            $payment->save();
            return redirect()->back()->with('success', 'Nộp học phí thành công!');
        } else {
            return redirect()->back()->with('error', 'Đã nộp quá số học phí cần đóng!');
        }
    }

    public function student_fee_collection()
    {
        $student_id = Auth::user()->id;
        $data['header_title'] = 'Học phí';
        $data['getStudent'] = User::getSingleClass($student_id);
        $data['getRecord'] = StudentAddFeesModel::getFees($student_id);
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, Auth::user()->class_id);

        return view('student.fee.add_collect_fee', $data);
    }
    public function PostAddFeeStudent(Request $request)
    {
        $id = Auth::user()->id;
        $getStudent = User::getSingleClass($id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($id, $getStudent->class_id);
        $remaing = $getStudent->amount - $paid_amount;


        if ($remaing >= $request->amount) {

            $payment = new StudentAddFeesModel;
            $payment->student_id = $id;
            $payment->class_id = $getStudent->class_id;
            $payment->paid_amount = $request->amount;
            $payment->remaining_amount = $remaing - $request->amount;
            $payment->total_amount = $remaing;
            $payment->payment_type = $request->payment_type;
            $payment->remark = $request->remark;
            $payment->created_by = Auth::user()->id;
            $payment->is_paid = 0;
            $payment->save();

            if ($request->payment_type == 2) { // vnPay

                $params = array();
                $paypalService = new VnPayModel;


                $params['amount'] = $request->amount;
                $params['id'] = $payment->id;
                $params['bankCode'] = '';
                $query_string = $paypalService->buildQuery($params);

                header('Location: ' . $query_string);
                exit();
            }
        } else {
            return redirect()->back()->with('error', 'Đã nộp quá số học phí cần đóng!');
        }
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
            $fee_id = end($items);
            $fee = StudentAddFeesModel::getSingle($fee_id);
            $fee->is_paid = 1;
            $fee->save();


            return redirect('student/fee_collect')->with('success', 'Thanh toán thành công!');
        } else {
            return redirect('student/fee_collect')->with('error', 'Thanh toán chưa thành công!');
        }
    }

    public function payment_cancel(Request $request)
    {

        return redirect('student/fee_collect')->with('error', 'Thanh toán chưa thành công!');
    }
    public function fee_collect_report(Request $request)
    {
        $data['header_title'] = 'Báo cáo';
        $data['getRecord'] = StudentAddFeesModel::getRecord();

        $data['getClass'] = ClassModel::getClass();
        return view('admin.fee.report', $data);
    }

    public function ExportFeeCollectionReport(Request $request)
    {
        return Excel::download(new ExportCollectFees, 'Bao_cao_hoc_phi_' . date('d-m-Y')  . '.xlsx');
    }

    public function ExportFeeCollection()
    {
        return Excel::download(new ExportTotalCollectFees, 'Tong_hoc_phi_' . date('d-m-Y')  . '.xlsx');
    }

    public function delete_fee_collect($id)
    {
        $record = StudentAddFeesModel::getSingle($id);
        if (!empty($record)) {
            $record->is_paid = 0;
            $record->save();
            return redirect()->back()->with('success', 'Xóa thành công!');
        } else {
            abort(404);
        }
    }
}
