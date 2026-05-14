<?php
include "../config/config.php";

// logRequest(__DIR__ . '/log.txt');

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
        $params['title'] = 'Отчеты';
        $params['message'] = 'Файл загружен';
        $params['files'] = getFiles();
        // _log($params, 'bux');
        break;

    case 'catalog':
        $params['title'] = 'Каталог';
        $params['catalog'] = getCatalog();
        break;

    case 'product':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $feedbackResult = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_action'])) {
            $feedbackResult = doFeedbackAction($_POST['feedback_action'], $_POST);
            $redirectProductId = (int)($_POST['product_id'] ?? $id);

            if ($feedbackResult['success']) {
                header('Location: index.php?page=product&id=' . $redirectProductId);
                die();
            }
        }

        $params['product'] = getProductById($id);
        $params['feedback'] = $params['product'] ? doFeedbackAction('list', ['product_id' => $id]) : [];
        $params['feedbackError'] = $feedbackResult['message'] ?? '';
        $params['title'] = $params['product'] ? $params['product']['name'] : 'Товар не найден';
        break;

    case 'about':
        $params['title'] = 'О нас';
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
