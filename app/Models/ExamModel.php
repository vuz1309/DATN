<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ExamModel extends Model
{
    use HasFactory;

    protected $table = 'exam';


    static public function getRecord()
    {
        $return = self::select('exam.*', 'users.name as created_by_name')->join('users', 'users.id', '=', 'exam.created_by');


        if (!empty(Request::get('name'))) {
            $return = $return->where('exam.name', 'LIKE', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->where('exam.created_at', '=', Request::get('date'));
        }

        $return = $return->orderBy('exam.id', 'desc')
            ->where('exam.is_delete', '=', '0')
            ->paginate(50);

        return $return;
    }

    static public function getExam()
    {
        $return = self::select('exam.*')
            ->orderBy('exam.id', 'desc')
            ->where('exam.is_delete', '=', '0')
            ->get();

        return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
}
