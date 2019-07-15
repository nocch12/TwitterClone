<?php

require_once(__DIR__ . '/autoload.php');

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

