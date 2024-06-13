<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
