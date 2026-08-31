<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index(): void
    {
        $messageModel = new ContactMessage();
        $status = Request::query('status', '');
        $page = max(1, (int) (Request::query('page') ?? 1));

        $messages = $messageModel->getAll($status, 50, ($page - 1) * 50);
        $statusCounts = $messageModel->getStatusCounts();

        $this->viewAdmin('messages.index', [
            'pageTitle' => 'Messages - Admin NexSkin',
            'messages' => $messages,
            'statusCounts' => $statusCounts,
            'currentStatus' => $status,
        ]);
    }

    public function updateStatus(int $id): void
    {
        $status = Request::input('status');
        $allowedStatuses = ['new', 'in_progress', 'processed', 'archived'];

        if (!in_array($status, $allowedStatuses)) {
            Session::flash('error', 'Statut invalide.');
            $this->redirect('/admin/messages');
            return;
        }

        $messageModel = new ContactMessage();
        $messageModel->updateStatus($id, $status);

        Session::flash('success', 'Statut mis à jour.');
        $this->redirect('/admin/messages');
    }

    public function delete(int $id): void
    {
        $messageModel = new ContactMessage();
        $messageModel->deleteById($id);

        Session::flash('success', 'Message supprimé.');
        $this->redirect('/admin/messages');
    }
}
