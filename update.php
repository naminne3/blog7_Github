<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

// POSTデータを取得
$id = $_POST["id"];
$title = $_POST["title"];
$naiyou = $_POST["naiyou"];
$hashtag = $_POST["hashtag"];
$hashtag = "#" . str_replace(" ", " #", $hashtag); // スペースを"#"に置換
$memo = $_POST["memo"];
$category_id = $_POST["category_id"]; // カテゴリIDを取得

// データベースを更新
try {
    $stmt = $pdo->prepare("UPDATE gs_an_table SET title = :title, naiyou = :naiyou, hashtag = :hashtag, memo = :memo, hashtag = :hashtag, category_id = :category_id WHERE id = :id"); 
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
    $stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT); // カテゴリIDをバインド
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 更新成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("https://lifecareerdesign.sakura.ne.jp/kadai09_php/index.php"); 
}
?>