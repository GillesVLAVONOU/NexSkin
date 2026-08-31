<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'categories';

    public function findBySlug(string $slug): ?array
    {
        return $this->whereOne('slug', $slug);
    }

    public function getAllOrdered(): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, (SELECT COUNT(*) FROM projects WHERE category_id = c.id AND status = 'published') as project_count FROM categories c ORDER BY c.sort_order ASC, c.name ASC"
        );
    }

    public function getWithProjectCount(): array
    {
        return $this->db->fetchAll(
            "SELECT c.*, COUNT(p.id) as project_count FROM categories c LEFT JOIN projects p ON c.id = p.category_id GROUP BY c.id ORDER BY c.sort_order ASC"
        );
    }
}
