<?php

namespace App\Models;

use Exception;
use Packages\Connection\Model;

class Message extends Model
{
    protected string $tblName = 'tbl_messages';

    public function __construct()
    {
        parent::__construct($this->tblName);
    }

    public function get(int $id): mixed
    {
        try {
            $query = sprintf('SELECT * FROM `%s` WHERE id=%d LIMIT 0,1', $this->tblName, $id);

            $this->getRecord($query);

            return $this->next();
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }

    public function create(string $message): mixed
    {
        try {
            $data = [
                'message' => $message ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            return $this->createRecord($data);
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return false;
    }
}
