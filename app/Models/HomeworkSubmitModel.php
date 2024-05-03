<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class HomeworkSubmitModel extends Model
{
    use HasFactory;
    protected $table = 'submit_homework';

    public static function getMySumited($student_id)
    {
        $return = self::select('submit_homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('homework', 'homework.id', '=', 'submit_homework.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('submit_homework.student_id', '=', $student_id)
            ->orderBy('submit_homework.id');

        return $return->paginate(20);
    }
    public static function getTotal($student_id)
    {
        $return = self::select('submit_homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('homework', 'homework.id', '=', 'submit_homework.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->where('submit_homework.student_id', '=', $student_id)
            ->orderBy('submit_homework.id');

        return $return->count();
    }

    public static function getHomeworkReport()
    {
        $return = self::select('submit_homework.*', 'class.name as class_name', 'subject.name as subject_name', 'users.name as student_name', 'users.last_name as student_last_name')
            ->join('homework', 'homework.id', '=', 'submit_homework.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->join('users', 'users.id', '=', 'submit_homework.student_id')
            ->orderBy('submit_homework.id');

        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('student_name'))) {
            $return = $return->where(function ($query) {
                $query->where('users.name', 'like',  '%' . Request::get('student_name') . '%')
                    ->orWhere('users.last_name', 'like',  '%' . Request::get('student_name') . '%');
            });
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'like', '%' . Request::get('subject_name') . '%');
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('homework.created_at', '>=', Request::get('date'));
        }

        return $return->paginate(20);
    }


    public static function getSubmitted($homework_id)
    {
        $return = self::select('submit_homework.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('homework', 'homework.id', '=', 'submit_homework.homework_id')
            ->join('class', 'class.id', '=', 'homework.class_id')
            ->join('subject', 'subject.id', '=', 'homework.subject_id')
            ->join('users', 'users.id', '=', 'submit_homework.student_id')
            ->where('submit_homework.homework_id', '=', $homework_id)
            ->orderBy('submit_homework.id');
        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('student_name'))) {
            $return = $return->where(function ($query) {
                $query->where('users.name', 'like',  '%' . Request::get('student_name') . '%')
                    ->orWhere('users.last_name', 'like',  '%' . Request::get('student_name') . '%');
            });
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
            return url('upload/homework_submit/' . $this->document_file);
        } else {
            return '';
        }
    }

    public static function getSingle($id)
    {
        return self::select('submit_homework.*')
            ->join('users', 'users.id', '=', 'submit_homework.student_id')
            ->where('submit_homework.id', '=', $id)
            ->first();
    }
    public function getHomework()
    {
        return $this->belongsTo(HomeworkModel::class, 'homework_id');
    }
    public function getStudent()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
