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
    // $dsn（date source name）：アプリケーションが ODBCデータソースへの接続を要求するために使う識別用の名前。
    // ODBC(Open Database Connectivity)：マイクロソフトさんが生み出した仕組みで、データベースとプログラムの間に入って仲立ちをしてくれる部品（に関する取り決め）
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = '';
    // DBH：
    // PDO：
    // setAttribute：
    // ATTR_ERRMODE：
    // ERRMODE_EXCEPTION：
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = 'SELECT code,name FROM mst_staff WHERE 1';
    // prepare：プリペアドステートメント(PDOStatement)を準備する。（SQL文を先に準備する。あとから値を当てはめる。）
    // PDOStatementのメリット：クエリのパース (あるいは準備) が必要なのは最初の一回だけで、 同じパラメータ (あるいは別のパラメータ) を指定して何度でも クエリを実行することができます。クエリを実行するには、準備として クエリの解析やコンパイル、そして実行プランの最適化が行われます。 クエリが複雑になると、この処理には時間がかかるようになります。 同じクエリを異なったパラメータで何度も実行すると、アプリケーションの 動作は目に見えて遅くなるでしょう。 プリペアドステートメントを使用すると、この 解析/コンパイル/最適化 の繰り返しを避けることができます。 端的に言うと、プリペアドステートメントは使用するリソースが少ないため 高速に動作するということです。
    // SQLインジェクション対策にもなる。
    $stmt = $dbh->prepare($sql);
    // execute：プリペアドステートメント(PSOStatement)を実行する
    $stmt->execute();

    // null：接続を閉じる
    $dbh = null;

    print 'スタッフ一覧<br /><br />';

    print '<form method="post" action="staff_branch.php">';
    // 無限ループ
    while (true) {
      // fetch；PDOStatementオブジェクトの結果セットから次の行を取得する。
      // 成功した場合の取得形式は、指定形式によって異なる。失敗した場合は、false
      // PDO:FETCH_ASSOC：結果セットに 返された際のカラム名で添字を付けた配列を返します。
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($rec == false) {
        break;
      }
      print'<input type="radio" name="staffcode" value="'.$rec['code'].'">';
      print $rec['name'];
      print '<br />';
    }
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';
    print '</form>';
  } catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
  }

  ?>

</body>

</html>
