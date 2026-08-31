<?php

namespace App\Core;

class Model
{
    protected Database $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }

    public function findAll(string $orderBy = 'id DESC', int $limit = 0, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        if ($limit > 0) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        return $this->db->fetchAll($sql);
    }

    public function where(string $column, mixed $value, string $operator = '='): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?",
            [$value]
        );
    }

    public function whereOne(string $column, mixed $value, string $operator = '='): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?",
            [$value]
        );
    }

    public function count(string $where = '1=1', array $params = []): int
    {
        return $this->db->count($this->table, $where, $params);
    }

    public function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function updateById(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update($this->table, $data, "{$this->primaryKey} = ?", [$id]);
    }

    public function deleteById(int $id): bool
    {
        return $this->db->delete($this->table, "{$this->primaryKey} = ?", [$id]);
    }

    public function paginate(string $where = '1=1', array $params = [], int $perPage = 12, int $page = 1, string $orderBy = 'id DESC'): array
    {
        $total = $this->count($where, $params);
        $totalPages = (int) ceil($total / $perPage);
        $page = max(1, min($page, max(1, $totalPages)));
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        $items = $this->db->fetchAll($sql, $params);

        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => $totalPages,
        ];
    }
}
