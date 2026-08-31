<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Project;
use App\Models\Category;

class ProjectController extends Controller
{
    public function index(): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();

        $categoryId = Request::query('category') ? (int) Request::query('category') : null;
        $page = max(1, (int) (Request::query('page') ?? 1));
        $perPage = 12;

        $total = $projectModel->countPublished($categoryId);
        $pagination = $this->setPagination($total, $perPage, $page);

        $projects = $projectModel->getPublished(
            $perPage,
            $pagination['offset'],
            $categoryId
        );

        $categories = $categoryModel->getAllOrdered();

        $this->view('projects.index', [
            'pageTitle' => 'Nos réalisations - NexSkin',
            'pageDescription' => 'Découvrez nos réalisations de personnalisation d\'ordinateurs portables.',
            'projects' => $projects,
            'categories' => $categories,
            'currentCategory' => $categoryId,
            'pagination' => $pagination,
        ]);
    }

    public function show(string $slug): void
    {
        $projectModel = new Project();

        $project = $projectModel->findBySlugWithDetails($slug);

        if (!$project || $project['status'] !== 'published') {
            http_response_code(404);
            require ROOT_PATH . '/app/views/errors/404.php';
            return;
        }

        $relatedProjects = $projectModel->getRelated(
            $project['category_id'],
            $project['id'],
            3
        );

        $prevProject = $projectModel->getPrevious($project['id']);
        $nextProject = $projectModel->getNext($project['id']);

        $this->view('projects.show', [
            'pageTitle' => $project['title'] . ' - NexSkin',
            'pageDescription' => $project['short_description'] ?? $project['title'],
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'prevProject' => $prevProject,
            'nextProject' => $nextProject,
        ]);
    }
}
