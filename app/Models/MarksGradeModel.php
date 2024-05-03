<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class MarksGradeModel extends Model
{
    use HasFactory;
    protected $table = 'marks_grade';

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        $return =  self::select('marks_grade.*', 'users.name as created_by_name', 'users.last_name as created_by_last_name')
            ->join('users', 'users.id', '=', 'marks_grade.created_by', 'left');

        if (!empty(Request::get('name'))) {
            $return = $return->where('marks_grade.name', 'LIKE', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->where('marks_grade.created_at', '=', Request::get('date'));
        }
        return $return->get();
    }
    static public function getGrade($percent)
    {
        if ($percent >= 10) {
            $percentTemp = 11;
        } else {
            $percentTemp = $percent;
        }
        $return =  self::select('marks_grade.*')
            ->where('percent_from', '<=', $percent)
            ->where('percent_to', '>', $percentTemp)
            ->first();
        if (!empty($return)) {
            return $return->name;
        } else {
            return 'Chưa xác định';
        }
    }
}
