<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class EnrollmentModel extends Model
{
    use HasFactory;
    protected $table = "enrollments";

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getByStudentAndClass($student_id, $class_id)
    {
        return self::where('student_id', '=', $student_id)
            ->where('class_id', '=', $class_id)
            ->first();
    }

    static public function getMyClass($student_id)
    {
        return self::select('class.*')
            ->join('class', 'class.id', '=', 'enrollments.class_id')
            ->where('enrollments.student_id', '=', $student_id)
            ->where('class.end_date', '>', Carbon::today())
            ->get();
    }
    static public function getAllMyClass($student_id)
    {
        $return =  self::select('class.*')
            ->selectRaw('COUNT(enrollments.id) as total_enrollments')
            ->join('class', 'class.id', '=', 'enrollments.class_id')
            ->where('enrollments.student_id', '=', $student_id)
            ->orderBy('class.id', 'desc');

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'LIKE', '%' . Request::get('name') . '%');
        }
        return $return->get();
    }

    static public function getNotMyClass($student_id)
    {
        return ClassModel::select('class.*')->leftJoin('enrollments', function ($join) use ($student_id) {
            $join->on('class.id', '=', 'enrollments.class_id')
                ->where('enrollments.student_id', '=', $student_id);
        })
            ->whereNull('enrollments.class_id')
            ->where('class.end_date', '>', Carbon::today())
            ->get();
    }

    static public function getAmount($student_id)
    {
        return self::select('class.fee')
            ->join('class', 'class.id', '=', 'enrollments.class_id')
            ->where('enrollments.student_id', '=', $student_id)->get();
    }
}
