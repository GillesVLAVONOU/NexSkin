<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): void
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getWithProjectCount();

        $this->viewAdmin('categories.index', [
            'pageTitle' => 'Catégories - Admin NexSkin',
            'categories' => $categories,
        ]);
    }

    public function store(): void
    {
        $data = Request::all();

        $validator = new \App\Core\Validator($data);
        $validator->validate([
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            $this->redirect('/admin/categories');
            return;
        }

        $categoryModel = new Category();
        $slug = generateSlug($data['name']);

        $existing = $categoryModel->whereOne('slug', $slug);
        if ($existing) {
            $slug .= '-' . time();
        }

        $categoryModel->create([
            'name' => sanitizeInput($data['name']),
            'slug' => $slug,
            'description' => sanitizeInput($data['description'] ?? ''),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        Session::flash('success', 'Catégorie créée avec succès.');
        $this->redirect('/admin/categories');
    }

    public function update(int $id): void
    {
        $data = Request::all();

        $validator = new \App\Core\Validator($data);
        $validator->validate([
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            $this->redirect('/admin/categories');
            return;
        }

        $categoryModel = new Category();
        $categoryModel->updateById($id, [
            'name' => sanitizeInput($data['name']),
            'description' => sanitizeInput($data['description'] ?? ''),
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        Session::flash('success', 'Catégorie mise à jour.');
        $this->redirect('/admin/categories');
    }

    public function delete(int $id): void
    {
        $categoryModel = new Category();
        $categoryModel->deleteById($id);

        Session::flash('success', 'Catégorie supprimée.');
        $this->redirect('/admin/categories');
    }
}
