<!doctype html>
<html lang="ja">
<head>
  <title>ログイン画面</title>
</head>
<body>
  <h1>ログイン画面</h1>
  <?php
  // 認証エラーで押し戻されたら
  if ($_GET['error']==1) {
    echo "<h2>ユーザー名またはパスワードが違います</h2>";
  }
  ?>
  <form action="login_check.php" method="POST">
    <table>
      <tr>
        <td>アカウント</td>
        <td><input type="text" name="account" required></td>
      </tr>
      <tr>
        <td>パスワード</td>
        <td><input type="text" name="password" required></td>
      </tr>
    </table>
    <input type="submit" value="認証">
  </form>
</body>
</html>
