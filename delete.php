// 記事削除処理
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

// GETパラメータから記事IDを取得
$id = $_GET["id"];

// データベースから削除
try {
    $stmt = $pdo->prepare("DELETE FROM gs_an_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 削除成功時の処理
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("index.php");
}
?>