<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\SendEmailUserMail;
use Illuminate\Support\Facades\Mail;

class CommunicateController extends Controller
{
    public function send_email()
    {
        $data['header_title'] = 'Gửi email';
        $getUser = User::getAllUser();
        $json = array();
        foreach ($getUser as $value) {

            $type = '';
            if ($value->user_type == 2) {
                $type = 'Giáo viên';
            } else if ($value->user_type == 3) {
                $type = 'Học sinh';
            } else if ($value->user_type == 4) {
                $type = 'Phụ huynh';
            } else if ($value->user_type == 1) {
                $type = 'Admin';
            }
            $name = $value->name . ' ' . $value->last_name . ' - ' . $type;
            $json[] = ['id' => $value->id, 'text' => $name];
        }
        $data['getUser'] = $json;

        return view('admin.communicate.send_email', $data);
    }

    public function search_user(Request $request)
    {

        $json = array();
        if (!empty($request->search)) {
            $getUser = User::SearchUser($request->search);
            foreach ($getUser as $value) {

                $type = '';
                if ($value->user_type == 2) {
                    $type = 'Giáo viên';
                } else if ($value->user_type == 3) {
                    $type = 'Học sinh';
                } else if ($value->user_type == 4) {
                    $type = 'Phụ huynh';
                } else if ($value->user_type == 1) {
                    $type = 'Admin';
                }
                $name = $value->name . ' ' . $value->last_name . ' - ' . $type;
                $json[] = ['id' => $value->id, 'text' => $name];
            }
        }
        echo json_encode($json);
    }

    public function PostSendEmail(Request $request)
    {
        if (!empty($request->user_id)) {
            foreach ($request->user_id as $user_id) {
                $user = User::getSingle($user_id);
                $user->send_message = $request->message;
                $user->send_subject = $request->subject;

                Mail::to($user->email)->send(new SendEmailUserMail($user));
            }
        }

        if (!empty($request->message_to)) {
            foreach ($request->message_to as $user_type) {
                $getUser = User::getUser($user_type);
                foreach ($getUser as $user) {
                    $user->send_message = $request->message;
                    $user->send_subject = $request->subject;

                    Mail::to($user->email)->send(new SendEmailUserMail($user));
                }
            }
        }

        return redirect()->back()->with('success', 'Gửi email thành công!');
    }
}
