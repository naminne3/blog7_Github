<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// POSTデータを取得
$article_id = $_POST["article_id"];
$name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');  // サニタイズ処理を追加
$comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');  // サニタイズ処理を追加


// データベースに登録
try {
    $stmt = $pdo->prepare("INSERT INTO comments(article_id, name, comment) VALUES (:article_id, :name, :comment)");
    $stmt->bindValue(':article_id', $article_id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 登録成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    // コメント投稿後に元のページにリダイレクト
    redirect("article.php?id=" . $article_id);
}
?>