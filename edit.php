// 記事編集画面
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

// 記事データを取得
try {
    $stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>記事編集</h2>

<form method="post" action="update.php">
    <label for="title">タイトル:</label><br>
    <input type="text" id="title" name="title" value="<?php echo h($article['title']); ?>" required><br><br>

    <label for="naiyou">本文:</label><br>
    <textarea id="naiyou" name="naiyou" rows="10" required><?php echo h($article['naiyou']); ?></textarea><br><br>

    <label for="category">カテゴリ:</label><br>
    <select id="category" name="category_id">
        <?php
        try {
            $stmt = $pdo->prepare("SELECT * FROM categories");
            $status = $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category) {
                $selected = ($category['id'] == $article['category_id']) ? ' selected' : ''; // 編集する記事のカテゴリが選択されている状態にする
                echo "<option value='" . h($category['id']) . "'" . $selected . ">" . h($category['name']) . "</option>";
            }

        } catch (PDOException $e) {
            sql_error($e->getMessage());
        }
        ?>
    </select><br><br>

    <label for="hashtag">ハッシュタグ:</label><br>
    <input type="text" id="hashtag" name="hashtag" value="<?php echo h($article['hashtag']); ?>"><br><br>

    <label for="memo">メモ:</label><br>
    <textarea id="memo" name="memo" rows="4" cols="40"><?php echo h($article['memo']); ?></textarea><br><br>

    <input type="hidden" name="id" value="<?php echo h($article['id']); ?>">
    <input type="submit" value="更新">
</form>

<?php
// フッターを読み込み
include("templates/footer.php");
?>