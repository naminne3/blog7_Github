//データベースに送る

<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

/// POSTデータを取得
$title = $_POST["title"];
$naiyou = $_POST["naiyou"];
$hashtag = $_POST["hashtag"];
$hashtag = "#" . str_replace(" ", " #", $hashtag);
$memo = $_POST["memo"];
$category_id = $_POST["category_id"]; // カテゴリIDを取得

// データベースに登録
try {
    $stmt = $pdo->prepare("INSERT INTO gs_an_table(title, naiyou, hashtag, memo, indate, category_id) VALUES (:title, :naiyou, :hashtag, :memo, sysdate(), :category_id)");
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':hashtag', $hashtag, PDO::PARAM_STR);
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT); // カテゴリIDをバインド
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 登録成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("index.php");
}
?>