<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  try {
    $staff_code = $_POST['staffcode'];

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8'; // DSN: Data Source Name
    $user = 'root';
    $password = '';
    // PDOクラスのインスタンス化（引数にデータベースの接続に必要な情報を記述）
    // PDO:PHP Data Objects
    // PDOは、どのデータベースを使っているかを隠蔽してくれる。どのデータベースを利用する場合でも同じ関数をつかうことができる。
    // DBH:Data Base Handle
    // Handle：コンピュータなどのソフトウエアの世界では一般的に「ハンドル」とは、あるオブジェクトや機能など(=この場合データベース)を操作するためのキーや、そのものを示す
    // ハンドル：英語で、ある何かを操作することをHandle(ハンドル)、操作する人(者)のことをHandler(ハンドラー)といいますが、これが語源です。ご指摘のWebページで「車のハンドルと同じ」と言われているのはそのためと思います。つまり、あるものを操作するためのID、あるいは、あるものを示すためのIDのことがハンドルなので、この場合データベースを操作するために使われるもの＝データベースハンドル、ということになります。
    $dbh = new PDO($dsn, $user, $password);
    // データベースに接続した後にオプションを指定
    // 属性をセット
    // ATTR_ERRMODE:エラーレポート
    // ERRMODE_EXCEPTION:例外を投げる
    // エラーが発生した時に、PDOExceptionの例外を投げてくれる。
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データを取得
    // ?には、data[]にて、データをセットする。
    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_code;
    $stmt->execute($data);

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name = $rec['name'];

    $dbh = null;
  } catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>

  スタッフ修正<br />
  <br />
  スタッフコード<br />

  <?php print $staff_code; ?>
  <br />
  <br />
  <form action="staff_edit_chick/php" method="post">
    <input type="hidden" name="code" value="<?php print $staff_code; ?>">
    スタッフ名<br />
    <input type="text" name="name" style="width:200px" value="<?php print $staff_name; ?>"><br />
    パスワードを入力してください。<br />
    <input type="password" name="pass2" style="width:100px"><br />
    <br />
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </form>
</body>

</html>
