<?php
$dsn='mysql:dbname=php_db_app;host=localhost;charset=utf8mb4';
$user='root';
$password='';

if(isset($_GET['id']))
{

try
{
  $pdo=new PDO($dsn, $user, $password);

  $sql_select_product='SELECT*FROM products WHERE id= :id';
  $stmt_select_product=$pdo->prepare($sql_select_product);

  $stmt_select_product->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
  
  $stmt_select_product->execute();

  $product=$stmt_select_product->fetch(PDO::FETCH_ASSOC);

  if($product===FALSE)
  {
    exit('idパラメータの値が不正です。');

  }

  $sql_select_vendor_codes='SELECT vendor_code FROM vendors';

  $stmt_select_vendor_codes=$pdo->query($sql_select_vendor_codes);

  $vendor_codes=$stmt_select_vendor_codes->fetchAll(PDO::FETCH_COLUMN);
  
}
catch(PDOException $e)
{
exit($e->getMessage());
}
}
else
{
  exit('idパラメータの値が存在しません。');
}

?>

<!DOCTYPE html>

<html lang="ja">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品編集</title>
  <link rel="stylesheet" href="css/style.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>


<body>
  <header>
    <nav>
      <a href="index.php">商品管理アプリ</a>
    </nav>
  </header>
  <main>
    <article class="registration">
      <h1>商品編集</h1>
      <div class="back">
        <a href="read.php" class="btn">&lt; 戻る</a>

      </div>

      <form action="update.php?if=<?=$_GET['id']?>" method="post" class="registration-form">
      
      <div>
          <label for="product_code">商品コード</label>
          <input type="number" name="product_code" min="0" max="100000000" required>

          <label for="product_name">商品名</label>
          <input type="text" name="product_name" maxlength="50" required>

          <label for="price">単価</label>
          <input type="number" name="price" min="0" max="100000000" required>

          <label for="stock_quantity">在庫数</label>
          <input type="number" name="stock_quantity" min="0" max="100000000" required>

          <label for="vendor_code">仕入先コード</label>
          <select name="vendor_code" required>
            <option disabled selected value>選択してください</option>

            <?php

            foreach($vendor_codes as $vendor_code)
            {
              if($vendor_code===$product['vendor_code'])
              {
                echo "<option value='{$vendor_code}' selected>{$vendor_code}</option>";
              }
              else
              {
                echo"<option value='{$vendor_code}'>{$vendor_code}</option>";

              }
              echo "<option value='{$vendor_code}'>{$vendor_code}</option>";

            }
            ?>


          </select>

        </div>

        <button type="submit" class="sumbit-btn" name="submit" value="create">更新</button>
      </form>
    </article> 
  </main>

  <footer>
    <p class="copyright">&copy;商品管理アプリ All rights reserved </p>
  </footer>

</body>

</html>
