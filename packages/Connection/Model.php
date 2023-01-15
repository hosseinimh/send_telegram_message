<?php

namespace Packages\Connection;

use Exception;
use ReflectionMethod;

abstract class Model
{
    private Db $db;
    protected string $tblName;
    protected mixed $result;

    protected function __construct($tblName)
    {
        $this->tblName = $tblName;
        $this->db = Db::getInstance();
    }

    public function next(): mixed
    {
        try {
            return mysqli_fetch_array($this->result);
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }

    protected function getRecord(string $query): mixed
    {
        return $this->onSelectQuery($query);
    }

    protected function createRecord(array $data): int
    {
        [$keys, $values] = $this->prepareCreateItems($data);
        $query = sprintf('INSERT INTO `%s` (%s) VALUES (%s)', $this->tblName, $keys, $values);
        $insertedId = 0;

        if ($this->onExecuteQuery($query)) {
            $insertedId = intval($this->db->insert_id);
        }

        return $insertedId;
    }

    protected function updateRecord(array $data, string  $where = ''): bool
    {
        $subQuery = $this->prepareUpdateItems($data);
        $where = $where === '' ? '' : ' WHERE ' . $where;
        $query = sprintf('UPDATE `%s` SET %s %s', $this->tblName, $subQuery, $where);

        return $this->onExecuteQuery($query);
    }

    protected function onExecuteQuery(string $query): bool
    {
        try {
            $this->db->query($query);

            return $this->db->affected_rows > 0 ? true : false;
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return false;
    }

    private function onSelectQuery(string $query): mixed
    {
        try {
            $this->result = $this->db->query($query);
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }

    private function prepareCreateItems(array $data): array
    {
        [$keyItems, $valueItems, $valuesCount] = $this->prepareItems($data);

        $i = 0;
        $keys = '';

        foreach ($keyItems as $key) {
            $keys .= sprintf('`%s`', $key) . ((++$i < $valuesCount) ? ',' : '');
        }

        $i = 0;
        $values = '';

        foreach ($valueItems as $value) {
            $values .= (is_null($value) ? 'NULL' : (is_string($value) ? sprintf('%s', '\'' . $value . '\'') : sprintf('%s', $value))) . ((++$i < $valuesCount) ? ',' : '');
        }

        return [$keys, $values];
    }

    private function prepareUpdateItems(array $data): string
    {
        [$keyItems, $valueItems, $valuesCount] = $this->prepareItems($data);
        $subQuery = '';

        for ($i = 0; $i < $valuesCount; $i++) {
            $subQuery .= $keyItems[$i] . '=';
            $subQuery .= is_null($valueItems[$i]) ? 'NULL' : (is_string($valueItems[$i]) ? '\'' . $valueItems[$i] . '\'' : $valueItems[$i]);
            $subQuery .= $i + 1 < $valuesCount ? ',' : '';
        }

        return $subQuery;
    }

    private function prepareItems(array $data): array
    {
        $keyItems = array_keys($data);
        $valueItems = array_values($data);
        $keysCount = count($keyItems);
        $valuesCount = count($valueItems);

        if ($keysCount !== $valuesCount) {
            throw new Exception('Keys count is not the same as values count.');
        }

        for ($i = 0; $i < $valuesCount; $i++) {
            $valueItems[$i] = htmlspecialchars(trim($valueItems[$i]));
        }

        return [$keyItems, $valueItems, $valuesCount];
    }

    public function __call(string $name, array|null $arguments): mixed
    {
        try {
            if (is_callable([$this, $name])) {
                $reflection = new ReflectionMethod($this, $name);

                return ($reflection->isPublic() || $reflection->isProtected()) ? call_user_func_array([$this, $name], $arguments) : null;
            }
        } catch (Exception $e) {
            printOutput($e->getMessage());
        }

        return null;
    }
}
