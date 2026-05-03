<?php

function getGalleryImages($imagesDir, $urlPrefix)
{
    if (!is_dir($imagesDir)) {
        mkdir($imagesDir, 0777, true);
    }

    if (!is_dir($imagesDir . '/thumbs')) {
        mkdir($imagesDir . '/thumbs', 0777, true);
    }

    $images = [];
    $files = scandir($imagesDir);
    $types = ['jpg', 'jpeg', 'png'];

    foreach ($files as $file) {
        $path = $imagesDir . '/' . $file;
        $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (is_file($path) && in_array($fileType, $types)) {
            $thumb = $urlPrefix . '/' . $file;

            if (file_exists($imagesDir . '/thumbs/' . $file)) {
                $thumb = $urlPrefix . '/thumbs/' . $file;
            }

            $images[] = [
                'name' => $file,
                'src' => $urlPrefix . '/' . $file,
                'thumb' => $thumb,
            ];
        }
    }

    return $images;
}

function uploadGalleryImage($file, $imagesDir)
{
    $types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    if (empty($file['name'])) {
        return ['success' => false, 'message' => 'Выберите файл.'];
    }

    if (!isset($types[$file['type']])) {
        return ['success' => false, 'message' => 'Можно загружать только JPG или PNG.'];
    }

    $maxFileSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxFileSize) {
        return ['success' => false, 'message' => 'Файл слишком большой. Максимум 5 МБ.'];
    }

    if (!is_dir($imagesDir)) {
        mkdir($imagesDir, 0777, true);
    }

    if (!is_dir($imagesDir . '/thumbs')) {
        mkdir($imagesDir . '/thumbs', 0777, true);
    }

    $fileType = $types[$file['type']];
    $fileName = pathinfo($file['name'], PATHINFO_FILENAME) . '.' . $fileType;
    $bigImage = $imagesDir . '/' . $fileName;
    $smallImage = $imagesDir . '/thumbs/' . $fileName;

    resizeImage($file['tmp_name'], $bigImage, 1200, $fileType);
    resizeImage($bigImage, $smallImage, 200, $fileType);

    return ['success' => true, 'message' => 'Изображение загружено.'];
}

function resizeImage($from, $to, $newWidth, $fileType)
{
    $sizes = getimagesize($from);
    $width = $sizes[0];
    $height = $sizes[1];

    if ($width <= $newWidth) {
        $newWidth = $width;
    }

    $newHeight = $height * $newWidth / $width;

    if ($fileType == 'png') {
        $source = imagecreatefrompng($from);
    } else {
        $source = imagecreatefromjpeg($from);
    }

    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if ($fileType == 'png') {
        imagepng($newImage, $to);
    } else {
        imagejpeg($newImage, $to, 90);
    }

}

function logRequest($logFile)
{
    $dir = dirname($logFile);

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    if (is_file($logFile)) {
        $records = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (count($records) >= 10) {
            $i = 0;

            while (file_exists($dir . '/log' . $i . '.txt')) {
                $i++;
            }

            rename($logFile, $dir . '/log' . $i . '.txt');
        }
    }

    file_put_contents($logFile, date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
}
