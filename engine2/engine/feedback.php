<?php

function doFeedbackAction($action, $data = [])
{
    switch ($action) {
        case 'list':
            return getProductFeedback((int)($data['product_id'] ?? 0));

        case 'create':
            return createFeedback($data);

        case 'update':
            return updateFeedback($data);

        case 'delete':
            return deleteFeedback($data);

        default:
            return [
                'success' => false,
                'message' => 'Неизвестное действие с отзывом',
            ];
    }
}

function getProductFeedback($productId)
{
    $link = getDbConnection();
    $sql = "SELECT id, product_id, author, text, created_at FROM feedback WHERE product_id = ? ORDER BY created_at DESC, id DESC";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($feedback as &$item) {
        $item['id'] = (int)$item['id'];
        $item['product_id'] = (int)$item['product_id'];
    }

    return $feedback;
}

function feedbackBelongsToProduct($id, $productId)
{
    $link = getDbConnection();
    $sql = "SELECT id FROM feedback WHERE id = ? AND product_id = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'ii', $id, $productId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return (bool)mysqli_fetch_assoc($result);
}

function createFeedback($data)
{
    $productId = (int)($data['product_id'] ?? 0);
    $author = trim($data['author'] ?? '');
    $text = trim($data['text'] ?? '');

    if ($productId <= 0 || $author === '' || $text === '') {
        return [
            'success' => false,
            'message' => 'Заполните имя и текст отзыва',
        ];
    }

    if (!getProductById($productId)) {
        return [
            'success' => false,
            'message' => 'Товар для отзыва не найден',
        ];
    }

    $link = getDbConnection();
    $sql = "INSERT INTO feedback (product_id, author, text) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'iss', $productId, $author, $text);
    mysqli_stmt_execute($stmt);

    return [
        'success' => true,
        'id' => mysqli_insert_id($link),
    ];
}

function updateFeedback($data)
{
    $id = (int)($data['id'] ?? 0);
    $productId = (int)($data['product_id'] ?? 0);
    $author = trim($data['author'] ?? '');
    $text = trim($data['text'] ?? '');

    if ($id <= 0 || $productId <= 0 || $author === '' || $text === '') {
        return [
            'success' => false,
            'message' => 'Заполните имя и текст отзыва',
        ];
    }

    if (!feedbackBelongsToProduct($id, $productId)) {
        return [
            'success' => false,
            'message' => 'Отзыв для этого товара не найден',
        ];
    }

    $link = getDbConnection();
    $sql = "UPDATE feedback SET author = ?, text = ? WHERE id = ? AND product_id = ?";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'ssii', $author, $text, $id, $productId);
    mysqli_stmt_execute($stmt);

    return [
        'success' => true,
    ];
}

function deleteFeedback($data)
{
    $id = (int)($data['id'] ?? 0);
    $productId = (int)($data['product_id'] ?? 0);

    if ($id <= 0 || $productId <= 0) {
        return [
            'success' => false,
            'message' => 'Отзыв не найден',
        ];
    }

    if (!feedbackBelongsToProduct($id, $productId)) {
        return [
            'success' => false,
            'message' => 'Отзыв для этого товара не найден',
        ];
    }

    $link = getDbConnection();
    $sql = "DELETE FROM feedback WHERE id = ? AND product_id = ?";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'ii', $id, $productId);
    mysqli_stmt_execute($stmt);

    return [
        'success' => true,
    ];
}
