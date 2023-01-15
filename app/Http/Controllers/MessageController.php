<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Exception;

class MessageController
{
    public function sendMessage()
    {
        try {
            $messageService = new MessageService();

            $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;
            $result = $message ? $messageService->send($message) : null;
            $data = ['message' => $message, 'record' => $result['record'], 'telegram_result' => $result['telegram_result']];

            extract($data);

            include __DIR__ . '/../../../resources/views/index.php';
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }
    }
}
