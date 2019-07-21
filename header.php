<?php

require_once('functions.php');


//ファイル名取得
$dir = basename($_SERVER['SCRIPT_NAME']);

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
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/main.js"></script>
</head>

<body>
    <section id="header" class="uk-position-fixed uk-position-z-index">
        <div class="uk-container uk-expand"></div>
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="./">Logo</a>
            </div>


            <div class="uk-navbar-right">            
            <!-- 登録画面ではログイン画面へのリンク表示 -->
            <?php if ($dir === 'signup.php') : ?>
                <a class="uk-navbar-item uk-button uk-button-primary" href="<?= 'login.php'; ?>">ログイン画面へ</a>
            <?php endif; ?>

            
            <!-- ログイン画面では登録画面へのリンク表示 -->
            <?php if ($dir === 'login.php') : ?>
                <a class="uk-navbar-item uk-button uk-button-primary" href="<?= 'signup.php'; ?>">新規登録画面へ</a>
            <?php endif; ?>
            
            <?php if ($dir === 'index.php') : ?>
            <div class="uk-navbar-item uk-visible@s">
                <form action="">
                    <input class="uk-input uk-form-width-medium" name="search" type="search" placeholder="">
                    <button class="uk-button uk-button-default">検索</button>
                </form>
            </div>
            
                        <!-- ログアウトボタン  -->
                        <?php 
                        if ($dir !== 'signup.php' ||
                            $dir !== 'login.php') :
                        ?>
                            <a class="uk-navbar-item uk-button uk-button-danger uk-visible@s" href="<?= 'logout.php'; ?>">ログアウト</a>
                        <?php endif; ?>
            
                
                <!-- スマホ表示時のサイドナビ -->
                <div class="uk-navbar-item uk-hidden@s">
                    <button class="uk-button uk-button-default" type="button"
                        uk-icon="menu" uk-toggle="target: #offcanvas-flip"></button>

                    <div id="offcanvas-flip" uk-offcanvas="flip: true; overlay: true">
                        <div class="uk-offcanvas-bar">

                            <button class="uk-offcanvas-close" type="button" uk-close></button>

                            <h3><?= h($user->name); ?></h3>

                            <p><?= h($user->profile); ?></p>

                        <!-- ログアウトボタン  -->
                        <?php 
                        if ($dir !== 'signup.php' ||
                            $dir !== 'login.php') :
                        ?>
                            <a class="uk-navbar-item uk-button uk-button-danger" href="<?= 'logout.php'; ?>">ログアウト</a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- サイドナビ -->
                
            <?php endif; ?>

            </div><!-- uk-navbar-right -->

        </nav>
    </section><!-- header -->
