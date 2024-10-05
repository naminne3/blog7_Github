// 記事投稿画面
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// セッションチェック (ログインユーザーのみアクセス可能にする場合)
sschk();

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>新規記事投稿</h2>

<form method="post" action="insert.php">
    <label for="title">タイトル:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="naiyou">本文:</label><br>
    <textarea id="naiyou" name="naiyou" rows="10" required></textarea><br><br>


    <label for="category">カテゴリ:</label><br>
    <select id="category" name="category_id">
        <?php
        try {
            $stmt = $pdo->prepare("SELECT * FROM categories");
            $status = $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category) {
                echo "<option value='" . h($category['id']) . "'>" . h($category['name']) . "</option>";
            }

        } catch (PDOException $e) {
            sql_error($e->getMessage());
        }
        ?>
    </select><br><br>
    
    <label for="hashtag">ハッシュタグ:</label><br>
    <input type="text" id="hashtag" name="hashtag"><br><br>

    <label for="memo">メモ:</label><br>
    <textarea id="memo" name="memo" rows="4" cols="40"></textarea><br><br>
    

    <input type="submit" value="投稿">
</form>

<?php
// フッターを読み込み
include("templates/footer.php");
?>