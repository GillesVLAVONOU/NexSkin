<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index(): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();
        $messageModel = new ContactMessage();

        $stats = [
            'total_projects' => $projectModel->countAll(),
            'published_projects' => $projectModel->countByStatus('published'),
            'draft_projects' => $projectModel->countByStatus('draft'),
            'total_categories' => $categoryModel->count(),
            'message_counts' => $messageModel->getStatusCounts(),
        ];

        $recentProjects = $projectModel->getAll(5);
        $recentMessages = $messageModel->getAll('', 5);

        $this->viewAdmin('dashboard.index', [
            'pageTitle' => 'Dashboard - Admin NexSkin',
            'stats' => $stats,
            'recentProjects' => $recentProjects,
            'recentMessages' => $recentMessages,
        ]);
    }
}
