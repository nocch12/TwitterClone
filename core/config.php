<?php

ini_set('display_errors', 1);

require('aws_connect.php');

define('DSN', 'mysql:host=us-cdbr-iron-east-02.cleardb.net;dbname=heroku_4121c3760b2b89d;charset=utf8');
define('DB_USER', 'bd1d9748156e6f');
define('DB_PASS', '5dddb06f');


define('MAX_FILE_SIZE', 1 * 1024 * 1024);
define('THUMBNAIL_WIDTH', 400);
define('POST_IMAGES_DIR', str_replace('/core', '', __DIR__) . '/posted_images');
define('USER_IMAGES_DIR', str_replace('/core', '', __DIR__) . '/user_images');
