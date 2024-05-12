<?php

namespace App\Providers;

use Pusher\Pusher;
use Carbon\Carbon;

class MessageService
{
    protected $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'ap1',
            'useTLS' => true,
        ];

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
    }

    /**
     * Undocumented function
     *

     * @param [ChatModel] $data
     * @return void
     */
    public function sendPusherEventChat($data)
    {
        $data->sender_avatar = $data->getSender->getProfile();
        $data->file_path = $data->getFile();
        $data->diffForHumans = Carbon::parse($data->created_date)->diffForHumans();


        $this->pusher->trigger('message', 'chat', $data);
    }
}
