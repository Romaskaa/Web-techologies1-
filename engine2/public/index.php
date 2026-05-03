<?php
include "../config/config.php";

logRequest(__DIR__ . '/log.txt');

$page = 'index';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$params = [];

switch ($page) {
    case 'index':
        $galleryDir = __DIR__ . '/img/gallery';
        $params['title'] = 'Фотогалерея';
        $params['message'] = '';
        $params['error'] = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = uploadGalleryImage($_FILES['image'] ?? null, $galleryDir);

            if ($result['success']) {
                header('Location: index.php');
                die();
            }

            $params['error'] = $result['message'];
        }

        $params['images'] = getGalleryImages($galleryDir, 'img/gallery');
        break;

    case 'bux':
        /* if (!empty($_FILES)) {
            upload();
            header(/?page=bux);
        die();
        }*/

        $params['title'] = 'Бухи';
        $params['message'] = 'Файл загружен';
        $params['files'] = getFiles();
        _log($params, 'bux');
        break;

    case 'catalog':
        $params['title'] = 'Каталог';
        $params['catalog'] = getCatalog();
        break;

    case 'about':
        $params['title'] = 'about';
        $params['phone'] = 444333;
        break;

    case 'apicatalog':
        echo json_encode(getCatalog(), JSON_UNESCAPED_UNICODE);
        die();

    default:
        echo "404";
        die();
}

echo render($page, $params);
