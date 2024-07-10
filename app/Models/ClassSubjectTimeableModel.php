<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTimeableModel extends Model
{
    use HasFactory;
    protected $table = 'class_subject_timeable';


    static public function getClassSujectTimable($class_id, $subject_id, $week_id)
    {
        $return = self::select('class_subject_timeable.*', 'class.name as class_name', 'class.start_date as class_start_date', 'class.end_date as class_end_date')
            ->join('class', 'class.id', '=', 'class_subject_timeable.class_id')
            ->where('class_subject_timeable.class_id', '=', $class_id)
            ->where('class_subject_timeable.subject_id', '=', $subject_id)
            ->where('class_subject_timeable.week_id', '=', $week_id)
            ->first();
        return $return;
    }
    static public function getStudentSubjectTimeable($class_id, $subject_id, $week_id)
    {
        $return = self::select('class_subject_timeable.*')
            ->where('class_subject_timeable.class_id', '=', $class_id)
            ->where('class_subject_timeable.subject_id', '=', $subject_id)
            ->where('class_subject_timeable.week_id', '=', $week_id)
            ->first();
        return $return;
    }
}
