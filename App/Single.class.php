<?php

namespace App;

class Single {
    private $_db;
    private $_post_id;
    private $_user_name;
    
    public function __construct() {

        $this->_post_id = (int)$_GET['postid'];

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
    public function getMainPost() {
        $sql = 
        'SELECT u.name, u.profile, u.image, p.*
        FROM users u, posts p 
        WHERE u.id = p.user_id
        AND p.id = :post_id';

        $stmt = $this->_db->prepare($sql);
        $stmt->bindvalue(':post_id', $this->_post_id, \PDO::PARAM_INT);
		$stmt->execute();
        $post = $stmt->fetch(\PDO::FETCH_OBJ);
        
        return $post;
    }

    // 表示中ユーザーの記事一覧を取得
    public function getResPosts() {
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

        if($_FILES['image']['name']) {
            $this->_uploadProfileImage();
            $this->_updateProfileImage();
        }

        if(isset($prof['profile'])) {
            $this->_updateProfile($prof['profile']);
        }
        
        header('Location: user.php');
        exit;
        
    }
}