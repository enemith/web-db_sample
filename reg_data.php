<?php
require_once("db_head.php");
?>
<head>
  <title>登録画面</title>
</head>
<body>
  <?php
  // 現在日時を取得
  $cDateTime = "'".date('Y-m-d H:i:s')."'";
  // 作成日時と更新日時
  $keys = "created,modified,";
  // 作成日時と更新日時の値をセット
  $datas = $cDateTime.",".$cDateTime.",";

  // テーブル名をPOSTデータ配列のキー名から取得
  foreach ($_POST as $p_key => $p_array) {
    $table_name = $p_key;
  }

  foreach ($_POST[$table_name] as $b_key => $b_data) {
    // カラム名は''を削除、末尾にカンマ
    $keys .= $b_key.",";
    // 値は''で括って末尾にカンマ
    $datas .= "'".$b_data."',";
  }

  // 最後のカンマ除去
  $keys = rtrim($keys, ",");
  $datas = rtrim($datas, ",");

  // SQL文発行
  $resultInsBlock = $mysqli->query("INSERT INTO ".$table_name." (".$keys.") VALUES(".$datas.")");
  // エラーがあった場合
  if ($mysqli->error) {
    echo $mysqli->error."<br>";
    echo $table_name."<br>";
    echo $keys."<br>";
    echo $datas."<br>";
  }
  ?>
  <p>
    <a href="user_list.php">一覧に戻る</a>
  </p>
</body>
<?php
require_once("db_foot.php");
?>
