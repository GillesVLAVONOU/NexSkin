<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index(): void
    {
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $this->viewAdmin('settings.index', [
            'pageTitle' => 'Paramètres - Admin NexSkin',
            'settings' => $settings,
            'success' => Session::getFlash('success'),
        ]);
    }

    public function update(): void
    {
        $data = Request::all();

        $settingModel = new Setting();
        $settingModel->updateMultiple($data);

        Session::flash('success', 'Paramètres mis à jour avec succès.');
        $this->redirect('/admin/settings');
    }
}
