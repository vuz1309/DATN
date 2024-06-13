<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PaymentMoel;

use Illuminate\Support\Facades\Config;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

class VnPayModel extends PaymentMoel
{
    use HasFactory;

    public function buildQuery($params)
    {

        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $params['amount']; // Số tiền thanh toán
        $student_fee_id = $params['id']; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $params['bankCode']; //Mã phương thức thanh toán
        $vnp_IpAddr = "123.123.123.123"; //IP Khách hàng thanh toán

        $vnp_TmnCode = config('vnPay.vnp_TmnCode');
        $vnp_HashSecret = config('vnPay.vnp_HashSecret');
        $vnp_Url = config('vnPay.vnp_Url');
        if (!empty($params['ReturnURL'])) {
            $vnp_Returnurl = $params['ReturnURL'];
        } else {
            $vnp_Returnurl = config('vnPay.vnp_Returnurl');
        }
        $vnp_apiUrl = config('vnPay.vnp_apiUrl');
        $apiUrl = config('vnPay.apiUrl');

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD - học sinh nộp học phí:" . $vnp_TxnRef . "|" . $student_fee_id,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }
}
