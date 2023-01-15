<?php

namespace App\Services;

use App\Models\Message;
use Packages\Telegram\TelegramApi;

class MessageService
{
    public function send(string $message): mixed
    {
        $msg = new Message();
        $id = $msg->create($message);

        $telegram = new TelegramApi();
        $result = $telegram->send($message);

        return ['record' => $id > 0 ? $msg->get($id) : null, 'telegram_result' => $result ?? $telegram->errorMessage()];
    }
}
