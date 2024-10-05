// ログアウト処理
<?php
// セッション開始
session_start();

// functions.php を読み込む
include("includes/functions.php");

// セッション変数を全て削除
$_SESSION = array();

// セッションクッキーを削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// セッションを破棄
session_destroy();

// ログインページにリダイレクト
redirect("login.php"); 
?>