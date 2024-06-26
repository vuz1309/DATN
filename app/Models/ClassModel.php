<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\User;
use Request;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = "class";

    static public function getTotal()
    {
        $return = self::where('class.is_delete', '=', 0)->count();

        return $return;
    }
    static public function getRecord()
    {
        $return = self::select('class.*', 'users.name as created_by_name')
            ->selectRaw('COUNT(er.id) as total_enrollments')
            ->leftJoin('users', 'users.id', '=', 'class.created_by')
            ->leftJoin('enrollments as er', 'er.class_id', '=', 'class.id')
            ->where('class.is_delete', '=', 0)
            ->groupBy('class.id', 'users.name');

        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'LIKE', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('date'))) {
            $return = $return->where('created_at', '=', Request::get('date'));
        }

        $return = $return->orderBy('class.id', 'desc')
            ->paginate(20);

        return $return;
    }

    static public function single($id)
    {
        $return = ClassModel::find($id);

        return $return;
    }

    static public function getClass()
    {
        $return = self::select('class.*', 'users.name as created_by_name')
            ->leftJoin('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0);

        $return = $return->orderBy('class.id', 'desc')
            ->get();
        return $return;
    }

    public function getCountStudent()
    {
        $class_id = $this->id;
        $return = self::select('enrollments*')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0);

        return $class_id;
    }
}
