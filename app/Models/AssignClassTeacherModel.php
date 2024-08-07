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

    static public function getCalendarTeacher($teacher_id)
    {
        return ClassModel::select('class.name as class_name', 'subject.name as subject_name', 'week.name as week_name', 'week.fullcalendar_day as fullcalendar_day')
            // ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'class.id')
            ->join('class_subject_timeable', 'class_subject_timeable.subject_id', '=', 'class_subject.subject_id')
            ->join('subject', 'subject.id', '=', 'class_subject_timeable.subject_id')
            ->join('week', 'week.id', '=', 'class_subject_timeable.week_id')
            ->leftJoin('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->leftJoin('class_subject as class_subject2', 'class_subject2.class_id', '=', 'class.id')
            ->where(function ($q) use ($teacher_id) {
                $q->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                    ->orWhere('class_subject2.teacher_id', '=', $teacher_id);
            })
            ->get();
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
        $return1 = self::select('class.name as class_name', 'subject.name as subject_name', 'subject.type as subject_type', 'class.id as class_id', 'subject.id as subject_id')

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

        $return2 = ClassSubjectModel::select('class.name as class_name', 'subject.name as subject_name', 'subject.type as subject_type', 'class.id as class_id', 'subject.id as subject_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('class.is_delete', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0)->where('class_subject.teacher_id', '=', $teacher_id);

        $return = $return1->union($return2);
        if (!empty(Request::get('class_name'))) {
            $return = $return->where('class.name', 'LIKE', '%' . Request::get('class_name') . '%');
        }
        if (!empty(Request::get('subject_name'))) {
            $return = $return->where('subject.name', 'LIKE', '%' . Request::get('subject_name') . '%');
        }

        $return = $return->orderBy('class_name', 'desc')
            ->paginate(20);
        foreach ($return as $item) {
            $class_id = $item->class_id;
            $subject_id = $item->subject_id;
            $timeable = $item->getClassSubjectTimeable($class_id, $subject_id);
            // Thêm thông tin lịch vào từng bản ghi
            $item->timeable = $timeable;
        }
        return $return;
    }

    static public function getMyClassSubjectCount($teacher_id)
    {
        $return1 = self::select('class.name as class_name', 'subject.name as subject_name', 'subject.type as subject_type', 'class.id as class_id', 'subject.id as subject_id')

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

        $return2 = ClassSubjectModel::select('class.name as class_name', 'subject.name as subject_name', 'subject.type as subject_type', 'class.id as class_id', 'subject.id as subject_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->where('class.is_delete', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0)->where('class_subject.teacher_id', '=', $teacher_id);

        $return = $return1->union($return2);
        return $return->count();
    }

    static public function getMyClassSubjectGroup($teacher_id)
    {
        $return = self::select('class.name as class_name', 'class.id as class_id')

            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')

            ->where('class.is_delete', '=', 0)


            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)

            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('assign_class_teacher.class_id');

        $return2 = ClassSubjectModel::select('class.name as class_name', 'class.id as class_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->where('class.is_delete', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('class.status', '=', 0)
            ->where('class_subject.teacher_id', '=', $teacher_id);


        return $return->union($return2)->get();
    }

    static public function getClassOfTeacher($teacher_id)
    {
        $return = self::select('class.name as name', 'class.id as id')

            ->join('class', 'class.id', '=', 'assign_class_teacher.class_id')

            ->where('class.is_delete', '=', 0)


            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)

            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('assign_class_teacher.class_id');

        $return2 = ClassSubjectModel::select('class.name as class_name', 'class.id as class_id')
            ->join('class', 'class.id', '=', 'class_subject.class_id')
            ->where('class_subject.teacher_id', '=', $teacher_id)
            ->where('class.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->groupBy('class_subject.class_id');

        $result = $return->union($return2)->get();
        return $result;
    }

    // Lấy ra lịch của Khóa học trong ngày hiện tại
    public function getClassSubjectTimeable($class_id, $subject_id)
    {
        // Id ngày hiện tại trong tuần
        $weekId = date('N');

        $return = self::select('class_subject_timeable.*')
            ->join('class_subject_timeable', 'class_subject_timeable.class_id', '=', 'assign_class_teacher.class_id')
            ->where('assign_class_teacher.class_id', '=', $class_id)
            ->where('class_subject_timeable.subject_id', '=', $subject_id)
            ->where('class_subject_timeable.week_id', '=', $weekId + 1)
            ->first();
        return $return;
    }
}
