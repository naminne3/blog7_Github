// ユーザー登録画面
<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// ヘッダーを読み込み
include("templates/header.php");
?>

<h2>ユーザー登録</h2>

<form method="post" action="https://lifecareerdesign.sakura.ne.jp/kadai09_php/user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ユーザー登録</legend>
     <label>名前：<input type="text" name="name" required></label><br>
     <label>Login ID：<input type="text" name="lid" required></label><br>
     <label>Login PW<input type="password" name="lpw" required></label><br>
     <label>管理FLG：
      一般<input type="radio" name="kanri_flg" value="0" checked>　
      管理者<input type="radio" name="kanri_flg" value="1">
    </label>
    <br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>

<?php
// フッターを読み込み
include("templates/footer.php");
?>