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
  if (isset($_POST['edit']) == true) {
    if (isset($_POST['staffcode']) == false) {
      header('Location: staff_ng.php');
      exit();
    }
    // header：HTTPヘッダー情報生のhttpヘッダを送信する。
    // httpヘッダの内容を指定できる。
    // Locationヘッダ：このヘッダがブラウザに返されるだけではなく、ブラウザにREDIRECT(302)ステータスコードを返します（201や3xx1ステータスコードが既に送信されていない場合のみ）。
    // Locationの注意点：飛ばす前に何かを表示してしまうと、途端に飛ばなくなってしまう。
    $staff_code = $_POST['staffcode'];
    header('Location: staff_edit.php?staffcode=' . $staff_code);
    // メッセージを出力して、現在のプログラムを終了する
    exit();
  }
  if (isset($_POST['delete']) == true) {
    if (isset($_POST['staffcode']) == false) {
      header('Location: staff_ng.php');
      exit();
    }
    $staff_code = $_POST['staffcode'];
    if (isset($_POST['staffcode']) == false) {
      header('Location: staff_ng.php?staffcode=' . $staff_code);
      exit();
    }
    header('Location: staff_delete.php?staffcode=' . $staff_code);
    // メッセージを出力して、現在のプログラムを終了する
    exit();
  }
  ?>
</body>

</html>
