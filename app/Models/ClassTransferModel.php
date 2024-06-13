<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

/**
 * Yêu cầu chuyển lớp
 */
class ClassTransferModel extends Model
{
    use HasFactory;
    protected $table = 'class_transfers';

    static public function getMyRequest($student_id)
    {
        $return = self::select('class_transfers.*', 'fromClass.name as from_class_name', 'toClass.name as to_class_name')
            ->join('class as fromClass', 'fromClass.id', '=', 'class_transfers.from_class_id')
            ->join('class as toClass', 'toClass.id', '=', 'class_transfers.to_class_id')
            ->where('class_transfers.student_id', '=', $student_id)
            ->orderBy('class_transfers.id', 'desc');


        return $return->paginate(15);
    }
    static public function getTransfers()
    {
        $return = self::select('class_transfers.*', 'fromClass.name as from_class_name', 'toClass.name as to_class_name', 'users.name as student_name', 'users.last_name as student_last_name')
            ->join('users', 'users.id', '=', 'class_transfers.student_id')
            ->join('class as fromClass', 'fromClass.id', '=', 'class_transfers.from_class_id')
            ->join('class as toClass', 'toClass.id', '=', 'class_transfers.to_class_id');

        if (!empty(Request::get('status'))) {
            $return = $return->where('class_transfers.status', 'LIKE', '%' . Request::get('status') . '%');
        }

        return $return->orderBy('class_transfers.id', 'desc')->paginate(15);
    }
    static public function getSingle($request_id)
    {
        $return = self::find($request_id);
        return $return;
    }
}
