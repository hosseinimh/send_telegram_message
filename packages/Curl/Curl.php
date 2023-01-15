<?php

namespace Packages\Curl;

use Exception;

class Curl
{
    private ?string $error;

    public function postRequest(string $url, array $postFields, string $contentType = 'application/json'): mixed
    {
        try {
            $this->error = null;
            $ch = curl_init($url);
            $postFields = $contentType === 'application/json' ? json_encode($postFields) : $postFields;

            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: $contentType"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);

            curl_close($ch);

            if (curl_errno($ch) > 0) {
                $this->error = curl_error($ch);

                return null;
            }

            return $result;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        return null;
    }

    public function errorMessage(): string|null
    {
        return $this->error;
    }
}
