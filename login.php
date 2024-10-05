// ログイン画面
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>ログイン</h2>

<?php if (isset($_SESSION["error_message"])) : ?>
    <p style="color: red;"><?php echo h($_SESSION["error_message"]); ?></p>
    <?php unset($_SESSION["error_message"]); ?> 
<?php endif; ?>

<form name="form1" action="login_act.php" method="post">
    ID:<input type="text" name="lid" required><br>
    PW:<input type="password" name="lpw" required><br>
    <input type="submit" value="ログイン">
</form>

<?php
// フッターを読み込み
include("templates/footer.php");
?>