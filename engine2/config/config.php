<?php
define('TEMPLATES_DIR', __DIR__ . '/../templates/');
define('LAYOUTS_DIR', 'layouts/');

define('DB_HOST', 'localhost');
define('DB_USER', 'RomanPetin');
define('DB_PASS', '12345');
define('DB_NAME', 'lesson21');

include __DIR__ . "/../engine/bux.php";
include __DIR__ . "/../engine/functions.php";
include __DIR__ . "/../engine/catalog.php";
include __DIR__ . "/../engine/feedback.php";
include __DIR__ . "/../engine/gallery.php";
include __DIR__ . "/../engine/log.php";
