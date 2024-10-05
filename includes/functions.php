// 共通関数

<?php
// XSS対策 (HTMLエスケープ処理)
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

// SQLエラー処理
function sql_error($stmt) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

// リダイレクト
function redirect($file_name) {
    header("Location: ".$file_name);
    exit();
}

// セッションチェック
function sschk() {
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}
?>