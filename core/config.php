<?php

// ini_set('display_errors', 1);

define('DSN', 'mysql:host=localhost;dbname=mybbs;charset=utf8');
define('DB_USER', 'ohnoman');
define('DB_PASS', 'ew5KnK64EAqs');


define('MAX_FILE_SIZE', 1 * 1024 * 1024);
define('THUMBNAIL_WIDTH', 400);
define('POST_IMAGES_DIR', str_replace('/core', '', __DIR__) . '/posted_images');
define('USER_IMAGES_DIR', str_replace('/core', '', __DIR__) . '/user_images');
