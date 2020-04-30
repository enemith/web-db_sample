<?php require_once("db_head.php"); ?>
<head>
  <title>編集画面</title>
</head>
<body>
  <h1>データ確認/修正</h1>
  <?php
  // 対象テーブル名をPOSTデータ配列のキー名から取得
  foreach ($_POST as $p_key => $p_array) {
    if ($p_key != "mode") { // 記録モードを示すキーは無視
      $table_name = $p_key;
    }
  }

  // 対象のデータのidを取得
  $target_id = $_POST[$table_name]['id'];

  // 記録モードでこのページに来た時
  if ($_POST['mode'] == "upd") {
    $sql = "UPDATE ".$table_name." SET ";
    foreach ($_POST[$table_name] as $u_key => $u_val) {
      if ($u_key != "id") { // idは上書きしないので無視
        $sql .= $u_key."='".$u_val."',";
      }
    }
    // 更新日時をセット
    $sql .= "modified='".date("Y-m-d H:i:m")."'";
    // idでデータを限定
    $sql .= " WHERE id=".$target_id;
    // SQL文発行
    $resultInsBlock = $mysqli->query($sql);

    // エラーがあった場合
    if ($mysqli->error) {
      echo $mysqli->error; // エラー内容を表示
    }

    echo "<hr><h2>データを更新しました</h2></hr>";
  } // 記録モード終端

  // 以下は一覧から来た場合と記録更新後のデータ表示

  // 指定されたテーブルのカラム情報を取得
  $resultColumn = $mysqli->query("SHOW FULL COLUMNS FROM ".$table_name);
  // 各カラムのコメントを取得
  $commentList = []; // コメント格納用変数
  while ($rowColumn = $resultColumn->fetch_assoc()) {
    // 取得したコメントをカラム名キーにして配列に格納
    // これで$commentList['block_name'] = "ブロック名";のようになる
    $commentList[$rowColumn['Field']] = $rowColumn['Comment'];
  }
  ?>
  <table>
    <form method="POST" action="edit_data.php"><!--自分自身にPOST送信-->
      <!--記録モードフラグ-->
      <input type="hidden" name="mode" value="upd">
      <?php
      // 指定されたテーブルにある指定idのデータを取得
      $resultBlock = $mysqli->query("SELECT * FROM ".$table_name." WHERE id=".$target_id);
      $rowBlock = $resultBlock->fetch_assoc();

      // 表示処理
      foreach ($commentList as $cl_k => $cl_v) {
        echo "<tr>";
        if ($cl_k == 'id' || $cl_k == 'created' || $cl_k=='modified') { // idと作成日時、更新日時は編集させてはいけない
          echo "<td>".$cl_v."</td>";
          echo "<td>".$rowBlock[$cl_k]."</td>";
          if ($cl_k=='id') {
            echo "<input type=\"hidden\" name=\"".$table_name."[id]\" value=\"".$rowBlock['id']."\">";
          }
        } else { // それ以外は編集可能
          echo "<td>".$cl_v."</td>";
          echo "<td><input type=\"text\" name=\"".$table_name."[".$cl_k."]\"value=\"".$rowBlock[$cl_k]."\" required></td>";
        }
        echo "</tr>";
      }
      ?>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="更新"></td>
      </tr>
    </form>
  </table>

  <p><a href="user_list.php">一覧に戻る</p>
</body>
<?php require_once("db_foot.php"); ?>
