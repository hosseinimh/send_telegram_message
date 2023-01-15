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
            $message ? extract($messageService->send($message)) : 0;
            extract(['message' => $message, 'record' => $record ?? null, 'telegram_result' => $telegram_result ?? null]);

            include ABS_PATH . '/resources/views/index.php';
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }
    }
}
