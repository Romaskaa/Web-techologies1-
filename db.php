<?php
include "config.php";

$db = mysqli_connect(HOST, USER, PASS, DB);

mysqli_set_charset($db, CHARSET);
