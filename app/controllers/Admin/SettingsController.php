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
            'error' => Session::getFlash('error'),
        ]);
    }

    public function update(): void
    {
        $data = Request::all();

        $settingModel = new Setting();
        $settingModel->updateMultiple($data);

        $heroImages = json_decode($settingModel->get('hero_images', '[]') ?? '[]', true);
        $heroImages = is_array($heroImages) ? array_values($heroImages) : [];
        $removedImages = array_map('intval', (array) ($data['remove_hero_images'] ?? []));
        $heroImages = array_values(array_filter(
            $heroImages,
            static fn ($image, $index): bool => !in_array($index, $removedImages, true),
            ARRAY_FILTER_USE_BOTH
        ));

        $uploadErrors = [];
        $files = Request::file('hero_images');
        if ($files && is_array($files['name'] ?? null)) {
            foreach ($files['name'] as $index => $name) {
                if (($files['error'][$index] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if (count($heroImages) >= 8) {
                    $uploadErrors[] = 'Le carrousel est limité à 8 images.';
                    break;
                }

                $file = [
                    'name' => $name,
                    'type' => $files['type'][$index] ?? '',
                    'tmp_name' => $files['tmp_name'][$index] ?? '',
                    'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$index] ?? 0,
                ];
                $upload = uploadImage($file, 'hero');
                if ($upload['success']) {
                    $heroImages[] = $upload['path'];
                } else {
                    $uploadErrors[] = $upload['error'];
                }
            }
        }

        $settingModel->set('hero_images', json_encode($heroImages, JSON_UNESCAPED_SLASHES));

        if ($uploadErrors) {
            Session::flash('error', implode(' ', array_unique($uploadErrors)));
        }

        Session::flash('success', 'Paramètres mis à jour avec succès.');
        $this->redirect('/admin/settings');
    }
}
