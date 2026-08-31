<?php

namespace App\Models;

use App\Core\Model;

class Project extends Model
{
    protected string $table = 'projects';

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.slug = ?",
            [$slug]
        );
    }

    public function findWithDetails(int $id): ?array
    {
        $project = $this->db->fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.id = ?",
            [$id]
        );

        if ($project) {
            $project['images'] = $this->db->fetchAll(
                "SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order ASC",
                [$id]
            );
        }

        return $project;
    }

    public function findBySlugWithDetails(string $slug): ?array
    {
        $project = $this->findBySlug($slug);
        if ($project) {
            $project['images'] = $this->db->fetchAll(
                "SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order ASC",
                [$project['id']]
            );
        }
        return $project;
    }

    public function getPublished(int $limit = 0, int $offset = 0, ?int $categoryId = null): array
    {
        $where = "p.status = 'published'";
        $params = [];

        if ($categoryId) {
            $where .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }

        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug
                FROM projects p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE {$where}
                ORDER BY p.featured DESC, p.sort_order ASC, p.project_date DESC";

        if ($limit > 0) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function countPublished(?int $categoryId = null): int
    {
        $where = "status = 'published'";
        $params = [];

        if ($categoryId) {
            $where .= " AND category_id = ?";
            $params[] = $categoryId;
        }

        return $this->count($where, $params);
    }

    public function getFeatured(int $limit = 3): array
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published' AND p.featured = 1
             ORDER BY p.sort_order ASC, p.project_date DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getRecent(int $limit = 6): array
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published'
             ORDER BY p.project_date DESC, p.id DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getRelated(int $categoryId, int $currentId, int $limit = 3): array
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published' AND p.category_id = ? AND p.id != ?
             ORDER BY RAND()
             LIMIT ?",
            [$categoryId, $currentId, $limit]
        );
    }

    public function getPrevious(?int $currentId): ?array
    {
        return $this->db->fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published' AND p.id < ?
             ORDER BY p.id DESC
             LIMIT 1",
            [$currentId]
        );
    }

    public function getNext(?int $currentId): ?array
    {
        return $this->db->fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE p.status = 'published' AND p.id > ?
             ORDER BY p.id ASC
             LIMIT 1",
            [$currentId]
        );
    }

    public function getAll(int $limit = 0, int $offset = 0): array
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name
             FROM projects p
             LEFT JOIN categories c ON p.category_id = c.id
             ORDER BY p.id DESC
             " . ($limit > 0 ? "LIMIT {$limit} OFFSET {$offset}" : "")
        );
    }

    public function countAll(): int
    {
        return $this->count();
    }

    public function countByStatus(string $status): int
    {
        return $this->count('status = ?', [$status]);
    }
}
