<?php

namespace App;

class Signup {
    private $_db;
    private $_email;
    private $_password;
    private $_passCheck;

    //データベースに接続する
    public function __construct($email, $password, $password_check) {
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
    private function _checkDuplicate() {
        $account = $this->_db->prepare('SELECT COUNT(*) As cnt FROM users WHERE email=?');
		$account->execute([
			$this->_email
		]);
		$record = $account->fetch();
		if ($record['cnt'] > 0) { //重複があった場合のみtrueを返す
            return true;
            exit;
        }
        
        return false;
    }

    // 各エラーを値としてsignup.phpに返す
    public function getErrors() {
        $error = $this->_checkInput();

        if ($this->_checkDuplicate()) {
            $error['duplicate'] = true;
        }

        return $error;
    }


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

        $sql = 'INSERT users(email, password, created)
            VALUES (:email, :password, NOW())';
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([
            ':email' => $this->_email,
            ':password' => $hash,
        ]);

        $_SESSION['completed'] = true;
        //登録完了画面へ
        header('Location: ./completed.php');

    }
}