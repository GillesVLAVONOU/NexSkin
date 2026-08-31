<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\ContactMessage;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index(): void
    {
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $this->view('contact.index', [
            'pageTitle' => 'Contact - NexSkin',
            'pageDescription' => 'Contactez NexSkin pour votre projet de personnalisation.',
            'settings' => $settings,
            'success' => Session::getFlash('success'),
            'errors' => Session::getFlash('errors'),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function store(): void
    {
        $data = Request::all();

        $validator = new \App\Core\Validator($data);
        $validator->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $data);
            $this->redirect('/contact');
            return;
        }

        $messageData = [
            'first_name' => sanitizeInput($data['first_name']),
            'last_name' => sanitizeInput($data['last_name']),
            'email' => sanitizeInput($data['email']),
            'phone' => sanitizeInput($data['phone'] ?? ''),
            'project_type' => sanitizeInput($data['project_type'] ?? ''),
            'device_model' => sanitizeInput($data['device_model'] ?? ''),
            'budget' => sanitizeInput($data['budget'] ?? ''),
            'message' => sanitizeInput($data['message']),
        ];

        if (Request::hasFile('reference_image')) {
            $uploadResult = uploadImage($_FILES['reference_image'], 'references');
            if (!$uploadResult['success']) {
                Session::flash('errors', ['reference_image' => [$uploadResult['error']]]);
                Session::flash('old', $data);
                $this->redirect('/contact');
                return;
            }

            $messageData['reference_image'] = $uploadResult['path'];
        }

        (new ContactMessage())->create($messageData);
        $this->notifyOwner($messageData);

        Session::flash('success', 'Votre message a ete envoye avec succes. Nous vous repondrons dans les plus brefs delais.');
        $this->redirect('/contact');
    }

    private function notifyOwner(array $messageData): void
    {
        $settings = (new Setting())->getAll();
        $to = $settings['contact_notification_email'] ?? $settings['email'] ?? null;

        if (!$to || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $from = $settings['email'] ?? 'no-reply@nexskin.local';
        $subject = 'Nouvelle demande NexSkin';
        $body = "Nouvelle demande de personnalisation\n\n"
            . "Nom: {$messageData['first_name']} {$messageData['last_name']}\n"
            . "Email: {$messageData['email']}\n"
            . "Telephone: {$messageData['phone']}\n"
            . "Type: {$messageData['project_type']}\n"
            . "Modele: {$messageData['device_model']}\n"
            . "Budget: {$messageData['budget']}\n\n"
            . $messageData['message'];

        $headers = [
            'From: NexSkin <' . $from . '>',
            'Reply-To: ' . $messageData['email'],
            'Content-Type: text/plain; charset=UTF-8',
        ];

        @mail($to, $subject, $body, implode("\r\n", $headers));
    }
}
