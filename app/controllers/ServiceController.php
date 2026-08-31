<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class ServiceController extends Controller
{
    public function index(): void
    {
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $this->view('services.index', [
            'pageTitle' => 'Nos services - NexSkin',
            'pageDescription' => 'Découvrez nos services de personnalisation d\'ordinateurs portables.',
            'settings' => $settings,
        ]);
    }
}
