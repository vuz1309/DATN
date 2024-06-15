<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
use Cache;

class SuspensionModel extends Model
{
    use HasFactory;
    protected $table = "suspensions";

    static public function getSuspensionStudents()
    {
        $return = self::select('suspensions.*', 'users.name', 'users.last_name', 'users.email', 'users.admission_number as student_id')
            ->join('users', 'users.id', '=', 'suspensions.student_id', 'left');

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('name'))) {
            $name = '%' . Request::get('name') . '%';
            $return = $return->where(function ($query) use ($name) {
                $query->where('users.name', 'like', $name)
                    ->orWhere('users.last_name', 'like', $name);
            });
        }
        if (!empty(Request::get('create_date'))) {
            $return = $return->where('suspensions.create_date', '=', Request::get('create_date'));
        }
        $return = $return->orderBy('suspensions.id', 'asc')->paginate(20);
        return $return;
    }

    static public function getMySuspensions($student_id)
    {
        $return = self::select('suspensions.*', 'users.name', 'users.last_name', 'users.email', 'users.admission_number as student_id')
            ->join('users', 'users.id', '=', 'suspensions.student_id')
            ->where('suspensions.student_id', '=', $student_id);

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('name'))) {
            $name = '%' . Request::get('name') . '%';
            $return = $return->where(function ($query) use ($name) {
                $query->where('users.name', 'like', $name)
                    ->orWhere('users.last_name', 'like', $name);
            });
        }
        if (!empty(Request::get('create_date'))) {
            $return = $return->where('suspensions.create_date', '=', Request::get('create_date'));
        }
        $return = $return->orderBy('suspensions.id', 'asc')->paginate(10);
        return $return;
    }



    static public function getSuspenSion($request_id)
    {
        $return = self::select('suspensions.*', 'class.name as class_name', 'class.fee', 'class.start_date as class_start_date', 'class.end_date as class_end_date', 'users.name', 'users.last_name', 'users.email', 'users.admission_number as student_id')
            ->join('class', 'class.id', '=', 'suspensions.class_id', 'left')
            ->join('users', 'users.id', '=', 'suspensions.student_id', 'left')
            ->where('suspensions.id', '=', $request_id);
        return $return;
    }


    static public function getSingle($request_id)
    {
        $return = self::find($request_id);
        return $return;
    }
}
