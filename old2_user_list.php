<?php
  require_once("db_head.php");
?>
<head>
  <title>ユーザー一覧</title>
  <style>
    table {
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px #000 solid;
    }
  </style>
</head>
<body>
  <h2>ブロック一覧</h2>
  <p><?php
  // blockテーブルのデータ件数を請求
  $resultCountBlock = $mysqli->query("SELECT COUNT(*) AS cnt FROM block");
  $rowCountBlock = $resultCountBlock->fetch_assoc();
  echo htmlentities($rowCountBlock['cnt']."件のデータがあります");
  $resultCountBlock->free();
  ?></p>
  <h3>新規登録</h3>
  <table border="1">
    <form action="reg_data.php" method="POST">
      <tr>
        <th>ブロック番号</th>
        <th>ブロック名</th>
        <th>ブロック名かな</th>
        <th>作成日時</th>
        <th>更新日時</th>
        <th>&nbsp;</th>
      </tr>
      <tr>
        <td>-自動連番-</td>
        <td><input type="text" name="block[block_name]" required></td>
        <td><input type="text" name="block[block_kana]" required></td>
        <td>-自動取得-</td>
        <td>-自動取得-</td>
        <td><input type="submit" value="新規登録"></td>
      </tr>
    </form>
  </table>
  <br>

  <?php if($rowCountBlock['cnt']): // もし件数が1件でもあれば ?>
  <h3>データ一覧</h3>
  <p>あとで本実装</p>
  <?php endif; ?>

  <br>
  <hr>

  <h2>店舗一覧</h2>
  <p><?php
  // shopテーブルのデータ件数を請求
  $resultCountShop = $mysqli->query("SELECT COUNT(*) AS cnt FROM shop");
  $rowCountShop = $resultCountShop->fetch_assoc();
  echo htmlentities($rowCountShop['cnt']."件のデータがあります");
  $resultCountShop->free();
  ?></p>
  <h3>新規登録</h3>
  <?php if($rowCountBlock['cnt']==0): // もしブロック登録が1件もなければ ?>
  <p>!! 先にブロックのデータを登録してください !!</p>
  <?php else: ?>
  <p>あとで本実装</p>
  <?php endif; ?>
  <br>

  <?php if($rowCountShop['cnt']): // もし件数が1件でもあれば ?>
  <h3>データ一覧</h3>
  <p>あとで本実装</p>
  <?php endif; ?>

  <br>
  <hr>

  <h2>ユーザー一覧</h2>
  <p><?php
  // userテーブルのデータ件数を請求
  $resultCountUser = $mysqli->query("SELECT COUNT(*) AS cnt FROM user");
  $rowCountUser = $resultCountUser->fetch_assoc();
  echo htmlentities($rowCountUser['cnt']."件のデータがあります");
  $resultCountUser->free();
  ?></p>
  <h3>新規登録</h3>
  <?php if($rowCountShop['cnt']==0): // もし店舗登録が1件もなければ ?>
  <p>!! 先に店舗のデータを登録してください !!</p>
  <?php else: ?>
  <p>あとで本実装</p>
  <?php endif; ?>
  <br>

  <?php if($rowCountUser['cnt']): // もし件数が1件でもあれば ?>
  <h3>データ一覧</h3>
  <table border="1">
     <tr>
       <th>ユーザー番号</th>
       <th>アカウント</th>
       <th>パスワード</th>
       <th>姓名</th>
       <th>ふりがな</th>
       <th>権限</th>
       <th>所属店舗</th>
       <th>作成日時</th>
       <th>更新日時</th>
     </tr>
     <?php
     // userテーブルの全データを請求
     $resultUser = $mysqli->query("SELECT * FROM user");
     while ($rowUser = $resultUser->fetch_assoc()) {
       echo "<tr>";
       echo "<td>".$rowUser['id']."</td>";
       echo "<td>".$rowUser['account']."</td>";
       echo "<td>".$rowUser['password']."</td>";
       // 姓名は連結して表示
       echo "<td>".$rowUser['name_a']." ".$rowUser['name_b']."</td>";
       // かなも連結
       echo "<td>".$rowUser['kana_a']." ".$rowUser['kana_b']."</td>";
       // 権限はテキストに置き換え
       if ($rowUser['permit']==1) {
         echo "<td>管理者</td>";
       } else {
         echo "<td>一般</td>";
       }
       echo "<td>".$rowUser['shop_id']."</td>";
       echo "<td>".$rowUser['created']."</td>";
       echo "<td>".$rowUser['modified']."</td>";
       echo "</tr>";
     }
    $resultUser->free();
    ?>
  </table>
  <?php endif; ?>
  <br><br><br>
</body>
<?php
  require_once("db_foot.php");
?>
