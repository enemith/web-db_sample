<?php
// 接続
$mysqli = new mysqli("localhost", "root", "maria-password", "nsw");

if ($mysqli->connect_error) { // 接続エラー
  // エラー内容の出力
  echo $mysqli->connect_error;
  exit(); // ここで終了
} else { // 正常接続
  echo "<p>データベースに接続しました</p>";
}

// userテーブルのデータ件数を請求
$result = $mysqli->query("SELECT COUNT(*) AS cnt FROM user");
$row = $result->fetch_assoc();
echo htmlentities($row['cnt']."件のデータがあります");

// データベースとの接続を切断
$mysqli->close();
?>
