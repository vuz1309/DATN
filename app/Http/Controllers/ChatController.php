<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\ChatModel;
use App\Providers\MessageService as ProvidersMessageService;
use Str;






class ChatController extends Controller
{
    protected $messageService;

    public function __construct(ProvidersMessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    public function chat(Request $request)
    {
        $data['header_title'] = 'Trò chuyện';
        $sender_id = Auth::user()->id;
        if (!empty($request->receiver_id)) {
            $receiver_id = $request->receiver_id;

            ChatModel::updateCount(Auth::user()->id, $request->receiver_id);
            $data['getReceiver'] = User::getSingle($request->receiver_id);
            $data['getChat'] = ChatModel::getMessage($request->receiver_id, $sender_id, $request->page);
            $data['receiver_id'] = $receiver_id;
        } else {
            $data['receiver_id'] = '';
        }
        $data['getChatUser'] = ChatModel::getChatUser($sender_id);

        return view('chat.list', $data);
    }

    public function submit_message(Request $request)
    {
        $chat =  new ChatModel;
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->created_date = date('Y-m-d H:i:s');

        if (!empty($request->file('file_name'))) {
            $ext = $request->file('file_name')->getClientOriginalExtension();
            $file = $request->file('file_name');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/chat/', $filename);
            $chat->file = $filename;
        }
        $chat->save();


        $getChat = ChatModel::where('id', '=', $chat->id)->get();

        // Gửi sự kiện chat 
        $this->messageService->sendPusherEventChat($chat);

        return response()->json([
            'status' => true,
            'success' => view('chat._single', ['getChat' => $getChat])->render(),
        ], 200);
    }

    public function get_chat_windows(Request $request)
    {
        $receiver_id = $request->receiver_id;
        $getReceiver = User::getSingle($receiver_id);
        ChatModel::updateCount(Auth::user()->id, $request->receiver_id);
        $getChat = ChatModel::getMessage($receiver_id, Auth::user()->id);


        return response()->json([
            'status' => true,
            'success' => view('chat._message', [
                'getChat' => $getChat,
                'receiver_id' => $receiver_id,
                'getReceiver' => $getReceiver
            ])->render(),
        ], 200);
    }

    public function get_chat_search_user(Request $request)
    {

        $receiver_id = $request->receiver_id;
        $search = $request->search;
        $page = $request->page;
        if (!empty($receiver_id)) {
            $getReceiver = User::getSingle($receiver_id);
        }
        $sender_id = Auth::user()->id;
        $getChatUser = ChatModel::getChatUser($sender_id);

        return response()->json([
            'status' => true,
            'success' => view('chat._user', [
                'getChatUser' => $getChatUser,
                'getReceiver' => $getReceiver,
                'receiver_id' => $receiver_id
            ])->render(),
        ], 200);
    }
}
