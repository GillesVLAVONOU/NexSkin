<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index(): void
    {
        $projectModel = new Project();
        $categoryModel = new Category();
        $settingModel = new Setting();

        $settings = $settingModel->getAll();
        $featuredProjects = $projectModel->getFeatured(3);
        $recentProjects = $projectModel->getRecent(6);
        $categories = $categoryModel->getAllOrdered();

        $this->view('home.index', [
            'pageTitle' => $settings['company_name'] ?? 'NexSkin',
            'pageDescription' => $settings['meta_description'] ?? 'NexSkin - Personnalisation d\'ordinateurs portables',
            'settings' => $settings,
            'featuredProjects' => $featuredProjects,
            'recentProjects' => $recentProjects,
            'categories' => $categories,
        ]);
    }
}
