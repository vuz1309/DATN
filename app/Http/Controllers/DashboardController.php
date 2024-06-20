<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\StudentAddFeesModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Tổng quan';

        if (Auth::user()->user_type == 1) {
            $data['TotalStudent'] = User::getTotalUsers(3);
            $data['TotalTeacher'] = User::getTotalUsers(2);
            $data['TotalAdmin'] = User::getTotalUsers(1);
            $data['TotalParent'] = User::getTotalUsers(4);
            $data['getTotalTodayFees'] = StudentAddFeesModel::getTotalTodayFees();
            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees();
            $data['TotalClass'] = ClassModel::getTotal();
            $data['TotalSubject'] = SubjectModel::getTotal();
            return view('vAdmin/dashboard', $data);
        } else if (Auth::user()->user_type == 2) {
            $data['TotalStudent'] = User::getTeacherStudentCount(Auth::user()->id);
            // $data['TotalClass'] = AssignClassTeacherModel::getMyClassAsignCount(Auth::user()->id);
            $data['TotalSubject'] = AssignClassTeacherModel::getMyClassSubjectCount(Auth::user()->id);
            return view('vTeacher/dashboard', $data);
        } else if (Auth::user()->user_type == 3) {


            $data['getTotalFees'] = StudentAddFeesModel::getStudentFees(Auth::user()->id);
            $data['TotalHomework'] = HomeworkModel::getTotal(Auth::user()->class_id, Auth::user()->id);
            $data['TotalHomeworkSubmitted'] = HomeworkSubmitModel::getTotal(Auth::user()->id);

            $data['TotalSubject'] = SubjectModel::getStudentSubjectCount(Auth::user()->id);
            return view('vStudent/dashboard', $data);
        } else if (Auth::user()->user_type == 4) {
            return view('vParent/dashboard', $data);
        }
    }
}
