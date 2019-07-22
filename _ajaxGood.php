<?php
session_start();

require_once(__DIR__ . '/core/config.php');

$db;
$postId = (int)$_POST['postId'];
$userId = (int)$_SESSION['id'];

if($postId) {
    // データベースに接続
    try {
        $db = new PDO(DSN, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    try {
        goodFunc();
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

function goodFunc() {
    try {
        $goodFlg = goodFlg();
        if($goodFlg > 0) {
            goodDelete();
        } else {
            goodAdd();
        }

    } catch (Eception $e) {
    }
}

function goodAdd() {
    global $db;
    global $postId;
    global $userId;
    
    $sql = 'INSERT INTO good (post_id, user_id, created) VALUES (:p_id, :u_id, NOW())';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':p_id', $postId, PDO::PARAM_INT);
    $stmt->bindvalue(':u_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function goodDelete() {
    global $db;
    global $postId;
    global $userId;

    $sql = 'DELETE FROM good WHERE post_id = :p_id AND user_id = :u_id';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':p_id', $postId, PDO::PARAM_INT);
    $stmt->bindvalue(':u_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function goodFlg() {
    global $db;
    global $postId;
    global $userId;

    $sql = 'SELECT * FROM good WHERE post_id = :p_id AND user_id = :u_id';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':p_id', $postId, PDO::PARAM_INT);
    $stmt->bindvalue(':u_id', $userId, PDO::PARAM_INT);
    
    $stmt->execute();

    $count = $stmt->rowCount();

    return $count;
}