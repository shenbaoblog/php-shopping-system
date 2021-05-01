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
  $staff_code = $_POST['code'];
  $staff_name = $_POST['name'];
  $staff_pass = $_POST['pass'];
  $staff_pass2 = $_POST['pass2'];

  // HTMLの特殊文字：'、"、&、<、>などHTMLにおいて特殊な役割を持つ文字。
  // HTMLエンティティ：'、"、&、<、>をそのまま文字として画面に出力するように用意された文字列。
  // htmlspecialchars(変換対象,変換パターン,文字コード)：特殊文字(text/plain)をHTMLエンティティ(text/html)に変換。
  // htmlspecialchars_decode()：HTMLエンティティを特殊文字に変換。
  // ENT_QUOTES：PHPが定数として持っているint型の値。ENT_QUOTESを指定すると、特殊文字列のうちシングルクォーテーションとダブルクォーテーションも変換対象に含めるようになる。
  // 文字コード：文字を変換するときに使うエンコーディングを定義(text/html; UTF-8に変換)
  $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
  $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');
  $staff_pass2 = htmlspecialchars($staff_pass2, ENT_QUOTES, 'UTF-8');

  if ($staff_name == '') {
    print 'スタッフ名が入力されていません。<br>';
  } else {
    print 'スタッフ名：';
    print $staff_name;
    print '<br>';
  }

  if ($staff_pass == '') {
    print 'パスワードが入力されていません。<br>';
  } else {
    print 'パスワード：';
    print $staff_pass;
    print '<br>';
  }

  if ($staff_pass != $staff_pass2) {
    print 'パスワードが一致しません。<br>';
  }

  if( $staff_name=='' || $staff_pass='' || $staff_pass2='' ) {
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
  } else {
    // mb5：文字列のmb5ハッシュ値を取得する
    $staff_pass=md5($staff_pass);
    print '<form method="post" action="staff_edit_done.php">';
    print '<input type="hidden" name="code" value="'.$staff_code.'">';
    print '<input type="hidden" name="name" value="'.$staff_name.'">';
    print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
    print '<br />';
    print '<input type="submit" value="OK">';
    print '<input type="button" onclick="history.back()" value="戻る">';
  }

  ?>
</body>

</html>
