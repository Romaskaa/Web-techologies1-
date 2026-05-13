<?php
include "db.php";

$result = mysqli_query($db, "SELECT id, parent_id, title FROM menu_items ORDER BY parent_id, sort_order, id");
$itemsByParent = [];

while ($item = mysqli_fetch_assoc($result)) {
    $parentId = $item['parent_id'] === null ? 0 : (int) $item['parent_id'];
    $itemsByParent[$parentId][] = $item;
}

function renderMenu(array $itemsByParent, int $parentId = 0): string
{
    if (empty($itemsByParent[$parentId])) {
        return '';
    }

    $html = '';

    foreach ($itemsByParent[$parentId] as $item) {
        $id = (int) $item['id'];
        $title = htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8');
        $children = renderMenu($itemsByParent, $id);
        $hasChildren = $children !== '';

        if ($hasChildren) {
            $html .= <<<HTML
                <div class="list-item list-item_open" data-parent>
                    <div class="list-item__inner">
                        <img class="list-item__arrow" src="img/chevron-down.png" alt="chevron-down" data-open>
                        <img class="list-item__folder" src="img/folder.png" alt="folder">
                        <span>{$title}</span>
                    </div>
                    <div class="list-item__items">
                        {$children}
                    </div>
                </div>
            HTML;
        } else {
            $html .= <<<HTML
                <div class="list-item">
                    <div class="list-item__inner">
                        <img class="list-item__arrow" src="img/chevron-down.png" alt="" style="visibility:hidden;">
                        <img class="list-item__folder" src="img/folder.png" alt="folder">
                        <span>{$title}</span>
                    </div>
                </div>
            HTML;
        }
    }

    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Item</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="list-items" id="list-items">
    <?= renderMenu($itemsByParent) ?>
</div>
<script type="module" src="js/script.js"></script>
</body>
</html>
