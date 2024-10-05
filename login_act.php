<?php
// セッション開始
session_start();

// データベース接続
include("includes/db_connect.php");
include("includes/functions.php");

// POST値を取得
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

// データベースからユーザー情報を取得
try {
    $stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid = :lid");
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $status = $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    sql_error($e->getMessage());
}

// ログイン処理
if ($user && password_verify($lpw, $user["lpw"])) {
    // ログイン成功
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanri_flg"] = $user['kanri_flg'];
    $_SESSION["name"] = $user['name'];
    redirect("index.php"); // ログイン成功後にリダイレクトするページを指定
} else {
    // ログイン失敗
    $_SESSION["error_message"] = "ログインIDまたはパスワードが間違っています。";
    redirect("login.php");
}
?>