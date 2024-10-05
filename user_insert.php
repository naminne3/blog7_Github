<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
// sschk(); // signup.php は誰でもアクセスできるように sschk() はコメントアウト

// POSTデータを取得
$name = filter_input(INPUT_POST, "name");
$lid = filter_input(INPUT_POST, "lid");
$lpw = filter_input(INPUT_POST, "lpw");
$kanri_flg = filter_input(INPUT_POST, "kanri_flg");
$lpw = password_hash($lpw, PASSWORD_DEFAULT); // パスワードをハッシュ化

// データベースに登録
try {
    $stmt = $pdo->prepare("INSERT INTO gs_user_table(name, lid, lpw, kanri_flg, life_flg) VALUES (:name, :lid, :lpw, :kanri_flg, 0)");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
    $stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 登録成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("https://lifecareerdesign.sakura.ne.jp/kadai09_php/login.php"); 
}


?>