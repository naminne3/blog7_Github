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
$article_id = $_POST["article_id"];
$comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8'); // サニタイズ処理

// データベースを更新
try {
    $stmt = $pdo->prepare("UPDATE comments SET comment = :comment WHERE id = :id");
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 更新成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    // 更新後に記事詳細ページにリダイレクト
    redirect("article.php?id=" . $article_id);
}
?>