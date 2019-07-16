<?php
    session_start();

    /*
    新規登録完了時のみセットされるセッション
    新規登録以外からのアクセスはログイン画面へ
    */
    if (!($_SESSION['completed'])) {
        header('Location: login.php');
        exit;
    }

    unset($_SESSION['completed']);

?>


<?php require_once('header.php'); ?>

    <section id="body">
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-width-2-3 align-center up-form margin-center mt">
                <h3 class="uk-card-title">登録が完了しました</h3>
                <form action="completed.html" method="post">

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-2-3">
                            <a href="login.php" class="uk-button uk-button-primary">ログイン画面へ</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>