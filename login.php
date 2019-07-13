<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    </section>

    <section id="body">
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-width-2-3 align-center up-form margin-center mt">
                <h3 class="uk-card-title">Log In</h3>
                <form action="completed.html" method="post">

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-2-3">
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input" type="text" placeholder="メールアドレス">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-2-3">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" placeholder="パスワード">
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