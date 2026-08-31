<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class AboutController extends Controller
{
    public function index(): void
    {
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $this->view('about.index', [
            'pageTitle' => 'À propos - NexSkin',
            'pageDescription' => 'Découvrez l\'histoire de NexSkin, votre partenaire en personnalisation.',
            'settings' => $settings,
        ]);
    }
}
