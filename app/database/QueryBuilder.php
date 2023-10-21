<?php

declare(strict_types=1);

namespace App\App\Database;

use PDO;

class QueryBuilder
{
    protected array $allowedTables = ['users', 'tasks'];

    protected array $allowedColumns = ['id', 'name', 'email', 'text', 'status', 'is_admin', 'login', 'password'];

    public function __construct(protected PDO $db)
    {
    }

    /**
     * @param string $table
     * @param string $login
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function findByLogin(string $table, string $login = '')
    {
        if (!in_array($table, $this->allowedTables, true)) {
            throw new \Exception('Invalid table name');
        }

        try {
            $query = $this->db->prepare("SELECT * FROM $table WHERE login = :login AND is_admin = 1 LIMIT 1;");
            $query->execute(['login' => $login]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param string|null $fetchClass
     * @param $id
     *
     * @throws \Exception
     *
     * @return false|array
     */
    public function first(string $table, string $fetchClass = null, $id = 0): false|array
    {
        if (!is_numeric($id) || !in_array($table, $this->allowedTables, true)) {
            throw new \Exception('Invalid table name or id');
        }

        $query = $this->db->prepare("SELECT * FROM $table WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        if ($fetchClass) {
            return $query->fetchAll(PDO::FETCH_CLASS, $fetchClass);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     *
     * @throws \Exception
     *
     * @return int
     */
    public function count(string $table): int
    {
        if (!in_array($table, $this->allowedTables, true)) {
            throw new \Exception('Invalid table name');
        }

        try {
            $query = $this->db->query("SELECT COUNT(*) FROM $table;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return (int) $query->fetchColumn();
    }

    /**
     * @param string $table
     * @param string|null $modelClass
     * @param string $sortField
     * @param string $order
     * @param int $page
     * @param int $limit
     *
     * @throws \Exception
     *
     * @return false|array
     */
    public function selectAll(
        string $table,
        string $modelClass = null,
        string $sortField = 'id',
        string $order = 'asc',
        int $page = 1,
        int $limit = 3
    ): false|array {
        if (!in_array($table, $this->allowedTables, true) || !in_array($sortField, $this->allowedColumns, true)) {
            throw new \Exception('Invalid table or column name');
        }

        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM $table ORDER BY $sortField $order LIMIT :limit OFFSET :offset";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);

        $statement->execute();

        if ($modelClass) {
            return $statement->fetchAll(PDO::FETCH_CLASS, $modelClass);
        }

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     * @param array $parameters
     *
     * @throws \Exception
     *
     * @return void
     */
    public function insert(string $table, array $parameters): void
    {
        if (!in_array($table, $this->allowedTables, true)) {
            throw new \RuntimeException('Invalid table name');
        }

        foreach ($parameters as $column => $value) {
            if (!in_array($column, $this->allowedColumns, true)) {
                throw new \Exception('Invalid column name: ' . $column);
            }
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $table
     * @param array $parameters
     * @param int $id
     *
     * @throws \Exception
     *
     * @return void
     */
    public function update(string $table, array $parameters, int $id = 0): void
    {
        // Check table against a whitelist
        if (!in_array($table, $this->allowedTables, true)) {
            throw new \Exception('Invalid table name');
        }

        // Check each input field against a whitelist of allowed fields
        foreach ($parameters as $column => $value) {
            if (!in_array($column, $this->allowedColumns)) {
                throw new \Exception('Invalid column name: ' . $column);
            }
        }

        $updateParams = array_map(static fn($param) => "$param = :$param", array_keys($parameters));
        $sql = sprintf("UPDATE %s SET %s WHERE id = :id", $table, implode(", ", $updateParams));

        $parameters['id'] = $id;

        try {
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $table
     * @param int $id
     *
     * @throws \Exception
     * @return void
     */
    public function delete(string $table, int $id = 0): void
    {
        if (!in_array($table, $this->allowedTables, true)) {
            throw new \Exception('Invalid table name');
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM $table WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
