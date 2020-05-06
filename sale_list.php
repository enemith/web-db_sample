<?php require_once("db_head.php"); ?>
<head>
  <title>レシート一覧画面</title>
  <style>
  table{
    border-collapse: collapse;
  }
  td{
    text-align: right;
  }
  </style>
</head>
<body>
  <div><a href="menu.php">メニューに戻る</a></div>
  <h2>フィルタリング設定</h2>
  <form method="GET" action="sale_list.php">
    <table>
      <tr>
        <td>ブロック</td>
        <td>
          <select name="block_id">
            <option value="">-</option>
            <?php
            // ブロックの一覧を取得 表示はブロック名、valueはブロックid
            $resultBlock = $mysqli->query("SELECT * FROM block");
            while ($rowBlock = $resultBlock->fetch_assoc()) {
              // もしフィルタリング指定があれば選択項目はselectedに
              if ($rowBlock['id'] == $_GET['block_id']) {
                $selected = " selected";
              } else {
                $selected = null;
              }
              echo "<option value=\"".$rowBlock['id']."\"".$selected.">".$rowBlock['block_name']."</option>";
            }
            ?>
          </select>
        </td>
        <td>&nbsp;</td>
        <td>販売日</td>
        <td>
          <?php
          if ($_GET['sold_date']) {
            $sold_date = " value=\"".$_GET['sold_date']."\"";
          } else {
            $selected = null;
          }
          echo "<input type=\"date\" name=\"sold_date\"".$sold_date.">";
          ?>
        </td>
        <td>&nbsp;</td>
        <td>
          <input type="submit" value="絞り込み">
        </td>
      </tr>
    </table>
  </form>

  <p>※販売日指定のinput type="date"はChrome以外では期待通りに動作しません</p>

  <h2>結果一覧</h2>
  <table border="1">
    <tr>
      <th>販売日</th>
      <th>レシート番号</th>
      <th>販売総数</th>
      <th>販売価格</th>
      <th>販売店</th>
      <th>販売担当</th>
    </tr>
    <?php
    // フィルタリング指定を格納する配列
    $whereArray = [];
    // GET引数で指定がある場合
    // ブロックの指定
    if ($_GET['block_id']) {
      $whereArray[] = " block_id=".$_GET['block_id'];
    }
    // 店舗の指定
    if ($_GET['shop_id']) {
      $whereArray[] = " shop_id=".$_GET['shop_id'];
    }
    // 販売日の指定
    if ($_GET['sold_date']) {
      $whereArray[] = " sale.sold_date='".$_GET['sold_date']."'";
    }

    // 何かの条件が入っていればWHERE句を生成
    if (count($whereArray) != 0) {
      $whereString = " WHERE ".implode(" AND ", $whereArray)." ";
    } else {
      $whereString = " ";
    }

    // 一覧表示用データを取得
    $resultSale = $mysqli->query(
      "SELECT *, SUM(item_count), user.name_a, shop.shop_name FROM sale ".
      "INNER JOIN user ON sale.user_id = user.id ".
      "INNER JOIN shop ON shop.id = user.shop_id ".
      "INNER JOIN block ON shop.block_id = block.id".
      $whereString.
      "GROUP BY regist_no"
    );

    while ($rowSale = $resultSale->fetch_assoc()) {
      // レシート内商品1件あたりの販売額を算出
      $resultPrice = $mysqli->query(
        "SELECT *, item.price FROM sale ".
        "INNER JOIN item ON sale.item_id = item.id ".
        "WHERE regist_no='".$rowSale['regist_no']."'"
      );
      // 小計格納変数、1品ごとに初期化
      $totalPrice = 0;
      while ($rowPrice = $resultPrice->fetch_assoc()) {
        // 個数とその商品の単価を掛け合わせて算出
        $totalPrice += ($rowPrice['price'] * $rowPrice['item_count']);
      }
      // 3桁ごとにカンマが入るように整形
      $totalPrice = number_format($totalPrice);

      echo "<tr>".PHP_EOL;
      echo "<td>".$rowSale['sold_date']."</td>";
      echo "<td>".$rowSale['regist_no']."</td>";
      echo "<td>".$rowSale['SUM(item_count)']."</td>";
      echo "<td>".$totalPrice."円</td>";
      echo "<td>".$rowSale['shop_name']."</td>";
      echo "<td>".$rowSale['name_a']."</td>";
      echo "</tr>".PHP_EOL;
    }
    ?>
  </table>
  <div><a href="menu.php">メニューに戻る</a></div>
</body>
<?php require_once("db_foot.php"); ?>
