<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class HomeworkModel extends Model
{
    use HasFactory;

    protected $table = 'homework';

    public static function getHomework()
    {
        $return =  self::select('homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete', '=', '0')
            ->orderBy('homework.id', 'desc');

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'like', '%' . Request::get('subject_name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('homework.created_at', '>=', Request::get('date'));
        }
        return $return->paginate(20);
    }
    public static function getTeacherHomework($teacher_id)
    {
        $return1 =  self::select('homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->join('class_subject', 'class_subject.subject_id', '=', 'homework.subject_id', 'left')
            ->where('homework.is_delete', '=', '0')
            ->where('class_subject.teacher_id', '=', $teacher_id)
            ->orderBy('homework.id', 'desc');

        $return2 =  self::select('homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'homework.class_id', 'left')
            ->where('homework.is_delete', '=', '0')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->orderBy('homework.id', 'desc');

        $return =  $return1->union($return2);
        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'like', '%' . Request::get('subject_name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('homework.created_at', '>=', Request::get('date'));
        }
        return $return->paginate(20);
    }

    public function getDocument()
    {
        if (!empty($this->document_file) && file_exists('upload/homework/' . $this->document_file)) {
            return url('upload/homework/' . $this->document_file);
        } else {
            return '';
        }
    }

    public static function getSingle($id)
    {
        return self::find($id);
    }
    public static function getStudentHomework($id, $student_id)
    {
        $return =  self::select('homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete', '=', '0')
            ->where('homework.class_id', '=', $id)
            ->whereNotIn('homework.id', function ($query) use ($student_id) {
                $query->select('submit_homework.homework_id')
                    ->from('submit_homework')
                    ->where('submit_homework.student_id', '=', $student_id);
            })
            ->orderBy('homework.id', 'desc');

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'like', '%' . Request::get('subject_name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('homework.created_at', '>=', Request::get('date'));
        }
        return $return->paginate(20);
    }
    public static function getTotal($id, $student_id)
    {
        $return =  self::select('homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('homework.is_delete', '=', '0')
            ->where('homework.class_id', '=', $id)
            ->whereNotIn('homework.id', function ($query) use ($student_id) {
                $query->select('submit_homework.homework_id')
                    ->from('submit_homework')
                    ->where('submit_homework.student_id', '=', $student_id);
            })
            ->orderBy('homework.id', 'desc');


        return $return->count();
    }
}
