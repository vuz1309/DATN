<?php

namespace App\Models;

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
}
