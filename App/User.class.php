<?php

namespace App;

class User {
    private $_db;
    private $_user_name;

    // ログイン中のユーザーIDを受け取る
    public function __construct() {
        if(!isset($_GET['user'])) {
            $_GET['user'] = $_SESSION['name'];
        }

        $this->_user_name = $_GET['user'];

        var_dump($_SESSION);
        exit;
        

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
    public function getUser() {
        
        $stmt = $this->_db->prepare('SELECT name, profile, image FROM users WHERE id=?');
		$stmt->execute([$this->_user_id]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        return $user;
    }

    // 記事一覧を取得
    public function getPosts() {
        $sql = 
        'SELECT u.name, u.image, p.*
        FROM users u, posts p 
        WHERE  u.id = :id
        AND u.id = p.user_id
        ORDER BY created DESC';

        $id = $this->_user_id;
        
        $stmt = $this->_db->prepare($sql);
        $stmt->bindvalue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $posts = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $posts;
    }


    private function _imageUpload() {
        try {
            $this->_validateUpload();

            $ext = $this->_validateImageType();

            $this->_save($ext);
            
            $_SESSION['success'] = 'Upload Done!';

            return $savePath;
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
        $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
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