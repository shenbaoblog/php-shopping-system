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
    $staff_name = $_POST['name'];
    $staff_pass = $_POST['pass'];

    // HTMLの特殊文字：'、"、&、<、>などHTMLにおいて特殊な役割を持つ文字。
    // HTMLエンティティ：'、"、&、<、>をそのまま文字として画面に出力するように用意された文字列。
    // htmlspecialchars(変換対象,変換パターン,文字コード)：特殊文字をHTMLエンティティに変換。
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
    // MySQLのencodingやcharsetのutf8は、実は真のUTF-8ではなく、4バイト長の文字に対応していません。
    // MySQL文字セットは、utf8mb4ではなくutf8mb3を参照している。
    // 3バイトのutf8文字セットは、Unicodeで定義されている文字のうち限定的なセットしかサポートしない。
    // utf8mb4：文字ごとに最大4バイトを使用し、補助文字をサポートする。
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = '';
    // dbh：データベースハンドラ：
    // ハンドラ：何かを行おうとしたときに、それを行いやすくしてくれるものの「総称」。ゼロから使うと複雑で難しい処理でも、ハンドラを使うことでかんたんに扱うことができる。
    // エラーハンドラ、イベントハンドラ、リクエストハンドラ、データベースハンドラ、ファイルハンドラといったものがある。
    // エラーハンドラ：発生したエラーの詳細、発生箇所の記録、エラーコードやエラーメッセージの作成、エラー発生までの過程を遡れるようにコードの実行履歴を記録。
    // ↑上記処理を間に入って代わりにやってくれるのがハンドラ。
    // ハンドラ：関数やサブルーチンのようなかたちで実装され、（通常のプログラムのなかには組み込まれず）ふだんはメモリ上に待機しています。そして、ハンドラが対応すべき処理要求が発生した場合、プログラムの流れを中断して所定の処理を行います。
    // ハンドラとクラス・関数との違い：一緒。ハンドラは総称であり、実態はクラスや関数などいろいろな形で用意されている。
    // ハンドラ：PDOクラスは、データベースハンドラの役割を行っている。
    // PDOクラス：複雑なデータベース処理が簡単に行えるようになっている。
    $dbh = new PDO($dsn, $user, $password);
    // setAttribute（属性セット）：
    // PDOは様々なデータベース（MySQLやPostgresやOracle）で利用できる。その中にもデータベース固有のものも含まれる。そんな中で、PDOをどう動かしたいのか意図的に属性指定するために使われる。
    // setAttribute(int $attribute, mixed $value) : bool
    // 第1引数：オプション名、第2引数：オプション値
    // $options = [
    //   PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //   PDO::ATTR_EMULATE_PREPARES   => false,
    // ];

    // try {
    //   $pdo = new PDO($dsn, $user, $pass, $options);
    // } catch (\PDOException $e) {
    //   throw new \PDOException($e->getMessage(), (int) $e->getCode());
    // }
    // PDOでよく使うオプション
    // $options = [
    // 例外エラーを詳細にしてくれるオプション
    // PDOのエラー文はデータベース接続時は詳細のエラーを表示してくれるが、select文などのSQL実行時にエラーが出た場合は、非常にそっけないエラー文を表示する。
    // PDO::ERRMODE_EXCEPTIONのオプションをつけると、エラー文に詳細情報が記載される。
    // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

    // このオプションを使えば、select文やwhere句などの結果を連想配列として返してくれるようになる。
    // デフォルトでは、SQLの結果は要素の番号が0,1,2と言う普通の配列として返ってくるが、このオプションをつけることで、以下のように値を返してくれるようになる。
    // {
    //   "name" => "tarou",
    //   "age"  =>  14
    // }
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    // PDO::ATTR_EMULATE_PREPARES   => false,
    // ];
    // 参考URL：https://www.toumasu-program.net/entry/2019/12/20/102903
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'INSERT INTO mst_staff(name,password) VALUES (?,?)';
    // prepareメソッドでは、PDOStatementオブジェクトを生成しており、executeメソッドを使うことで、PDOStatementオブジェクト内でSQLの結果を保持する。
    $stmt = $dbh->prepare($sql);
    $data[] = $staff_name;
    $data[] = $staff_pass;
    $stmt->execute($data);

    // よく初学者が
    // $results = $stmt->execute();
    // 上記のコードのように書いて$results変数にSQLの結果があると思い込みがちだが、executeの戻り値はtrue falseのどちらかであり、実際のSQLの結果はPDOStatementオブジェクト(ここでは$stmt）が保持している。
    // では、どのようにSQLの結果を出すかと言うと、fetchまたはfetchAllを使うと良い。
    // $stmt->execute();
    // while ($row = $stmt->fetch()) {
    //   // 処理
    // }
    // 上記のコードの$rowには、SQLの結果の一行が配列、または連想配列として取り出される。まとめて全ての結果を取り出したい場合はfetchAllを使うと良い。

    $dbh = null;

    print $staff_name;
    print 'さんを追加しました。<br>';
  } catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }
  ?>

  <a href="staff_list.php">戻る</a>
</body>

</html>
