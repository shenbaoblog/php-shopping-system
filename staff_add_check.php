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
  // staff_add.phpでフォームに入力した値を受け取る
  $staff_name = $_POST['name'];
  $staff_pass = $_POST['pass'];
  $staff_pass2 = $_POST['pass2'];

  // セキュリティ対策
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

  // 1つでも空欄があったら、戻るしか表示されない。
  // md5（Message Digest Algorithm 5）：任意の長さの原文を元に128bitの値を生成するハッシュ関数の1つ。
  // 同じ入力値からは、必ず同じ値が得られる一方、少しでも異なると入力値からは全く違う値が得られる
  // 同一のハッシュ値を持つ異なる原文のペアを効率よく探索することができるようになって、セキュリティ用途でmd5を使うのは十分に安全とはいえない。SHA-2などより安全なハッシュ関数の使用が奨励されている。
  // 【注意】ハッシュかと暗号化は異なるので注意。ハッシュ関数は不可逆な一方向関数を含むため、ハッシュ値から原文を再現することは（基本的に）不可能。一方、暗号化されたものは復号化できる。
  // ハッシュ値は、元のデータが1bitでも異なると大きく変化するため、特にテキストやファイルが改ざんされていないかをチェックするのに適している。
  if( $staff_name=='' || $staff_pass='' || $staff_pass2='' ) {
  print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '</form>';
  } else {
    $staff_pass=md5($staff_pass);
    print '<form method="post" action="staff_add_done.php">';
    print '<input type="hidden" name="name" value="'.$staff_name.'">';
    print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
    print '<br />';
    print '<input type="submit" value="OK">';
    print '<input type="button" onclick="history.back()" value="戻る">';
  }

  ?>
</body>

</html>
