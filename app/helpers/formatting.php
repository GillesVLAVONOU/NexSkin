<?php

function formatDate(string $date, string $format = 'd/m/Y'): string
{
    return (new DateTime($date))->format($format);
}

function timeAgo(string $datetime): string
{
    $now = new DateTime();
    $past = new DateTime($datetime);
    $diff = $now->diff($past);

    if ($diff->y > 0) {
        return $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
    }
    if ($diff->m > 0) {
        return $diff->m . ' mois';
    }
    if ($diff->d > 0) {
        return $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
    }
    if ($diff->h > 0) {
        return $diff->h . ' heure' . ($diff->h > 1 ? 's' : '');
    }
    if ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
    }
    return 'à l\'instant';
}

function truncate(string $text, int $length = 100): string
{
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

function nl2brHtml(string $text): string
    {
    return nl2br(escapeHtml($text));
}

function statusLabel(string $status): string
{
    $labels = [
        'draft' => 'Brouillon',
        'published' => 'Publié',
        'new' => 'Nouveau',
        'in_progress' => 'En cours',
        'processed' => 'Traité',
        'archived' => 'Archivé',
    ];
    return $labels[$status] ?? ucfirst($status);
}

function statusColor(string $status): string
{
    $colors = [
        'draft' => 'bg-gray-100 text-gray-700',
        'published' => 'bg-green-100 text-green-700',
        'new' => 'bg-blue-100 text-blue-700',
        'in_progress' => 'bg-yellow-100 text-yellow-700',
        'processed' => 'bg-green-100 text-green-700',
        'archived' => 'bg-gray-100 text-gray-500',
    ];
    return $colors[$status] ?? 'bg-gray-100 text-gray-700';
}

function currentYear(): int
{
    return (int) date('Y');
}
