<?php

namespace App;

class Signup {
    private $_db;
    private $_name;
    private $_email;
    private $_password;
    private $_passCheck;

    //データベースに接続する
    public function __construct($name, $email, $password, $password_check) {
        $this->_name = $name;
        $this->_email = $email;
        $this->_password = $password;
        $this->_passCheck = $password_check;
        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }


    /*フォームの値をチェック
        $error['email'] 空欄時のエラー
        $error['password'] 空欄、文字数4以下のエラー 
        $error['password_check'] パスワード入力ミスのエラー
    */
    private function _checkInput() {
        if(mb_strlen($this->_name) > 21 ||
        $this->_name === "") {
            $error['name'] = true;
        }
        if($this->_email === "") {
            $error['email'] = true;
        }
        if(strlen($this->_password) < 4 ||
          $this->_password === "") {
            $error['password'] = true;
        } elseif ($this->_passCheck !== $this->_password) { //一回目のパスワードの入力が正しい場合のみ再入力チェックする
            $error['password_check'] = "unmatch";
        }

        if(isset($error)) { //いずれかのエラーがあった場合のみ返す
            return $error;
        }
    }

    /* アカウントの重複チェック
        入力されたメールアドレスのレコードを抽出する
        0ならまだ登録されていないアカウント
        1なら登録済みのアカウントと判定
    */
    private function _checkDuplicateEmail() {
        $stmt = $this->_db->prepare('SELECT count(*) As cnt FROM users WHERE email = ?');

        $stmt->execute([$this->_email]);
        
        $record = $stmt->fetch();
        
		if ($record['cnt'] > 0) { //重複があった場合のみtrueを返す
            return true;
            exit;
        }
        
        return false;
    }

    /* ユーザー名の重複チェック
        入力されたユーザー名のレコードを抽出する
        0ならまだ登録されていないアカウント
        1なら登録済みのアカウントと判定
    */
    private function _checkDuplicateName() {
        $stmt = $this->_db->prepare('SELECT count(*) As cnt FROM users WHERE name = ?');

        $stmt->execute([$this->_name]);
        
        $record = $stmt->fetch();
        
		if ($record['cnt'] > 0) { //重複があった場合のみtrueを返す
            return true;
            exit;
        }
        
        return false;
    }

    // 各エラーを値としてsignup.phpに返す
    public function getErrors() {
        $error = $this->_checkInput();

        if ($this->_checkDuplicateEmail()) {
            $error['duplicate']['email'] = true;
        } ;
        if ($this->_checkDuplicateName()) {
            $error['duplicate']['name'] = true;
        };

        return $error;
    }


    // DB保存前にパスワードはハッシュ化
    private function _passwordHash() {
        $hash = password_hash($this->_password, PASSWORD_BCRYPT);

        return $hash;
    }
    
    /*アカウント登録処理
        email
        password
        登録日時
        をデータベースに保存
    */
    public function accountRegister() {
        $hash = $this->_passwordHash();

        try {
            $sql = 'INSERT users(name, email, password, created)
                VALUES (:name, :email, :password, NOW())';
            $stmt = $this->_db->prepare($sql);
            
            $stmt->bindvalue(':name', $this->_name, \PDO::PARAM_STR);
            $stmt->bindvalue(':email', $this->_email, \PDO::PARAM_STR);
            $stmt->bindvalue(':password', $hash, \PDO::PARAM_STR);

            $stmt->execute();

            $_SESSION['completed'] = true;
            //登録完了画面へ
            header('Location: ./completed.php');
            exit;
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

    }
}