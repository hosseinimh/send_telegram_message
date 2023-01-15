<?php

namespace Packages\Telegram;

use Packages\Curl\Curl;

class TelegramApi extends Curl
{
    private string $botToken;
    private string $channelId;
    private string $url;

    public function __construct()
    {
        $this->botToken = TELEGRAM_BOT_TOKEN;
        $this->channelId = TELEGRAM_CHANNEL_ID;
        $this->url = sprintf('https://api.telegram.org/bot%s/sendMessage', $this->botToken);
    }

    public function send(string $message): mixed
    {
        $postFields = [
            'chat_id' => $this->channelId,
            'text' => $message,
        ];

        return $this->postRequest($this->url, $postFields);
    }
}
