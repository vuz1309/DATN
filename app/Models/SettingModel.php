<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;
    protected $table = 'setting';

    public static function getSetting()
    {
        return self::find(1);
    }

    public function getProfile()
    {
        if (!empty($this->school_logo) && file_exists('upload/settings/' . $this->school_logo)) {
            return url('upload/settings/' . $this->school_logo);
        } else {
            return url('upload/profile/default.jpg');
        }
    }
}
