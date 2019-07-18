<?php

namespace App;

class Login {
    private $_db;
    private $_email;
    private $_password;

    //データベースに接続する
    public function __construct($email, $password) {
        $this->_email = $email;
        $this->_password = $password;

        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

     /* アカウントの存在をチェック

    */
    private function _checkAccount() {
        $stmt = $this->_db->prepare('SELECT COUNT(*) As cnt FROM users WHERE email=?');
		$stmt->execute([
			$this->_email
		]);
		$record = $stmt->fetch();
		if ((int)$record['cnt'] === 0) { //アカウントが存在しない場合のみtrueを返す
            return true;
            exit;
        }
        
        return false;
    }

    // パスワードが合っているかチェック
    private function _checkPassword() {
        $stmt = $this->_db->prepare('SELECT * FROM users WHERE email =?');
		$stmt->execute([$this->_email]);
		$user = $stmt->fetch(\PDO::FETCH_ASSOC);
		if (!password_verify($this->_password, $user['password'])) {
            return true;
            exit;
        }
        
        return false;
    }

    // 各エラーを値としてsignup.phpに返す
    public function getErrors() {
        if($this->_checkAccount()) {
            $error['email'] = true;
        } elseif($this->_checkPassword()) {
            $error['password'] = true;
        }

        if(!empty($error)) {
            return $error;
        }
    }

    // ログイン処理
    public function login() {

        $sql = 'select * from users where email = ?';
        $stmt = $this->_db->prepare($sql);
        var_dump($stmt->bindvalue(':email', $this->_email, \PDO::PARAM_STR));
        exit;
        
        $stmt->execute();
        $user = $stmt->fetch();


        // アカウント情報をセッションに保持
        // メイン画面でログイン情報を使うため
        if($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['time'] = time();
        
        // メイン画面へ
        header('Location: index.php');
        }
    }
}