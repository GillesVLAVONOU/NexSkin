<?php

function uploadImage(array $file, string $directory, int $maxSize = 5242880): array
{
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $directory = trim(str_replace('\\', '/', $directory), '/');

    if ($directory === '' || str_contains($directory, '..') || !preg_match('/^[a-zA-Z0-9\/_-]+$/', $directory)) {
        return ['success' => false, 'error' => 'Dossier de destination invalide.'];
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Erreur lors de l\'upload.'];
    }

    if (($file['size'] ?? 0) > $maxSize) {
        return ['success' => false, 'error' => 'Le fichier est trop volumineux (max ' . round($maxSize / 1048576, 1) . ' Mo).'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, $allowedTypes, true)) {
        return ['success' => false, 'error' => 'Type de fichier non autorise.'];
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        return ['success' => false, 'error' => 'Extension non autorisee.'];
    }

    $newFilename = bin2hex(random_bytes(16)) . '.' . $extension;
    $uploadRoot = ROOT_PATH . '/public/uploads';
    $uploadDir = $uploadRoot . '/' . $directory;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $realUploadRoot = realpath($uploadRoot) ?: $uploadRoot;
    $realUploadDir = realpath($uploadDir) ?: $uploadDir;
    if (!str_starts_with(str_replace('\\', '/', $realUploadDir), str_replace('\\', '/', $realUploadRoot))) {
        return ['success' => false, 'error' => 'Dossier de destination invalide.'];
    }

    $destination = $uploadDir . '/' . $newFilename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'error' => 'Impossible de sauvegarder le fichier.'];
    }

    $webpFilename = pathinfo($newFilename, PATHINFO_FILENAME) . '.webp';
    $webpPath = $uploadDir . '/' . $webpFilename;

    if (function_exists('imagewebp') && function_exists('imagecreatefromstring')) {
        $imageData = file_get_contents($destination);
        $image = @imagecreatefromstring($imageData);

        if ($image) {
            if (imagewebp($image, $webpPath, 85)) {
                imagedestroy($image);
                unlink($destination);
                return [
                    'success' => true,
                    'filename' => $webpFilename,
                    'path' => 'public/uploads/' . $directory . '/' . $webpFilename,
                ];
            }
            imagedestroy($image);
        }
    }

    return [
        'success' => true,
        'filename' => $newFilename,
        'path' => 'public/uploads/' . $directory . '/' . $newFilename,
    ];
}

function deleteImage(string $path): bool
{
    $normalized = str_replace('\\', '/', $path);
    if (!str_starts_with($normalized, 'public/uploads/') || str_contains($normalized, '..')) {
        return false;
    }

    $fullPath = ROOT_PATH . '/' . $normalized;
    $uploadRoot = realpath(ROOT_PATH . '/public/uploads');
    $target = realpath($fullPath);

    if (!$uploadRoot || !$target || !str_starts_with(str_replace('\\', '/', $target), str_replace('\\', '/', $uploadRoot))) {
        return false;
    }

    return is_file($target) ? unlink($target) : false;
}

function getImageUrl(?string $path): string
{
    if (!$path) {
        return asset('images/placeholder.svg');
    }
    if (str_starts_with($path, 'http')) {
        return $path;
    }
    return url($path);
}
