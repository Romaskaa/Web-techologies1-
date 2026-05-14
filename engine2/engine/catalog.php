<?php

/**
 * @return mysqli
 */

function getDbConnection()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$link) {
        die('Ошибка подключения к БД: ' . mysqli_connect_error());
    }

    mysqli_set_charset($link, 'utf8mb4');

    return $link;
}

/**
 * @return array<int, array<string, mixed>>
 */
function getCatalog()
{
    $link = getDbConnection();
    $sql = "SELECT id, name, image_path, price, description FROM products ORDER BY id";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die('Ошибка запроса каталога: ' . mysqli_error($link));
    }

    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($products as &$product) {
        $product['id'] = (int)$product['id'];
    }

    return $products;
}

/**
 * @return array<string, mixed>|null
 */
function getProductById($id)
{
    $link = getDbConnection();
    $sql = "SELECT id, name, image_path, price, description FROM products WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $product['id'] = (int)$product['id'];
    }

    return $product ?: null;
}

/**
 * @return string
 */
function getProductImageSrc($imagePath)
{
    if (preg_match('~^(https?:)?//~', $imagePath) || substr($imagePath, 0, 1) === '/') {
        return $imagePath;
    }

    if (strpos($imagePath, '/') === false) {
        return 'img/' . $imagePath;
    }

    return $imagePath;
}
