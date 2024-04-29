<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAddFeesModel extends Model
{
    use HasFactory;

    protected $table = 'student_add_fees';

    public static function getSingle($id)
    {
        return self::find($id);
    }
    public static function getFees($id)
    {
        return self::select('student_add_fees.*', 'class.fee', 'users.name as created_name')
            ->join('class', 'class.id', '=', 'student_add_fees.class_id')
            ->join('users', 'users.id', '=', 'student_add_fees.created_by', 'left')
            ->where('student_add_fees.student_id', '=', $id)
            ->where('student_add_fees.is_paid', '=', 1)
            ->get();
    }

    public static function getPaidAmount($student_id, $class_id)
    {
        return self::where('student_add_fees.student_id', '=', $student_id)
            ->where('student_add_fees.class_id', '=', $class_id)
            ->where('student_add_fees.is_paid', '=', 1)
            ->sum('student_add_fees.paid_amount');
    }
}
