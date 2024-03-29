<?php
session_start();

require_once(__DIR__ . '/core/config.php');
require_once(__DIR__ . '/core/aws_connect.php');
require_once(__DIR__ . '/functions.php');


if(!isset($_SESSION['id'])) {
    header('Location: login.php');
}

$bbs = new App\Bbs();


// messageかファイルアップロードがあれば投稿処理開始
if ($_POST['message'] ||
    $_FILES['image']['name']) {
    $bbs->setPost($_POST, $_SESSION['id'], $s3, $bucket_name);
}

$user = $bbs->getUser($_SESSION['id'], $s3, $bucket_name);
$posts = $bbs->getPosts($s3, $bucket_name);

?>

    <?php require_once('header.php'); ?>

    <section id="body">
        <div class="container">
            <div class="uk-padding" uk-grid>
                <div class="uk-width-2-3@s">

                    <!-- 投稿フォーム -->
                    <form id="post" action="" method="post" class="uk-text-right" enctype="multipart/form-data">
                        <textarea id="ta" name="message" class="uk-textarea uk-text-left" placeholder="呟いてみましょう！"></textarea>
                        <label uk-icon="icon: image; ratio: 2" type="button" tabindex="-1" class="input_image" for="post_image">
                            <input type="file" id="post_image" name="image">
                        </label>
                        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                        <button class="uk-button uk-button-primary uk-margin post_submit" type="submit">Primary</button>
                    </form>

                    <!-- 投稿一覧 -->
                    <main id="posts">

                    <?php if ($posts) : ?>
                        <?php foreach($posts as $post) :
                        $created = new DateTime($post->created); ?>
                        <!-- 投稿 -->
                        <article class="post" id="post_<?= h($post->id); ?>" data-id="<?= h($post->id); ?>">

                        
                        <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-expand uk-margin" 
                        uk-grid>
                        
                            <div class="uk-card-body post_link_wrap">
                            
                                <a href="single.php?postid=<?= h($post->id) ?>" class="post_link">
                                </a>

                                    <div class="post_inner uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto post_user_img">
                                            <img class="uk-border-circle image_circle50" width="50" height="50" src="<?php
                                                if (empty($post->image)) {
                                                echo "./assets/images/noicon.jpg";
                                            } else {
                                                echo "./user_images/" . $post->image;
                                            }
                                            ?>">
                                        </div><!-- post_user_img -->

                                        <div class="uk-width-expand post_user_name">
                                            <a href="./user.php?user=<?= h($post->name) ?>" class="uk-text-success uk-margin-remove-bottom user_name"><?= h($post->name); ?></a>
                                            <!-- user_name -->

                                            <p class="uk-text-meta uk-margin-remove-top posted_time"><time
                                                    datetime="<?= $created->format('c'); ?>"><?= h($created->format('Y/m/d H:i')); ?></time></p>
                                            <!-- posted_time -->

                                        </div><!-- post_user_name -->
                                    </div><!-- uk-grid-small -->

                                    <div class="card_message">
                                    <p><?= h($post->message); ?></p>
                                    </div>
                                </div><!-- uk-card-body -->

                                <?php if($post->post_image) : ?>
                                <div class="uk-card-media-right uk-cover-container uk-width-1-3" uk-lightbox>
                                    <a href="./posted_images/<?= h($post->post_image); ?>" data-alt="Image">
                                        <div class="post_image_wrap">
                                            <img class="post_image" src="./posted_images/<?= h($post->post_image); ?>">
                                        </div><!-- post_img_wrap -->
                                    </a>
                                </div><!-- light-box -->
                                <?php endif; ?>

                            </div><!-- uk-card -->

                        </article><!-- 投稿 -->
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>投稿がありません</p>
                        <?php endif; ?>
                    </main>

                    <div class="pagination">
                        <ul class="uk-pagination" uk-margin>
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
                                    <img class="uk-border-circle image_circle80" width="80" height="80" src="<?php
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
                            <h3 class="uk-card-title align-center"><a class="uk-link-text" href="./user.php?user=<?= $user->name ?>"><?= h($user->name); ?></a></h3>
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

    <div class="to_top_wrap">
        <a id="to_top" href="#" uk-totop uk-scroll></a>
    </div>
</body>

</html>