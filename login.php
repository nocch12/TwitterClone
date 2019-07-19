<?php
session_start();

require_once(__DIR__ . '/core/config.php');
require_once(__DIR__ . '/functions.php');


if (!empty($_POST)) {
    $login = new App\Login($_POST['email'], $_POST['password']);

    $error = $login->getErrors();
    
    if(empty($error)) {
        $login->login();
    }
}

?>

    <?php require_once('header.php'); ?>

    <section id="body">
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-width-2-3 align-center up-form margin-center mt">
                <h3 class="uk-card-title">Log In</h3>
                <form action="" method="post">

                    <div class="uk-margin">
                        <?php if ($error['email']) : ?>
                        <p class="error"><?= '* 存在しないアカウントです。'; ?></p>
                        <?php endif; ?>
                        <div class="uk-inline uk-width-2-3">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input" type="email" name="email" placeholder="メールアドレス" value="<?= h($_POST['email']); ?>">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <?php if ($error['password']) : ?>
                        <p class="error"><?= '* ログインに失敗しました'; ?></p>
                        <?php endif; ?>
                        <div class="uk-inline uk-width-2-3">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="password" placeholder="パスワード">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-2-3">
                            <button class="uk-button uk-button-primary" type="submit">ログイン</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>