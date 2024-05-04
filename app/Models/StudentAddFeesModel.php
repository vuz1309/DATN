<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

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
            ->orderBy('student_add_fees.id', 'desc')
            ->get();
    }
    public static function getRecord($remove_paging = false)
    {
        $return =  self::select('student_add_fees.*', 'class.fee', 'users.name as created_name', 'class.name as class_name', 'student.name as student_name', 'student.last_name as student_last_name', 'student.admission_number as code')
            ->join('class', 'class.id', '=', 'student_add_fees.class_id')
            ->join('users', 'users.id', '=', 'student_add_fees.created_by', 'left')
            ->join('users as student', 'student.id', '=', 'student_add_fees.student_id')
            ->where('student_add_fees.is_paid', '=', 1)
            ->orderBy('student_add_fees.id', 'desc');

        if (!empty(Request::get('name'))) {
            $return = $return->where(function ($query) {
                $query->where('student.name', 'like', Request::get('name'))
                    ->orWhere('student.last_name', 'like', Request::get('name'));
            });
        }
        if (!empty(Request::get('class_id'))) {
            $return = $return->where('class.id', '=', Request::get('class_id'));
        }
        if ($remove_paging === true) {
            return $return->get();
        } else
            return $return->paginate(20);
    }

    public static function getPaidAmount($student_id, $class_id)
    {
        return self::where('student_add_fees.student_id', '=', $student_id)
            ->where('student_add_fees.class_id', '=', $class_id)
            ->where('student_add_fees.is_paid', '=', 1)
            ->sum('student_add_fees.paid_amount');
    }

    public static function getTotalTodayFees()
    {
        return self::where('student_add_fees.is_paid', '=', 1)
            ->whereDate('student_add_fees.created_at', '=', date('Y-m-d'))
            ->sum('student_add_fees.paid_amount');
    }
    public static function getTotalFees()
    {
        return self::where('student_add_fees.is_paid', '=', 1)
            ->sum('student_add_fees.paid_amount');
    }

    public static function getStudentFees($id)
    {
        return self::where('student_add_fees.is_paid', '=', 1)
            ->where('student_add_fees.student_id', '=', $id)
            ->sum('student_add_fees.paid_amount');
    }
}
