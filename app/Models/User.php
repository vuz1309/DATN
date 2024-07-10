<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;
use Cache;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'class_id',
        'admission_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    static public function getEmailSingle($email)
    {
        return self::where('email', '=', $email)->first();
    }
    static public function getTokenSingle($remember_token)
    {
        return self::where('remember_token', '=', $remember_token)->first();
    }
    static public function getAdmin()
    {
        $return = self::select('users.*')->where('user_type', '=', 1)->where('is_delete', '=', 0);

        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->where('created_at', '=', Request::get('date'));
        }

        $return = $return->orderBy('id', 'desc')->paginate(20);

        return $return;
    }
    static public function getParents()
    {
        $return = self::select('users.*')->where('user_type', '=', 4)->where('is_delete', '=', 0);

        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->where('created_at', '=', Request::get('date'));
        }

        $return = $return->orderBy('id', 'desc')->paginate(20);

        return $return;
    }

    static public function getTotalUsers($user_type)
    {
        return self::select('users.id')
            ->where('user_type', '=', $user_type)
            ->where('is_delete', '=', 0)
            ->count();
    }

    static public function getAllTeacher()
    {
        $return = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.status', '=', 0)
            ->where('users.is_delete', '=', 0);


        $return = $return->orderBy('users.id', 'desc')->get();

        return $return;
    }
    static public function getTeachers()
    {
        $return = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0);

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
        if (!empty(Request::get('mobile_number'))) {
            $return = $return->where('users.mobile_number', '=',  Request::get('mobile_number'));
        }
        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', '=',  Request::get('gender'));
        }


        $return = $return->orderBy('users.id', 'desc')->paginate(20);

        return $return;
    }
    static public function getStudents($remove_paging = false)
    {
        $return = self::select('users.*',  'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', '=', 3)->where('users.is_delete', '=', 0);

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

        if (!empty(Request::get('caste'))) {
            $return = $return->where('users.caste', '=',  Request::get('caste'));
        }
        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', '=',  Request::get('gender'));
        }
        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', '=', Request::get('admission_date'));
        }
        if ($remove_paging == true) {
            return $return->orderBy('users.id', 'desc')->get();
        }
        $return = $return->orderBy('users.id', 'desc')->paginate(10);

        return $return;
    }

    static public function getStudentClass($class_id)
    {
        $return = self::select('users.*')
            ->join('enrollments as er', 'er.student_id', '=', 'users.id')
            ->where('er.class_id', '=', $class_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();

        return $return;
    }


    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getSingleClass($id)
    {

        $return =  EnrollmentModel::select(DB::raw('SUM(class.fee) as amount'))
            ->join('class', 'class.id', '=', 'enrollments.class_id')
            ->where('enrollments.student_id', '=', $id)
            ->groupBy('enrollments.student_id')
            ->first();
        return $return;
    }

    public function OnlineUser()
    {
        return Cache::has('OnlineUser' . $this->id);
    }
    public function getProfile()
    {
        if (!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)) {
            return url('upload/profile/' . $this->profile_pic);
        } else {
            return url('upload/profile/default.jpg');
        }
    }
    static public function getSearchStudents($remove_paging = null)
    {

        $return = self::select('users.*', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', '=', 3)
            ->whereNull('users.parent_id')
            ->where('users.is_delete', '=', 0);

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('id'))) {
            $return = $return->where('users.id', 'like', '%' . Request::get('id') . '%');
        }

        if (!empty(Request::get('name'))) {
            $name = '%' . Request::get('name') . '%';
            $return = $return->where(function ($query) use ($name) {
                $query->where('users.name', 'like', $name)
                    ->orWhere('users.last_name', 'like', $name);
            });
        }


        $return = $return->orderBy('users.id', 'desc')->limit(50)
            ->get();

        return $return;
    }

    static public function getMyStudent($parent_id)
    {

        $return = self::select('users.*', 'parent.name as parent_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0);



        $return = $return->orderBy('users.id', 'desc')->limit(50)
            ->get();

        return $return;
    }

    static public function getTeacherStudent($teacher_id)
    {

        $return = self::select('users.*', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('enrollments as er', 'er.student_id', '=', 'users.id')
            ->leftJoin('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'er.class_id')
            ->leftJoin('class_subject', 'class_subject.class_id', '=', 'er.class_id')
            ->where('users.user_type', '=', 3)

            ->where(function ($query) use ($teacher_id) {
                $query->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                    ->orWhere('class_subject.teacher_id', '=', $teacher_id);
            })
            // ->where('assign_class_teacher.status', '=', '0')
            // ->where('assign_class_teacher.is_delete', '=', '0')
            ->where('users.is_delete', '=', 0);


        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('roll_number'))) {
            $return = $return->where('users.roll_number', 'LIKE', '%' . Request::get('roll_number') . '%');
        }
        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', '=',  Request::get('admission_date'));
        }
        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', '=',  Request::get('gender'));
        }
        if (!empty(Request::get('name'))) {
            $name = '%' . Request::get('name') . '%';
            $return = $return->where(function ($query) use ($name) {
                $query->where('users.name', 'like', $name)
                    ->orWhere('users.last_name', 'like', $name);
            });
        }

        $return = $return->orderBy('users.id', 'desc')
            ->paginate(20);

        return $return;
    }
    static public function getTeacherStudentCount($teacher_id)
    {

        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('enrollments as er', 'er.student_id', '=', 'users.id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'er.class_id')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', '0')
            ->where('assign_class_teacher.is_delete', '=', '0')
            ->where('users.is_delete', '=', 0);



        return $return->count();
    }

    public static function getAttendance($student_id, $class_id, $subject_id, $attendance_date)
    {
        return StudentAttendanceModel::where('student_id', '=', $student_id)
            ->where('class_id', '=', $class_id)
            ->where('subject_id', '=', $subject_id)
            ->where('attendance_date', '=', $attendance_date)->first();
    }

    public static function SearchUser($search)
    {
        $return = self::select('users.*')
            ->where(function ($query) use ($search) {
                $query->where('users.last_name', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%');
            })
            ->where('is_delete', '=', 0)
            ->limit(10)
            ->get();

        return $return;
    }

    static public function getUser($user_type)
    {
        $return = self::select('users.*')
            ->where('user_type', '=', $user_type)
            ->where('is_delete', '=', 0)

            ->get();

        return $return;
    }
    static public function getAllUser()
    {
        $return = self::select('users.*')
            ->where('is_delete', '=', 0)
            ->get();

        return $return;
    }
    static public function getCollectFeeStudent($remove_paging = false)
    {

        $return = self::select('users.*')
            ->selectRaw('SUM(class.fee) as amount')
            ->join('enrollments as er', 'er.student_id', '=', 'users.id')
            ->join('class', 'class.id', '=', 'er.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->groupBy('users.id')
            ->orderBy('users.name', 'desc');

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

        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', '=',  Request::get('gender'));
        }
        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', '=', Request::get('admission_date'));
        }

        if ($remove_paging == true) {
            $return->get();
        }
        return $return->paginate(10);
    }

    public static function getSuggestionCode()
    {
        $return = self::select('users.admission_number')
            ->where('users.user_type', '=', 3)
            ->orderBy("users.id", "desc")
            ->first();


        $admissionNumber = $return->admission_number;
        $matches = [];
        preg_match('/([^0-9]*)([0-9]+)/', $admissionNumber, $matches);

        // $matches[1] chứa phần chữ
        // $matches[2] chứa phần số
        $text = $matches[1];
        $number = intval($matches[2]) + 1;
        $newCode = $text . $number;
        $lenOrigin =  strlen($admissionNumber);
        $lenNewCode = strlen($newCode);
        $other = $lenOrigin - $lenNewCode;

        // Padding số 0 vào $number
        $numberPadded = str_pad($number, $other, "0", STR_PAD_LEFT);

        $newCode = $text . $numberPadded;

        return $newCode;
    }

    public static function getUserNotChat($sender_id, $search)
    {
        $usersWithoutChat = User::whereNotIn('id', function ($query) use ($sender_id) {
            $query->select('sender_id')
                ->from('chat')
                ->where(function ($subQuery) use ($sender_id) {
                    $subQuery->where('sender_id', $sender_id)
                        ->orWhere('receiver_id', $sender_id);
                });
        })
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            })
            ->get();
        return $usersWithoutChat;
    }

    public function isInClass($class_id)
    {
        return EnrollmentModel::where('student_id', $this->id)
            ->where('class_id', $class_id)
            ->exists();
    }

    static public function getStudentNeedEnroll($class_id)
    {
        $return = self::select('users.*', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->selectRaw('IF(er.id IS NOT NULL, 1, 0) as isRegisted')
            ->leftJoin('users as parent', 'parent.id', '=', 'users.parent_id')
            ->leftJoin('enrollments as er', function ($join) use ($class_id) {
                $join->on('er.student_id', '=', 'users.id')
                    ->where('er.class_id', '=', $class_id);
            })
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id');

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
        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', '=',  Request::get('gender'));
        }
        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', '=', Request::get('admission_date'));
        }

        $return = $return->orderBy('users.id', 'desc')->paginate(15);

        return $return;
    }
}
