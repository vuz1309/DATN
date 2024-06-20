<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PaymentMoel;

class PaypalModel extends PaymentMoel
{
    use HasFactory;

    public function buildQuery($params)
    {

        $query = array();
        $query['business'] = $params['paypalId'];
        $query['cmd'] = '_xclick';
        $query['item_name'] = "Học sinh đóng học phí";
        $query['no_shipping'] = '1';
        $query['item_number'] = $params['item_number'];
        $query['amount'] = $params['amount'];
        $query['currency'] = 'VND';
        $query['cancel_return'] = url('vStudent/paypal/payment_cancel');
        $query['return'] = url('vStudent/paypal/payment_success');

        $query_string = http_build_query($query);
        return $query_string;
    }
}
