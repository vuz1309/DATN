<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

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

    static public function getTeacherClass()
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
        if (!empty(Request::get('class_id'))) {
            $return = $return->where('users.class_id', '=',  Request::get('class_id'));
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
    static public function getStudents()
    {
        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
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
        if (!empty(Request::get('class_id'))) {
            $return = $return->where('users.class_id', '=',  Request::get('class_id'));
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

        $return = $return->orderBy('users.id', 'desc')->paginate(20);

        return $return;
    }


    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function getProfile()
    {
        if (!empty($this->profile_pic) && file_exists('upload/profile/' . $this->profile_pic)) {
            return url('upload/profile/' . $this->profile_pic);
        } else {
            return "";
        }
    }
    static public function getSearchStudents()
    {

        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
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

        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
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

        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', '0')
            ->where('assign_class_teacher.is_delete', '=', '0')
            ->where('users.is_delete', '=', 0);


        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('class_id'))) {
            $return = $return->where('users.class_id', '=', Request::get('class_id'));
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
}
