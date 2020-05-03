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

foreach ($_POST[$table_name] as $b_key => $b_data) {
  // カラム名は''を削除、末尾にカンマ
  $keys .= $b_key.",";

  // 今回は商品名と数量は配列で来るので
  if (is_array($b_data)) {
    foreach ($b_data as $data) {
      if ($data != "") { // 選択なしの場合""が届く、nullではないのでis_null判定は使えない
        if (is_numeric($data)) {
          $data_str = $data; // ''で括らない
        } else {
          $data_str = "'".$data."'"; // ''で括る
        }
        // キー名の配列を作って格納
        $data_ar[$b_key][] = $data_str;
      }
    }
  } else { // 配列でないデータ（user_id）
    if (is_numeric($b_data)) {
      $datas .= $b_data.","; // ''で括らない
    } else {
      $datas .= "'".$b_data."',"; // ''で括る
    }
  }
}

// 現在日時を取得
$cDate = "'".date('Y-m-d')."'";
$cTime = "'".date('H:i:s')."'";
// 販売日と販売時刻
$keys .= "sold_date,sold_time,";
// 販売日と販売時刻の値をセット
$datas .= $cDate.",".$cTime.",";

// レシート番号を生成
$keys .= "regist_no";
// セッションの店舗idからブロックidを引く
$BlockInfo = $mysqli->query("SELECT block_id FROM shop WHERE id=".$_SESSION['user_data']['shop_id']);
$rowBlock = $BlockInfo->fetch_assoc();
// レシート番号は「ブロック-店舗-現在時刻」
$regi_no = $rowBlock['block_id']."-".$_SESSION['user_data']['shop_id']."-".date('YmdHis');
$datas .= "'".$regi_no."'";

// 数量と商品idの数が合ってるかチェック
if (count($data_ar['item_id']) != count($data_ar['item_count'])) {
  // 数が合わなければ登録中止
  echo "商品名と数量の組み合わせが正しくありません";
  exit;
}

for ($i=0; $i < count($data_ar['item_id']) ; $i++) { // 商品idの要素数だけループ
  $data_tmp = $data_ar['item_id'][$i].",".$data_ar['item_count'][$i].",".$datas;
  // INSERT処理SQL文発行
  $setRegist = $mysqli->query("INSERT INTO ".$table_name." (".$keys.") VALUES(".$data_tmp.")");
  // echo "INSERT INTO ".$table_name." (".$keys.") VALUES(".$data_tmp.")";
  // echo "<hr>";
}

// エラーが合った場合
if ($mysqli->error) {
  echo $mysqli->error; // エラー内容を表示
  exit;
}

// データベースとの接続を切断
$mysqli->close();

// 入力画面にリダイレクト
// 画面に何か出力したあとではリダイレクトできないので注意
header('Location: sale.php');
exit;
?>
