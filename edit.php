<?php
session_start();

require_once(__DIR__ . '/core/config.php');
require(__DIR__ . '/core/aws_connect.php');
require_once(__DIR__ . '/functions.php');

if(!isset($_SESSION['id'])) {
    header('Location: login.php');
}

$account = new App\User();

$prof = array_filter($_POST);
if ($prof ||
    ($_FILES['image']['name'])) {
    $account->setProfile($prof, $s3, $bucket_name);
}

$user = $account->getUser();


?>

    <?php require_once('header.php'); ?>

    <section id="body">
        <div class="container">
            <div class="uk-padding" uk-grid>
                <div class="uk-width-2-3@s">

                    <div class="uk-card uk-card-default uk-padding">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="uk-margin" uk-margin>
                                <div uk-form-custom="target: true">
                                    <input type="file" id="upimage" name="image">
                                    <input class="uk-input uk-form-width-medium" type="text" placeholder="プロフィール画像" disabled>
                                </div>
                                <label for="upimage" class="uk-button uk-button-primary">ファイルを選択</label>
                            </div>
                            <div class="uk-margin">
                                <textarea class="uk-textarea" rows="5" placeholder="プロフィール文" name="profile"></textarea>
                            </div>
                            <button class="uk-button uk-button-default">変更を適用</button>
                        </form>
                    </div>
                </div>

                <!--プロフィール -->
                <div id="profile" class="uk-width-1-3 uk-visible@s">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top uk-padding-small align-center">
                            <div uk-lightbox>
                                <a href="<?php
                                if (empty($user->image)) {
                                    echo "./assets/images/noicon.jpg";
                                } else {
                                    echo "./user_images/" . $user->image;
                                }
                                ?>" data-alt="Image">
                                    <img class="uk-border-circle" width="80" height="80" src="<?php
                                if (empty($user->image)) {
                                    echo "./assets/images/noicon.jpg";
                                } else {
                                    echo "./user_images/" . $user->image;
                                }
                                ?>">
                                </a>
                            </div>
                        </div>
                        <div class="uk-card-header">
                            <h3 class="uk-card-title align-center"><a class="uk-link-text" href=""><?= h($user->name); ?></a></h3>
                        </div>
                        <div class="uk-card-body">
                            <?php if($user->profile) {
                                echo h($user->profile);
                            } else {
                                echo 'プロフィールが登録されていません。';
                            } ?>
                        </div>
                    </div>
                </div><!-- profile -->

            </div>
        </div>
    </section>

    <a id="to_top" href="#" uk-totop uk-scroll></a>

</body>

</html>