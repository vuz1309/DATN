<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class AssignClassTeacherModel extends Model
{
    use HasFactory;
    protected $table = 'assign_class_teacher';

    static public function getAlreadyFirst($class_id, $teacher_id)
    {
        return self::where('class_id', '=', $class_id)
            ->where('teacher_id', '=', $teacher_id)->first();
    }

    static public function getTeacherClass()
    {
        $return = self::select('assign_class_teacher.*', 'users.name as created_by_name', 'class.name as class_name', 'teachers.name as teacher_name', 'teachers.last_name as teacher_last_name')
            ->join('users', 'users.id', '=', 'assign_class_teacher.created_by', 'left')
            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('users as teachers', 'teachers.id', '=', 'assign_class_teacher.teacher_id')
            ->where('class.is_delete', '=', 0)
            ->where('teachers.is_delete', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0);

        if (!empty(Request::get('teacher_name'))) {
            $return = $return->where('teachers.name', 'LIKE', '%' . Request::get('teacher_name') . '%')
                ->orWhere('teachers.last_name', 'LIKE', '%' . Request::get('teacher_name') . '%');
        }

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'LIKE', '%' . Request::get('class_name') . '%');
        }

        if (!empty(Request::get('status'))) {
            $return = $return->where('assign_class_teacher.status', 'LIKE', '%' . Request::get('status') . '%');
        }

        $return = $return->orderBy('assign_class_teacher.id', 'desc')
            ->paginate(20);

        return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getByClass($class_id)
    {
        $return = self::select('assign_class_teacher.*')
            ->where('assign_class_teacher.class_id', '=', $class_id)->get();

        return $return;
    }

    static public function deleteOldAssign($class_id)
    {
        return self::where('class_id', '=', $class_id)->delete();
    }

    static public function getMyClassSubject($teacher_id)
    {
        $return = self::select('class.name as class_name', 'subject.name as subject_name', 'subject.type as subject_type')

            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'assign_class_teacher.class_id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('class.is_delete', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id);

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'LIKE', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'LIKE', '%' . Request::get('subject_name') . '%');
        }

        $return = $return->orderBy('assign_class_teacher.id', 'desc')
            ->paginate(20);

        return $return;
    }
}
