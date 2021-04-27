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

    // dsn：データベースの接続情報につけられる、識別用の名前のこと。データ元の名前。
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8'; // DSN: Data Source Name
    $user = 'root';
    $password = '';
    // PDOクラスのインスタンス化（引数にデータベースの接続に必要な情報を記述）
    // PDO:PHP Data Objects
    // PDOは、どのデータベースを使っているかを隠蔽してくれる。
    // PDOは、どのデータベースを利用する場合でも同じ関数をつかうことができる。
    // DBH:Data Base Handle
    // Handle：コンピュータなどのソフトウエアの世界では一般的に「ハンドル」とは、あるオブジェクトや機能など(=この場合データベース)を操作するためのキーや、そのものを示す
    // ハンドル：英語で、ある何かを操作することをHandle(ハンドル)、操作する人(者)のことをHandler(ハンドラー)といいますが、これが語源です。
    // ご指摘のWebページで「車のハンドルと同じ」と言われているのはそのためと思います。
    // つまり、あるものを操作するためのID、あるいは、あるものを示すためのIDのことがハンドルなので、
    // この場合「データベースを操作するために使われるもの＝データベースハンドル」、ということになります。
    $dbh = new PDO($dsn, $user, $password);
    // データベースに接続した後にオプションを指定
    // 属性をセット
    // ATTR_ERRMODE：エラーレポート
    // ERRMODE_EXCEPTION：例外を投げる
    // エラーが発生した時に、PDOExceptionの例外を投げてくれる。
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データを取得
    // ？には、data[]にて、データをセットする。
    $sql = 'SELECT name FROM mst_staff WHERE code=?';
    // prepare：SQL文をセットして実行準備を行う。SQL文だけ作っておいて、後から値を当てはめる。
    $stmt = $dbh->prepare($sql);
    // ？に値を当てはめる。
    $data[] = $staff_code;
    // クエリの実行
    // PDOStatementオブジェクトが結果を保持
    $stmt->execute($data);
    // とした場合、$results = $stmt->execute();とした場合、resultsには、trueまたは、falseが格納されている。
    // SQLの結果を出すかと言うと、fetchまたはfetchAllを使うと良い。
    // $stmt->execute();
    // while ($row = $stmt->fetch()) {
    //   // 処理
    // }
    // 結果を配列で取得
    // FETCH_ASSOC：【配列のキー】カラム名のみ
    // FETCH_BOTH：【配列のキー】カラム名&連番
    // FETCH_KEY_PAIR：指定した2つのカラムを「キー／値」のペアの配列にする
    // FETCH_COLUMN：指定した1つの絡むだけを1次元配列で取得
    // $recには、何が格納されている？
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $staff_name = $rec['name'];

    // 接続を閉じる
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
  <form action="staff_edit_check.php" method="post">
    <input type="hidden" name="code" value="<?php print $staff_code; ?>">
    スタッフ名<br />
    <input type="text" name="name" style="width:200px" value="<?php print $staff_name; ?>"><br />
    パスワードを入力してください。<br />
    <input type="password" name="pass" style="width:100px"><br />
    パスワードをもう一度入力してください。<br />
    <input type="password" name="pass2" style="width:100px"><br />
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </form>
</body>

</html>
