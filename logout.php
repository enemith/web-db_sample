<?php
// ユーザー認証
session_start(); // セッションの利用開始
// 判定に使っていたセッションデータの消去
unset($_SESSION['user_name']);
// ユーザー情報セッションデータの消去
unset($_SESSION['user_data']);

// ログイン画面にリダイレクト
header('Location: login.php');
exit;
?>
