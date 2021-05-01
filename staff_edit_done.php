<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  try {
    $staff_code = $_POST['code'];
    $staff_name = $_POST['name'];
    $staff_pass = $_POST['pass'];

    // HTMLの特殊文字：'、"、&、<、>などHTMLにおいて特殊な役割を持つ文字。
    // HTMLエンティティ：'、"、&、<、>をそのまま文字として画面に出力するように用意された文字列。
    // htmlspecialchars(変換対象,変換パターン,文字コード)：特殊文字(text/plain)をHTMLエンティティ(text/html)に変換。
    // htmlspecialchars_decode()：HTMLエンティティを特殊文字に変換。
    // ENT_QUOTES：PHPが定数として持っているint型の値。ENT_QUOTESを指定すると、特殊文字列のうちシングルクォーテーションとダブルクォーテーションも変換対象に含めるようになる。
    // 文字コード：文字を変換するときに使うエンコーディングを定義(text/html; UTF-8に変換)
    $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
    $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');

    // $dsn（date source name）：アプリケーションが ODBCデータソースへの接続を要求するために使う識別用の名前。
    // ODBC(Open Database Connectivity)：マイクロソフトさんが生み出した仕組みで、データベースとプログラムの間に入って仲立ちをしてくれる部品（に関する取り決め）
    // 実際のデータベースには、いろいろな種類があります。Oracle、MySQL、SQLServer等です。
    // これらのデータベースは、それぞれ個性があります。
    // 例えばデータベースへ接続する方法も、データベースの種類によって変わってきます。
    // プログラムをODBC経由でデータベースに接続するようにすると、データベースごとの個性を（あまり）気にしなくて良くなります。
    // それぞれの個性は通訳であるODBCさんが（ある程度）吸収してくれるからです。
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = '';
    // $db(Data Base Handler)：DB操作を簡単にしてくれるもの
    // PDO(PHP Data Object)クラス：PHPとDB間の接続を行うクラス。PHPからDBへのアクセスを抽象化してくれる。各DBのPDOドライバにアクセスしてDBを操作する。
    // PHPでは、PDOドライバを直接呼ぶのではなく、DB共通のインスタンスを作成する。
    $dbh = new PDO($dsn, $user, $password);
    // 属性師を呈する。
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE mst_staff SET name=?,password=? WHERE code=?';
    // prepare：プリペアドステートメント(PDOStatement)を準備する。（SQL文を先に準備する。あとから値を当てはめる。）
    // PDOStatementのメリット：クエリのパース (あるいは準備) が必要なのは最初の一回だけで、 同じパラメータ (あるいは別のパラメータ) を指定して何度でも クエリを実行することができます。
    // クエリを実行するには、準備として クエリの解析やコンパイル、そして実行プランの最適化が行われます。
    // クエリが複雑になると、この処理には時間がかかるようになります。
    // 同じクエリを異なったパラメータで何度も実行すると、アプリケーションの 動作は目に見えて遅くなるでしょう。
    // プリペアドステートメントを使用すると、この解析/コンパイル/最適化の繰り返しを避けることができます。
    //  端的に言うと、プリペアドステートメントは使用するリソースが少ないため 高速に動作するということです。
    // SQLインジェクション対策にもなる。
    $stmt = $dbh->prepare($sql);
    // SQL文の?に値を代入する値を$dataに代入。
    $data[] = $staff_name;
    $data[] = $staff_pass;
    $data[] = $staff_code;
    // execute：プリペアドステートメント(PSOStatement)を実行する
    $stmt->execute($data);

    // DBへの接続切断
    $dbh = null;
  } catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>

  修正しました。<br />
  <br />
  <a href="staff_list.php">戻る</a>
</body>

</html>
