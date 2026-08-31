<?php

namespace App\Models;

use App\Core\Model;

class ContactMessage extends Model
{
    protected string $table = 'contact_messages';

    public function getNewCount(): int
    {
        return $this->count('status = ?', ['new']);
    }

    public function getAll(string $status = '', int $limit = 50, int $offset = 0): array
    {
        $where = '1=1';
        $params = [];

        if ($status) {
            $where = 'status = ?';
            $params[] = $status;
        }

        return $this->db->fetchAll(
            "SELECT * FROM contact_messages WHERE {$where} ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}",
            $params
        );
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->updateById($id, ['status' => $status]);
    }

    public function getStatusCounts(): array
    {
        return [
            'new' => $this->count('status = ?', ['new']),
            'in_progress' => $this->count('status = ?', ['in_progress']),
            'processed' => $this->count('status = ?', ['processed']),
            'archived' => $this->count('status = ?', ['archived']),
        ];
    }
}
