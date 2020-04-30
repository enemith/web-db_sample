<?php
  // ユーザー認証
  session_start(); // セッションの利用開始
  // 認証していない=セッションにユーザー名がない
  if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
  }

  // 接続
  $mysqli = new mysqli("localhost", "root", "maria-password", "nsw");

  if($mysqli->connect_error) { // 接続エラー
    // エラー内容の出力
    echo $mysqli->connect_error;
    exit(); // ここで終了
  }
  // 文字コードの指定
  $result = $mysqli->query("set names utf8");
  // タイムゾーンの指定
  date_default_timezone_set('Asia/Tokyo');
?><!doctype html>
<html lang="ja">
