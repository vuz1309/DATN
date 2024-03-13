<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\WeekModel;
use Illuminate\Http\Request;

class ClassTimeableController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = 'Thời khóa biểu';
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->class_id))
            $data['getSubject'] = ClassSubjectModel::mySubject($request->class_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $value) {
            $dataW = [];
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;

            $week[] = $dataW;
        }
        $data['week'] = $week;
        return view("admin.class_timeable.list", $data);
    }

    public function getSubject(Request $request)
    {
        $getSubject = ClassSubjectModel::mySubject($request->class_id);
        $html = "<option value = ''>Chọn môn học</option>";
        foreach ($getSubject as $subject) {
            $html .= "<option value = '" . $subject->subject_id . "'>" . $subject->subject_name . "</option>";
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
}
