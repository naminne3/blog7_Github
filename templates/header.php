<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブログシステム</title>
    <link rel="stylesheet" href="css/style.css">  
</head>
<body>

<header>
    <h1><a href="index.php">ブログシステム</a></h1>
    <?php if (isset($_SESSION["name"])) : ?>
        <p>ようこそ、<?php echo h($_SESSION["name"]); ?>さん！</p>
        <a href="logout.php">ログアウト</a>
    <?php else : ?>
        <a href="login.php">ログイン</a>
        <a href="signup.php">ユーザー登録</a>
    <?php endif; ?>
</header>

<main>