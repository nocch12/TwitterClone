<?php

require_once('autoload.php');

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

