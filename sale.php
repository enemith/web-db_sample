<?php
require_once("db_head.php");
?>
<head>
<style>
th{
  padding-left: 1em;
}
td{
  padding-left: 1em;
  text-align: right;
}
td input{
  text-align: right;
}
</style>
<script
  src="https://code.jquery.com/jquery-3.5.0.js"
  integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc="
  crossorigin="anonymous"></script>
</head>
<body>
  <form method="POST" action="sale_reg.php">
    <table>
      <tr>
        <th class="caption">商品</th>
        <th class="caption">個数</th>
        <th class="caption">小計</th>
      </tr>
      <?php for ($i=0; $i < 3 ; $i++) : // 3回の繰り返し ?>
        <tr>
          <td>
            <select name="sale[item_id]" id="sel_<?php echo $i; ?>">
              <option value="">-</option>
              <?php
              // itemテーブルから品名とIDを取得
              $resultItem = $mysqli->query("SELECT * FROM item");
              while ($rowItem = $resultItem->fetch_assoc()) {
                echo "<option value=\"".$rowItem['id']."\" data-price=\"".$rowItem['price']."\">".$rowItem['name']."</option>";
              }
              ?>
            </select>
          </td>
          <td data-test="x"><input type="number" style="width:4em;" name="sale[item_count][]" class="input_price" data-index="<?php echo $i;?>">個</td>
          <td><span id="subtotal_<?php echo $i; ?>" class="subtotal">0</span>円</td>
        </tr>
      <?php endfor; // 繰り返し終端?>
    </table>
    <hr>
    <p>合計金額 <span id="total_price">0円</span></p>
    <input type="hidden" name="user[user_id]" value="<?php echo $_SESSION['user_data']['id']; ?>">
    <input type="submit" value="登録">
  </form>

  <script>
  $(function(){
    $('.input_price').on('change', function(){
      var ind = $(this).data('index');
      var sind = $('#sel_' + ind).prop("selectedIndex");
      var single_price = $('#sel_0 option').eq(sind).data('perice');
      var subtotal = single_price * $(this).val();
      var total_price = 0;

      $('#subtotal_' + ind).text(subtotal);
      $('.subtotal').each(function(index, element){
        total_price += Number($(this).text());
      });
      $('#total_price').text(total_price);
    });
  });
  </script>
</body>
<?php
require_once("db_foot.php");
?>
