<?php

require_once('functions.php');


//ファイル名取得
$dir = basename($_SERVER['SCRIPT_NAME']);

var_dump($dir);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- 登録完了画面からログイン画面へ自動遷移 -->
    <?php if($dir === 'completed.php') : ?>
    <meta http-equiv="Refresh" content="3;URL=login.php"> 
    <?php endif; ?>

    <link rel="stylesheet" href="assets/css/uikit.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <script src="assets/js/uikit/uikit.min.js"></script>
    <script src="assets/js/uikit/uikit-icons.min.js"></script>
</head>

<body>
    <section id="header" class="uk-position-fixed uk-position-z-index">
        <div class="uk-container uk-expand"></div>
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="#">Logo</a>
            </div>
            
            <!-- 登録画面ではログイン画面へのリンク表示 -->
            <?php if ($dir === 'signup.php') : ?>
            <div class="uk-navbar-right">
                <a class="uk-navbar-item uk-button uk-button-primary" href="<?= 'login.php'; ?>">ログイン画面へ</a>
            </div>
            <?php endif; ?>

            
            <!-- ログイン画面では登録画面へのリンク表示 -->
            <?php if ($dir === 'login.php') : ?>
            <div class="uk-navbar-right">
                <a class="uk-navbar-item uk-button uk-button-primary" href="<?= 'signup.php'; ?>">新規登録画面へ</a>
            </div>
            <?php endif; ?>
    </section>