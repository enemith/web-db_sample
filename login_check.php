<?php
  // ユーザー認証
  session_start(); // セッションの利用開始

  // 接続
  $mysqli = new mysqli("localhost", "root", "maria-password", "nsw");
  if ($mysqli->connect_error) { // 接続エラー
    // エラー内容の出力
    echo $mysqli->connect_error;
    exit(); // ここで終了
  } // 接続に成功したらという処理は入れない

  // 文字コードの指定
  $result = $mysqli->query("set names utf8");
  // タイムゾーンの指定
  date_default_timezone_set('Asia/Tokyo');

  // 入力された値をテーブルと比較して合致数を出す
  $checkLogin = $mysqli->query("SELECT COUNT(*) AS checkFlg FROM user WHERE account='".$_POST['account']."' AND password='".$_POST['password']."'");
  $row = $checkLogin->fetch_assoc();

  if ($row['checkFlg'] != 1) { // 合致が1件でなければ認証エラー
    // ログイン画面に飛ばす
    header('Location: login.php?error=1');
    exit();
  } else {
    // セッションに書き出すための情報をDBから取得
    $userCheck = $mysqli-> query("SELECT * FROM user WHERE account='".$_POST['account']."' AND password='".$_POST['password']."'");
    // 1件しかないことがわかっているのでwhileはいらない
    $row = $userCheck->fetch_assoc();
    // セッションに書き出し
    $_SESSION['user_name'] = $row['name_a'].$row['name_b'];
    // その他のデータを丸ごと$_SESSION['user_data']に入れてしまう
    $_SESSION['user_data'] = $row;

    // メニュー画面に飛ばす
    header('Location: menu.php');
    exit();
  }
?>
