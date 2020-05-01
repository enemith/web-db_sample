<?php
// ユーザー認証
session_start(); // セッションの利用開始
// 認証していない=セッションにユーザ名がない
if (!isset($_SESSION['user_name'])) {
  header('Location: login.php');
}

// 接続
$mysqli = new mysqli("localhost", "root", "maria-password", "nsw");

if ($mysqli->connect_error) { // 接続エラー
  // エラー内容の出力
  echo $mysqli->connect_error;
  exit(); // ここで終了
} // 接続に成功したらという処理は入れない

// 文字コードの指定
$result = $mysqli->query("set names utf8;");
// テイムゾーンの指定
date_default_timezone_set('Asia/Tokyo');

// テーブル名をPOSTデータ配列のキー名から取得
foreach ($_POST as $p_key => $p_array) {
  $table_name = $p_key;
}

$data_ar = [];

print_r($_POST);
?>
