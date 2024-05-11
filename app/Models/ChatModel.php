<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Request;
use Auth;

class ChatModel extends Model
{
    use HasFactory;

    protected $table = 'chat';

    public static function getMessage($receiver_id, $sender_id, $page = 0)
    {
        $return = self::select('chat.*')
            ->where(function ($q) use ($receiver_id, $sender_id) {
                $q->where(function ($q) use ($receiver_id, $sender_id) {
                    $q->where('receiver_id', '=', $sender_id)
                        ->where('sender_id', '=', $receiver_id)
                        ->where('status', '>', '-1');
                })->orWhere(function ($q) use ($receiver_id, $sender_id) {
                    $q->where('sender_id', '=', $sender_id)
                        ->where('receiver_id', '=', $receiver_id)
                        ->where('status', '>', '-1');
                });
            })
            ->where(function ($query) {
                $query->where('message', '!=', '')
                    ->orWhereNotNull('file');
            })
            ->orderBy('id', 'asc')
            ->get();
        return $return;
    }

    function getSender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    function getReceiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    function getConnectUser()
    {
        return $this->belongsTo(User::class, 'connect_user_id');
    }

    public static function getChatUser($sender_id)
    {

        $getUserChat = self::select('chat.*', DB::raw('(CASE WHEN chat.sender_id = ' . $sender_id . ' THEN chat.receiver_id ELSE chat.sender_id END) AS connect_user_id'))
            ->join('users as sender', 'sender.id', '=', 'chat.sender_id')
            ->join('users as receiver', 'receiver.id', '=', 'chat.receiver_id');
        if (!empty(Request::get('search'))) {
            $search = Request::get('search');
            $getUserChat = $getUserChat->where(function ($query) use ($search) {
                $query->where('sender.name', 'like', '%' . $search . '%')
                    ->orWhere('sender.last_name', 'like', '%' . $search . '%')
                    ->orWhere('receiver.name', 'like', '%' . $search . '%')
                    ->orWhere('receiver.last_name', 'like', '%' . $search . '%');
            });
        }
        $getUserChat = $getUserChat->whereIn('chat.id', function ($query) use ($sender_id) {
            $query->selectRaw('max(chat.id)')->from('chat')
                ->where('chat.status', '<', 2)
                ->where(function ($query) use ($sender_id) {
                    $query->where('chat.sender_id', '=', $sender_id)
                        ->orWhere(function ($query) use ($sender_id) {
                            $query->where('chat.receiver_id', '=', $sender_id)
                                ->where('chat.status', '>', '-1');
                        });
                })
                ->groupBy(DB::raw('(CASE WHEN chat.sender_id = ' . $sender_id . ' THEN chat.receiver_id ELSE chat.sender_id END)'));
        })
            ->orderBy('chat.id', 'asc')
            ->get();

        $result = array();
        foreach ($getUserChat as $value) {
            $data = array();
            $data['id'] = $value->id;
            $data['message'] = $value->message;
            $data['created_date'] = $value->created_date;
            $data['user_id'] = $value->connect_user_id;
            $data['is_online'] = $value->getConnectUser->OnlineUser();
            $data['updated_at'] = $value->getConnectUser->updated_at;
            $data['name'] = $value->getConnectUser->name . ' ' . $value->getConnectUser->last_name;
            $data['profile_pic'] = $value->getConnectUser->getProfile();
            $data['messagecount'] = $value->CountMessage($value->connect_user_id, $sender_id);
            $result[] = $data;
        }
        return $result;
    }

    static public function CountMessage($connect_user_id, $user_id)
    {
        return self::where('sender_id', '=', $connect_user_id)
            ->where('receiver_id', '=', $user_id)
            ->where('status', '=', 0)->count();
    }

    public static function updateCount($sender_id, $receiver_id)
    {
        self::where('sender_id', '=', $receiver_id)
            ->where('receiver_id', '=', $sender_id)
            ->where('status', '=', '0')->update(['status' => '1']);
    }

    public function getFile()
    {
        if (!empty($this->file) && file_exists('upload/chat/' . $this->file)) {
            return url('upload/chat/' . $this->file);
        } else {
            return '';
        }
    }

    public static function getAllChatUserCount()
    {
        $user_id = Auth::user()->id;
        $return = self::select('chat.id')
            ->join('users as sender', 'sender.id', '=', 'chat.sender_id')
            ->join('users as receiver', 'receiver.id', '=', 'chat.receiver_id')
            ->where('chat.receiver_id', '=', $user_id)
            ->where('chat.status', '=', 0)
            ->count();
        return $return;
    }
}
