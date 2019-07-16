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
    public function getUser($id) {
        
        $stmt = $this->_db->prepare('SELECT name, profile, image FROM users WHERE id=?');
		$stmt->execute([$id]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        return $user;
    }

    // 記事一覧を取得
    public function getPosts() {
        $stmt = $this->_db->query('SELECT u.name, u.image, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created DESC');
        
        $posts = $stmt->fetchAll(\PDO::FETCH_OBJ); 
        return $posts;
    }

    // 記事投稿処理
    public function setPost($post, $id) {
        // トークンの一致をチェック
        $this->_validateToken();
        
        // $idがstring型で来るので
        // int型にキャスト
        $id = (int)$id;
        
        if($_FILES['image']) {
            $this->_imageUpload();
        }

        try {
            $sql =
            'INSERT 
            posts (message, user_id, post_image, created)
            values (:message , :user_id, :post_image, NOW())';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindparam(':message', $post['message'], \PDO::PARAM_STR);
            $stmt->bindparam(':user_id', $id, \PDO::PARAM_INT);
            $stmt->bindparam(':post_image', $this->_imageFileName, \PDO::PARAM_STR);
            
            $stmt->execute();

        } catch(\Exceotion $e) {
            echo $e->getMessage();
            exit;
        }
        
        header('Location: index.php');
        exit;
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

    private function _imageUpload() {
        try {
            $this->_validateUpload();

            $ext = $this->_validateImageType();

            $this->_save($ext);
            
            $_SESSION['success'] = 'Upload Done!';
            
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            // exit;
        }
    }

        private function _save($ext) {
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