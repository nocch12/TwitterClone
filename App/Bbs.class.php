<?php

namespace App;

class Bbs {
    private $_db;

    private $_imageType;
    private $_imageFileName = '';

    // ログイン中のユーザーIDを受け取る
    public function __construct() {
        // トークンを発行(CSRF対策)
        \session_regenerate_id(true);
        $this->_createToken();

        // データベースに接続
        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }

    }
    
    // ランダムなトークンを発行する処理
    private function _createToken() {
        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(\openssl_random_pseudo_bytes(16));
        }
    }

    // ユーザー情報を取得
    public function getUser($id, $s3, $bucket_name) {
        
        $stmt = $this->_db->prepare('SELECT name, profile, image FROM users WHERE id=?');
		$stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);
        
        if(empty($user->image)) {
            $this->_getProfileImage($user->image, $s3, $bucket_name);
        }

        return $user;
    }
    
    private function _getProfileImage($imageName, $s3, $bucket_name) {
        if (!\file_exists(__DIR__ . '/../user_images' . $imageName)) {
        

            $params = [
                'Bucket' => $bucket_name,
                'Key' => 'user_images/' . $imageName,
                'SaveAs' => __DIR__ . '/../user_images/' . $imageName,
            ];

            try
            {
                $result = $s3->getObject($params);
            }
            catch(S3Exception $e)
            {
                var_dump($e -> getMessage());
            }   
        }
    }

    // 記事一覧を取得
    public function getPosts($s3, $bucket_name) {
        $stmt = $this->_db->query('SELECT u.name, u.image, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created DESC');
        
        $posts = $stmt->fetchAll(\PDO::FETCH_OBJ); 

        foreach ($posts as $post) {
            if($post->image) {
                $this->_getPostUserImage($post->image, $s3, $bucket_name);
            }
            if($post->post_image) {
                $this->_getPostImage($post->post_image, $s3, $bucket_name);
            }
        }
        
        return $posts;
    }


    // AWS s3から画像を取得
    private function _getPostUserImage($imageName, $s3, $bucket_name) {
        // ユーザーイメージが保存されていなければ取得する処理
        if (!\file_exists(__DIR__ . '/../user_images' . $imageName)) {
            $params = [
                'Bucket' => $bucket_name,
                'Key' => 'user_images/' . $imageName,
                'SaveAs' => __DIR__ . '/../user_images/' . $imageName,
            ];

            try
            {
                $s3->getObject($params);
            }
            catch(S3Exception $e)
            {
                var_dump($e -> getMessage());
            }   
        }
    }

    // AWS s3から画像を取得
    private function _getPostImage($imageName, $s3, $bucket_name) {
        // 投稿画像が保存されていなければ取得する処理
        if (!\file_exists(__DIR__ . '/../posted_images' . $imageName)) {
            $params = [
                'Bucket' => $bucket_name,
                'Key' => 'posted_images/' . $imageName,
                'SaveAs' => __DIR__ . '/../posted_images/' . $imageName,
            ];

            try
            {
                $s3->getObject($params);
            }
            catch(S3Exception $e)
            {
                var_dump($e -> getMessage());
            }   
        }
    }

    // 記事投稿処理
    public function setPost($post, $id, $s3, $bucket_name) {
        // $idがstring型で来るのでint型にキャスト
        // なくても一応動く
        $id = (int)$id;
        
        // メッセージの空文字判定
        $msg = $this->_validateMessage($post['message']);

        // トークンの一致をチェック
        $this->_validateToken();
        

        // ファイルネームがある（何かしら送信されている）なら
        // 画像アップロード処理
        if($_FILES['image']['name']) {
            $this->_imageUpload($s3, $bucket_name);
        }
        

        // 投稿内容をDBにインサート
        try {
            $sql =
            'INSERT 
            posts (message, user_id, post_image, created)
            values (:message , :user_id, :post_image, NOW())';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindvalue(':message', $msg, \PDO::PARAM_STR);
            $stmt->bindvalue(':user_id', $id, \PDO::PARAM_INT);
            $stmt->bindvalue(':post_image', $this->_imageFileName, \PDO::PARAM_STR);
            
            $stmt->execute();

        } catch(\Exceotion $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        
        header('Location: index.php');
        exit;
    }

    private function _validateMessage($msg) {

        $pattern="/^(\s|　)+$/";  //正規表現のパターン

        // 空白文字のみで画像もなければ処理をせずリダイレクト
        if(preg_match($pattern, $msg) &&
            empty($_FILES['image']['name'])) {
                
                header('Location: index.php');
                exit;
            }

            // 空白文字でなければそのまま返す
            // 画像があればメッセージが空白でもOKなので返す
            return $msg;
    }

    private function _validateToken() {
        if (
            !isset($_SESSION['token']) ||
            !isset($_POST['token']) ||
            $_POST['token'] !== $_SESSION['token']
        ) {
            throw new \Exceotion('invalid Token');
        }
    }

    private function _imageUpload($s3, $bucket_name) {
        try {
            // ファイルが正しくアップロードされているか
            $this->_validateUpload();

            // ファイル形式が画像かどうか
            // 画像なら拡張子が返ってくる
            $ext = $this->_validateImageType();

            // 一時フォルダから本番フォルダに保存処理
            $this->_save($ext);

            $this->_uploadImageToAWS($s3, $bucket_name);
            
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            // exit;
        }
    }

    private function _uploadImageToAWS($s3, $bucket_name) {
        $params = [
            'Bucket' => $bucket_name,
            'Key' => 'post_images/' . $this->_imageFileName,
            'SourceFile'   => __DIR__ . '/../posted_images/' . $this->_imageFileName,
        ];

        try
        {
            $result = $s3 -> putObject($params);
        }
        catch(S3Exception $e)
        {
            var_dump($e -> getMessage());
        }
        
    }

    private function _save($ext) {
        // 日時、乱数でファイル名の重複を防ぐ
        $this->_imageFileName = sprintf(
            '%s_%s.%s',
            time(),
            sha1(uniqid(mt_rand(), true)),
            $ext
        );
        $savePath = POST_IMAGES_DIR . '/' . $this->_imageFileName;
        $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
        if ($res === false) {
            throw new \Exception('Could not upload!');
        }
    }

    private function _validateImageType() {
        $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);

        switch($this->_imageType) {
            case IMAGETYPE_GIF:
                return 'gif';
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';
                default:
                    throw new \Exception('PNG/JPEG/GIF only!');
        }
    }
    
    private function _validateUpload() {

        if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
            throw new \Exception('upload error!');
        }

        switch($_FILES['image']['error']) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \Exception('File too large!');
            default:
                throw new \Exception('Err:' . $_FILES['image']['error']);
        }
    }
    
}