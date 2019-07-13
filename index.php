<?php
session_start();

if(empty($_SESSION)) {
    header('Location: login.php');
}

var_dump($_SESSION);


?>

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

            <div class="uk-navbar-right">
                <div class="uk-navbar-item uk-visible@s">
                    <form action="">
                        <input class="uk-input uk-form-width-medium" name="search" type="search" placeholder="">
                        <button class="uk-button uk-button-default">検索</button>
                    </form>
                </div>
                <div class="uk-navbar-item uk-hidden@s">
                    <button class="uk-button uk-button-default" type="button"
                        uk-toggle="target: #offcanvas-flip">Open</button>

                    <div id="offcanvas-flip" uk-offcanvas="flip: true; overlay: true">
                        <div class="uk-offcanvas-bar">

                            <button class="uk-offcanvas-close" type="button" uk-close></button>

                            <h3>Title</h3>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt
                                ut labore et dolore
                                magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                nisi ut
                                aliquip ex ea
                                commodo consequat.</p>

                        </div>
                    </div>
                </div>
            </div>

        </nav>
    </section>

    <section id="body">
        <div class="container">
            <div class="uk-padding" uk-grid>
                <div class="uk-width-2-3@s">
                    <form id="post" action="" method="post" class="">
                        <textarea name="message" class="uk-textarea"></textarea>
                        <div uk-form-custom>
                            <input type="file">
                            <button uk-icon="icon: image; ratio: 2" type="button" tabindex="-1"></button>
                        </div>
                        <button class="uk-button uk-button-primary uk-margin">Primary</button>
                    </form>

                    <main id="posts">
                        <!-- 投稿一覧 -->

                        <!-- 投稿 -->
                        <article class="post" id="" data-id="">
                            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin"
                                uk-grid>

                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle" width="50" height="50"
                                                src="/assets/img/aaa.png">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a class="uk-text-success uk-margin-remove-bottom user_name">Title</a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt.</p>
                                </div><!-- uk-card-body -->

                                <div class=" uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="/assets/img/dc1.png" data-alt="Image">
                                        <div class="post_img_wrap">
                                            <img class="post_img" src="/assets/img/dc1.png" alt="">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->

                            </div><!-- uk-card -->

                        </article><!-- 投稿 -->

                        <article id="" data-id="">

                            <!-- 投稿 -->
                            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin"
                                uk-grid>

                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle" width="50" height="50"
                                                src="/assets/img/aaa.png">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a class="uk-text-success uk-margin-remove-bottom user_name">Title</a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt.</p>
                                </div><!-- uk-card-body -->

                                <div class=" uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="/assets/img/dc1.png" data-alt="Image">
                                        <div class="post_img_wrap">
                                            <img class="post_img" src="/assets/img/dc1.png" alt="">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->

                            </div><!-- uk-card -->

                        </article>

                        <article id="" data-id="">

                            <!-- 投稿 -->
                            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin"
                                uk-grid>

                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle" width="50" height="50"
                                                src="/assets/img/aaa.png">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a class="uk-text-success uk-margin-remove-bottom user_name">Title</a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt.</p>
                                </div><!-- uk-card-body -->

                                <div class=" uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="/assets/img/dc1.png" data-alt="Image">
                                        <div class="post_img_wrap">
                                            <img class="post_img" src="/assets/img/dc1.png" alt="">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->

                            </div><!-- uk-card -->

                        </article>

                        <article id="" data-id="">

                            <!-- 投稿 -->
                            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin"
                                uk-grid>

                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle" width="50" height="50"
                                                src="/assets/img/aaa.png">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a class="uk-text-success uk-margin-remove-bottom user_name">Title</a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt.</p>
                                </div><!-- uk-card-body -->

                                <div class=" uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="/assets/img/dc1.png" data-alt="Image">
                                        <div class="post_img_wrap">
                                            <img class="post_img" src="/assets/img/dc1.png" alt="">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->

                            </div><!-- uk-card -->

                        </article>

                        <article id="" data-id="">

                            <!-- 投稿 -->
                            <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin"
                                uk-grid>

                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle" width="50" height="50"
                                                src="/assets/img/aaa.png">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a class="uk-text-success uk-margin-remove-bottom user_name">Title</a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt.</p>
                                </div><!-- uk-card-body -->

                                <div class=" uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="/assets/img/dc1.png" data-alt="Image">
                                        <div class="post_img_wrap">
                                            <img class="post_img" src="/assets/img/dc1.png" alt="">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->

                            </div><!-- uk-card -->

                        </article>

                        <ul class="uk-pagination uk-flex-center" uk-margin>
                            <li><a href="#"><span uk-pagination-previous></span></a></li>
                            <li><a href="#">1</a></li>
                            <li class="uk-disabled"><span>...</span></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li class="uk-active"><span>7</span></li>
                            <li><a href="#">8</a></li>
                            <li><a href="#">9</a></li>
                            <li><a href="#">10</a></li>
                            <li class="uk-disabled"><span>...</span></li>
                            <li><a href="#">20</a></li>
                            <li><a href="#"><span uk-pagination-next></span></a></li>
                        </ul>
                    </main>
                </div>

                <div id="profile" class="uk-width-1-3 uk-visible@s">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top uk-padding-small align-center">
                            <div uk-lightbox>
                                <a href="/assets/img/aaa.png" data-alt="Image">
                                    <img class="uk-border-circle" width="80" height="80" src="/assets/img/aaa.png">
                                </a>
                            </div>
                        </div>
                        <div class="uk-card-header">
                            <h3 class="uk-card-title align-center"><a class="uk-link-text" href="#">名前</a></h3>
                        </div>
                        <div class="uk-card-body">プロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィール</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <a id="to_top" href="#" uk-totop uk-scroll></a>

</body>

</html>