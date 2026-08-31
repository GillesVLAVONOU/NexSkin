<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Setting;

class LegalController extends Controller
{
    public function legal(): void
    {
        $settings = (new Setting())->getAll();

        $this->view('legal.mentions', [
            'pageTitle' => 'Mentions legales - NexSkin',
            'pageDescription' => 'Mentions legales du site NexSkin.',
            'settings' => $settings,
        ]);
    }

    public function privacy(): void
    {
        $settings = (new Setting())->getAll();

        $this->view('legal.privacy', [
            'pageTitle' => 'Politique de confidentialite - NexSkin',
            'pageDescription' => 'Politique de confidentialite du site NexSkin.',
            'settings' => $settings,
        ]);
    }
}
