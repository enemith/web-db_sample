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
  <h1>ユーザー一覧</h1>
  <p><?php
  // userテーブルのデータ件数を請求
  $resultCount = $mysqli->query("SELECT COUNT(*) AS cnt FROM user");
  $rowCount = $resultCount->fetch_assoc();
  echo htmlentities($rowCount['cnt']."件のデータがあります");
  $resultCount->free();
   ?></p>
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
</body>
<?php
  require_once("db_foot.php");
?>
