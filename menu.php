<?php
require_once("db_head.php");
?>
<head>
  <title>メニュー画面</title>
</head>
<body>
  <?php
  // テーブルから取得した他のデータは$_SESSION['user_data']['カラム名']で参照可能
  echo "<h1>".$_SESSION['user_data']['name_a']."さんのメニュー</h1>";
  ?>
  <a href="user_list.php">データ一覧</a>
  <a href="sale.php">購入</a>
  <a href="sale_list.php">レシート一覧</a>
  <hr>
  <a href="logout.php">ログアウト</a>
</body>
<?php
require_once("db_foot.php");
?>
