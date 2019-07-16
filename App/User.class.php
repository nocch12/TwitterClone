<?php

namespace App;

class User {
    private $_db;
    private $_id;
    private $_user_name;
    
    private $_imageType;
    private $_imageFileName = '';

    public function __construct() {
        if(!isset($_GET['user'])) {
            $_GET['user'] = $_SESSION['name'];
        }

        $this->_id = (int)$_SESSION['id'];
        $this->_user_name = $_GET['user'];

        // データベースに接続
        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }

    }

    // ユーザー情報を取得
    public function getUser() {
        
        $stmt = $this->_db->prepare('SELECT name, profile, image FROM users WHERE name=?');
		$stmt->execute([$this->_user_name]);
        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        return $user;
    }

    // 表示中ユーザーの記事一覧を取得
    public function getPosts() {
        $sql = 
        'SELECT u.name, u.image, p.*
        FROM users u, posts p 
        WHERE  u.name = :name
        AND u.id = p.user_id
        ORDER BY created DESC';

        $name = $this->_user_name;
        
        $stmt = $this->_db->prepare($sql);
        $stmt->bindvalue(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        
        $posts = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        return $posts;
    }
    
    public function setProfile($prof) {
        $image = '';
        $profile = '';

        if(isset($_FILES['image'])) {
            
            $this->_uploadProfileImage();
            $image = $this->_imageFileName;
        }
        if(isset($prof['profile'])) {
            $profile = $prof['profile'];
        }

        
        try {
            $sql =
            'UPDATE users
            SET image = :image, profile = :profile
            WHERE id = :id';

            $stmt = $this->_db->prepare($sql);
            $stmt->bindvalue(':image', $image, \PDO::PARAM_STR);
            $stmt->bindvalue(':profile', $profile, \PDO::PARAM_STR);
            $stmt->bindvalue(':id', $this->_id, \PDO::PARAM_STR);
            
            $stmt->execute();

        } catch(\Exceotion $e) {
            echo $e->getMessage();
            exit;
        }
        
        header('Location: user.php');
        exit;
        
    }

    private function _uploadProfileImage() {
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
        $savePath = USER_IMAGES_DIR . '/' . $this->_imageFileName;
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