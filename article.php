// 記事詳細表示
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
// sschk(); 

// GETパラメータから記事IDを取得
$id = $_GET["id"];

// 記事データを取得
try {
    // カテゴリテーブルを結合してカテゴリ名を取得
    $stmt = $pdo->prepare("SELECT a.*, c.name AS category_name FROM gs_an_table a LEFT JOIN categories c ON a.category_id = c.id WHERE a.id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}


// 現在の記事IDを取得
$current_id = $article['id'];

// 前の記事を取得
try {
    $stmt = $pdo->prepare("SELECT id, title FROM gs_an_table WHERE id < :current_id ORDER BY id DESC LIMIT 1");
    $stmt->bindValue(':current_id', $current_id, PDO::PARAM_INT);
    $stmt->execute();
    $prev_article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// 次の記事を取得
try {
    $stmt = $pdo->prepare("SELECT id, title FROM gs_an_table WHERE id > :current_id ORDER BY id ASC LIMIT 1");
    $stmt->bindValue(':current_id', $current_id, PDO::PARAM_INT);
    $stmt->execute();
    $next_article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}


// ヘッダーを読み込み
include("templates/header.php");
?>

<h2><?php echo h($article['title']); ?></h2>

<p>投稿日: <?php echo h($article['indate']); ?></p>

<p><?php echo h($article['naiyou']); ?></p>

<?php if (!empty($article['hashtag'])) : ?>
    <p>ハッシュタグ: <?php echo h($article['hashtag']); ?></p>
<?php endif; ?>  

<?php if (!empty($article['category_name'])) : ?>
    <p>カテゴリ: <?php echo h($article['category_name']); ?></p> <div class="category">
<?php endif; ?>

<?php if (isset($_SESSION["kanri_flg"]) && $_SESSION["kanri_flg"] == 1) : ?>

    <a href="https://lifecareerdesign.sakura.ne.jp/kadai09_php/edit.php?id=<?php echo h($article['id']); ?>">編集</a>
    <a href="delete.php?id=<?php echo h($article['id']); ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
<?php endif; ?>


<!-- 次へ前へボタン -->
<div class="navigation">
<?php if ($prev_article) : ?>
    <a href="article.php?id=<?php echo h($prev_article['id']); ?>">< 前の記事</a> 
<?php endif; ?>

<?php if ($next_article) : ?>
    <a href="article.php?id=<?php echo h($next_article['id']); ?>">次の記事 ></a>
<?php endif; ?>
</div>


<h3>コメント</h3>


<?php if (isset($_SESSION["chk_ssid"])) : ?> <div class="comment">
    <p>ようこそ、<?php echo h($_SESSION["name"]); ?>さん！</p> <div class="user-name">
    <form method="post" action="comment_insert.php">
        <input type="hidden" name="article_id" value="<?php echo h($article['id']); ?>">
        <input type="hidden" name="name" value="<?php echo h($_SESSION["name"]); ?>"> <div class="hidden-name">
        <label for="comment">コメント:</label><br>
        <textarea id="comment" name="comment" rows="5" required></textarea><br><br>
        <input type="submit" value="投稿">
    </form>
<?php else : ?>
    <p>コメントするには、<a href="login.php">ログイン</a>してください。</p> <div class="login-comment">
<?php endif; ?>



<?php
// コメントデータを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at ASC");
    $stmt->bindValue(':article_id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}
?>



<?php if (count($comments) > 0) : ?>
<ul>
    <?php foreach ($comments as $comment) : ?>
        <li>
            <p><strong><?php echo h($comment['name']); ?></strong> - <?php echo h($comment['created_at']); ?></p>
            <p><?php echo h($comment['comment']); ?></p>
            <?php if (isset($_SESSION["chk_ssid"]) && $_SESSION["name"] == $comment['name']) : ?> 
                <a href="comment_edit.php?id=<?php echo h($comment['id']); ?>">編集</a> |  
                <a href="comment_delete.php?id=<?php echo h($comment['id']); ?>&article_id=<?php echo h($article['id']); ?>" onclick="return confirm('本当に削除しますか？');">削除</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php else : ?>
    <p>コメントはまだありません。</p>
<?php endif; ?>



<?php
// フッターを読み込み
include("templates/footer.php");
?>