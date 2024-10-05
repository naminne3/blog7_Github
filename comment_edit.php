<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

// GETパラメータからコメントIDを取得
$id = $_GET["id"];

// コメントデータを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>コメント編集</h2>

<form method="post" action="comment_update.php">
    <input type="hidden" name="id" value="<?php echo h($comment['id']); ?>">
    <input type="hidden" name="article_id" value="<?php echo h($comment['article_id']); ?>">
    <label for="comment">コメント:</label><br>
    <textarea id="comment" name="comment" rows="5" required><?php echo h($comment['comment']); ?></textarea><br><br>
    <input type="submit" value="更新">
</form>

<?php
// フッターを読み込み
include("templates/footer.php");
?>