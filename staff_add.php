<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>ろくまる農園</title>
</head>

<body>
  <p>スタッフ追加</p>
  <form method="post" action="staff_add_check.php">
    <p>スタッフ名を入力してください。</p>
    <input type="text" name="name" style="width: 200px">
    <p>パスワードを入力してください。</p>
    <input type="password" name="pass" style="width: 200px">
    <p>パスワードをもう一度入力してください。</p>
    <input type="password" name="pass2" style="width: 200px">
    <br>
    <br>
    <input type="button" onclick="history.back()" value="戻る">
    <input type="submit" value="OK">
  </form>

</body>

</html>
