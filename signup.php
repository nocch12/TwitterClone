<?php
session_start();

require_once(__DIR__ . '/core/config.php');
require_once(__DIR__ . '/functions.php');


if (!empty($_POST)) {
    $signup = new App\Signup($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_check']);

    $error = $signup->getErrors();
    
    if (empty($error)) {
        $signup->accountRegister();
    }
}



?>

    <?php require_once('header.php'); ?>

    <section id="body">
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-width-5-6 uk-width-2-3@s align-center up-form margin-center mt">
                <h3 class="uk-card-title">Sign Up</h3>
                <form action="" method="post">

                    <div class="uk-margin">
                    <?php if ($error['name']) : ?>
                        <p class="error"><?= '* ニックネームを20文字以内で入力してください'; ?></p>
                    <?php elseif($error['duplicate']['name']) : ?>
                        <p class="error"><?= '* 既に登録済みのユーザー名です。'; ?></p>
                    <?php endif; ?>
                        <div class="uk-inline uk-width-5-6">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="name" placeholder="ニックネーム" value="<?= h($_POST['name']); ?>">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <?php if ($error['email']) : ?>
                        <p class="error"><?= '* メールアドレスを正しく入力してください'; ?></p>
                        <?php endif;
                        if ($error['duplicate']['email']) : ?>
                        <p class="error"><?= '* 既に登録済みのメールアドレスです。'; ?></p>
                        <?php endif; ?>
                        <div class="uk-inline uk-width-5-6">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input" type="email" name="email" placeholder="メールアドレス" value="<?= h($_POST['email']); ?>">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <?php if ($error['password']) : ?>
                        <p class="error"><?= '* 半角英数字4文字以上で入力してください'; ?></p>
                        <?php endif; ?>
                        <div class="uk-inline uk-width-5-6">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="password" placeholder="パスワード">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <?php if ($error['password_check']) : ?>
                        <p class="error"><?= '* 同じパスワードを入力してください'; ?></p>
                        <?php endif; ?>
                        <div class="uk-inline uk-width-5-6">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="password_check" placeholder="パスワード（再入力）">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-5-6">
                            <button class="uk-button uk-button-primary" type="submit">登録する</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>