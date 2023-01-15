<?php

require_once(__DIR__ . '/bootstrap/app.php');

use App\Http\Controllers\MessageController;

$messageController = new MessageController();

$messageController->sendMessage();
