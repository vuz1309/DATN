<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class SubjectModel extends Model
{
    use HasFactory;
    protected $table = "subject";

    static public function getRecord()
    {
        $return = self::select('subject.*', 'users.name as created_by_name')
            ->leftJoin('users', 'users.id', 'subject.created_by')
            ->where('subject.is_delete', '=', 0);

        if (!empty(Request::get('name'))) {
            $return = $return->where('subject.name', 'LIKE', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->where('subject.created_at', '=', Request::get('date'));
        }

        if (!empty(Request::get('type'))) {
            $return = $return->where('subject.type', '=', Request::get('type'));
        }

        $return = $return->orderBy('subject.id', 'desc')
            ->paginate(20);

        return $return;
    }

    static public function getTotal()
    {
        $return = self::where('subject.is_delete', '=', 0)->count();



        return $return;
    }
    static public function single($id)
    {
        $return = self::find($id);

        return $return;
    }

    static public function getSubject()
    {
        $return = self::select('subject.*', 'users.name as created_by_name')
            ->leftJoin('users', 'users.id', 'subject.created_by')
            ->where('subject.status', '=', 0)
            ->where('subject.is_delete', '=', 0);
        $return = $return->orderBy('subject.id', 'desc')
            ->get();

        return $return;
    }

    static public function getSubjectByClass($class_id)
    {
        $return = self::select('subject.*', 'users.name as created_by_name')
            ->leftJoin('users', 'users.id', 'subject.created_by')
            ->join('class_subject', 'class_subject.subject_id', '=', 'subject.id')

            ->where('subject.status', '=', 0)
            ->where('class_subject.class_id', '=', $class_id)
            ->where('subject.is_delete', '=', 0);
        if (!empty(Request::get('name'))) {
            $return = $return->where('subject.name', 'LIKE', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->where('subject.created_at', '=', Request::get('date'));
        }

        if (!empty(Request::get('type'))) {
            $return = $return->where('subject.type', '=', Request::get('type'));
        }
        $return = $return->orderBy('subject.id', 'desc')
            ->paginate(10);

        return $return;
    }

    static public function getStudentSubject($student_id)
    {
        $return = self::select('subject.*', 'class.id as class_id', 'class.name as class_name')
            ->join('class_subject', 'class_subject.subject_id', '=', 'subject.id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->join('enrollments as er', 'er.class_id', '=', 'class_subject.class_id')
            ->where('er.student_id', '=', $student_id)
            ->where('subject.status', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->where('class.end_date', '>',  Carbon::today())
            ->where('subject.is_delete', '=', 0)
            ->orderBy('class.id', 'desc');
        return $return->get();
    }
    static public function getStudentSubjectCount($student_id)
    {
        $return = self::select('subject.*')
            ->join('class_subject', 'class_subject.subject_id', '=', 'subject.id')
            ->join('enrollments as er', 'er.class_id', '=', 'class_subject.class_id')
            ->where('er.student_id', '=', $student_id)
            ->where('subject.status', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0);
        return $return->count();
    }
}
