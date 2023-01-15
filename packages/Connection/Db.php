<?php

namespace Packages\Connection;

use App\Providers\Singleton;
use mysqli;
use Exception;

class Db extends Singleton
{
    private mysqli $mysqli;
    private string $host;
    private string $username;
    private string $password;
    private string $db;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->db = DB_NAME;

        $this->connect();
    }

    public function connect()
    {
        try {
            $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->db);

            if ($this->mysqli->connect_errno) {
                throw new Exception('Connection error. ' . mysqli_connect_error());
            }

            $this->mysqli->set_charset("utf8mb4");

            return true;
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return false;
    }

    public function __call(string $name, array|null $arguments)
    {
        try {
            return is_callable([$this->mysqli, $name]) ? call_user_func_array([$this->mysqli, $name], $arguments) : null;
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }

    public function __get(string $name)
    {
        try {
            return $this->mysqli->$name;
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }
}
