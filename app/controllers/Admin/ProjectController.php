<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Project;
use App\Models\Category;
use App\Models\ProjectImage;

class ProjectController extends Controller
{
    public function index(): void
    {
        $projectModel = new Project();
        $page = max(1, (int) (Request::query('page') ?? 1));
        $perPage = 20;

        $total = $projectModel->countAll();
        $pagination = $this->setPagination($total, $perPage, $page);
        $projects = $projectModel->getAll($perPage, $pagination['offset']);

        $this->viewAdmin('projects.index', [
            'pageTitle' => 'Réalisations - Admin NexSkin',
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
    }

    public function create(): void
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllOrdered();

        $this->viewAdmin('projects.create', [
            'pageTitle' => 'Ajouter une réalisation - Admin NexSkin',
            'categories' => $categories,
            'errors' => Session::getFlash('errors'),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function store(): void
    {
        $data = Request::all();
        $uploadErrors = [];

        $validator = new \App\Core\Validator($data);
        $validator->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|numeric',
            'short_description' => 'max:500',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $data);
            $this->redirect('/admin/projects/create');
            return;
        }

        $projectModel = new Project();
        $slug = generateSlug($data['title']);

        // Ensure unique slug
        $existing = $projectModel->whereOne('slug', $slug);
        if ($existing) {
            $slug .= '-' . time();
        }

        $projectData = [
            'category_id' => (int) $data['category_id'],
            'title' => sanitizeInput($data['title']),
            'slug' => $slug,
            'short_description' => sanitizeInput($data['short_description'] ?? ''),
            'description' => $data['description'] ?? '',
            'project_date' => $data['project_date'] ?: date('Y-m-d'),
            'status' => $data['status'] ?? 'draft',
            'featured' => isset($data['featured']) ? 1 : 0,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];

        // Handle cover image
        if (Request::hasFile('cover_image')) {
            $uploadResult = uploadImage($_FILES['cover_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['cover_image'] = $uploadResult['path'];
            } else {
                $uploadErrors[] = $uploadResult['error'];
            }
        }

        // Handle before/after images
        if (Request::hasFile('before_image')) {
            $uploadResult = uploadImage($_FILES['before_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['before_image'] = $uploadResult['path'];
            } else {
                $uploadErrors[] = 'Image avant : ' . $uploadResult['error'];
            }
        }

        if (Request::hasFile('after_image')) {
            $uploadResult = uploadImage($_FILES['after_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['after_image'] = $uploadResult['path'];
            } else {
                $uploadErrors[] = 'Image après : ' . $uploadResult['error'];
            }
        }

        if ($uploadErrors) {
            Session::flash('errors', ['images' => $uploadErrors]);
            Session::flash('old', $data);
            $this->redirect('/admin/projects/create');
            return;
        }

        $projectId = $projectModel->create($projectData);

        // Handle gallery images
        $galleryErrors = $this->handleGalleryUpload($projectId);
        if ($galleryErrors) {
            Session::flash('error', implode(' ', $galleryErrors));
        }

        Session::flash('success', 'Réalisation créée avec succès.');
        $this->redirect('/admin/projects');
    }

    public function edit(int $id): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();

        $project = $projectModel->findWithDetails($id);
        if (!$project) {
            Session::flash('error', 'Réalisation introuvable.');
            $this->redirect('/admin/projects');
            return;
        }

        $categories = $categoryModel->getAllOrdered();

        $this->viewAdmin('projects.edit', [
            'pageTitle' => 'Modifier - ' . $project['title'] . ' - Admin NexSkin',
            'project' => $project,
            'categories' => $categories,
            'errors' => Session::getFlash('errors'),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function update(int $id): void
    {
        $data = Request::all();

        $validator = new \App\Core\Validator($data);
        $validator->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|numeric',
            'short_description' => 'max:500',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $data);
            $this->redirect("/admin/projects/edit/{$id}");
            return;
        }

        $projectModel = new Project();
        $projectData = [
            'category_id' => (int) $data['category_id'],
            'title' => sanitizeInput($data['title']),
            'short_description' => sanitizeInput($data['short_description'] ?? ''),
            'description' => $data['description'] ?? '',
            'project_date' => $data['project_date'] ?: null,
            'status' => $data['status'] ?? 'draft',
            'featured' => isset($data['featured']) ? 1 : 0,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];

        // Handle cover image
        if (Request::hasFile('cover_image') && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadImage($_FILES['cover_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['cover_image'] = $uploadResult['path'];
            }
        }

        // Handle before/after images
        if (Request::hasFile('before_image') && $_FILES['before_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadImage($_FILES['before_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['before_image'] = $uploadResult['path'];
            }
        }

        if (Request::hasFile('after_image') && $_FILES['after_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadImage($_FILES['after_image'], 'projects');
            if ($uploadResult['success']) {
                $projectData['after_image'] = $uploadResult['path'];
            }
        }

        $projectModel->updateById($id, $projectData);

        // Handle gallery images
        $this->handleGalleryUpload($id);

        // Handle image deletion
        if (!empty($data['delete_images'])) {
            $imageModel = new ProjectImage();
            foreach ($data['delete_images'] as $imageId) {
                $image = $imageModel->find((int) $imageId);
                if ($image && $image['project_id'] == $id) {
                    deleteImage($image['image_path']);
                    $imageModel->deleteById((int) $imageId);
                }
            }
        }

        Session::flash('success', 'Réalisation mise à jour avec succès.');
        $this->redirect('/admin/projects');
    }

    public function delete(int $id): void
    {
        $projectModel = new Project();
        $imageModel = new ProjectImage();

        $project = $projectModel->find($id);
        if (!$project) {
            Session::flash('error', 'Réalisation introuvable.');
            $this->redirect('/admin/projects');
            return;
        }

        // Delete associated images
        $images = $imageModel->getByProject($id);
        foreach ($images as $image) {
            deleteImage($image['image_path']);
        }

        // Delete cover and before/after images
        if ($project['cover_image']) deleteImage($project['cover_image']);
        if ($project['before_image']) deleteImage($project['before_image']);
        if ($project['after_image']) deleteImage($project['after_image']);

        $projectModel->deleteById($id);

        Session::flash('success', 'Réalisation supprimée.');
        $this->redirect('/admin/projects');
    }

    private function handleGalleryUpload(int $projectId): array
    {
        $errors = [];
        if (!empty($_FILES['gallery_images']['name'][0])) {
            $imageModel = new ProjectImage();
            $existingImages = $imageModel->getByProject($projectId);
            $startOrder = count($existingImages);

            foreach ($_FILES['gallery_images']['name'] as $index => $name) {
                if ($_FILES['gallery_images']['error'][$index] !== UPLOAD_ERR_OK) {
                    $errors[] = 'Une image de galerie n’a pas pu être téléversée.';
                    continue;
                }

                $file = [
                    'name' => $name,
                    'type' => $_FILES['gallery_images']['type'][$index],
                    'tmp_name' => $_FILES['gallery_images']['tmp_name'][$index],
                    'error' => $_FILES['gallery_images']['error'][$index],
                    'size' => $_FILES['gallery_images']['size'][$index],
                ];

                $uploadResult = uploadImage($file, 'projects');
                if ($uploadResult['success']) {
                    $altText = $_POST['gallery_alts'][$index] ?? '';
                    $imageModel->createImage(
                        $projectId,
                        $uploadResult['path'],
                        sanitizeInput($altText),
                        $startOrder + $index
                    );
                } else {
                    $errors[] = 'Galerie : ' . $uploadResult['error'];
                }
            }
        }

        return $errors;
    }
}
