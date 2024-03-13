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

    static public function getRecord()
    {
        $return = self::select('class.*', 'users.name as created_by_name')
            ->leftJoin('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0);

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
}
