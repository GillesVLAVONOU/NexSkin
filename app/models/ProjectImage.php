<?php

namespace App\Models;

use App\Core\Model;

class ProjectImage extends Model
{
    protected string $table = 'project_images';

    public function getByProject(int $projectId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM project_images WHERE project_id = ? ORDER BY sort_order ASC",
            [$projectId]
        );
    }

    public function createImage(int $projectId, string $imagePath, ?string $altText = '', int $sortOrder = 0): int
    {
        return $this->create([
            'project_id' => $projectId,
            'image_path' => $imagePath,
            'alt_text' => $altText,
            'sort_order' => $sortOrder,
        ]);
    }

    public function deleteByProject(int $projectId): bool
    {
        return $this->db->delete('project_images', 'project_id = ?', [$projectId]);
    }

    public function reorder(array $ids): bool
    {
        foreach ($ids as $position => $id) {
            $this->db->query(
                "UPDATE project_images SET sort_order = ? WHERE id = ?",
                [$position, $id]
            );
        }
        return true;
    }
}
