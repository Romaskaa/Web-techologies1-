<?php

/*Задания 4-5*/


function renderMenuTree(array $items): void
{
    echo '<ul>';

    foreach ($items as $item) {
        $title = $item['title'];
        $link = $item['link'];

        echo '<li>';
        echo '<a href="' . $link . '">' . $title . '</a>';

        if (isset($item['children']) && is_array($item['children']) && count($item['children']) > 0) {
            renderMenuTree($item['children']);
        }

        echo '</li>';
    }

    echo '</ul>';
}

if (isset($menus) && is_array($menus)) {
    renderMenuTree($menus);
}
