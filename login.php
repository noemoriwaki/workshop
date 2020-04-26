
<?php
 // 新しいセッションを開始 ログインを開始
session_start();

// データベースの読み込み
require_once("database.php");

// データベースへ登録
function findUserByEmail($dbh, $email) {
    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $dbh->prepare($sql);
    $data[] = $email;
    $stmt->execute($data);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Emailが合っているのか参照
if (!empty($_POST)) {
    // emailが合っている場合
    $user = findUserByEmail($dbh, $_POST["email"]);
        //passwordも合っている場合
    if(password_verify($_POST["password"], $user["password"])) {
        // ログイン状態にする
        $_SESSION["login"] = true;
        // どのページでもログイン状態にする
        $_SESSION["user"] = $user;
        // ログインするとマイページへ飛ぶ
        header('Location: mypage.php');
        exit;
    } else {
        echo 'Invalid password.';
    }
}

// ログインしているのか表示
if ($_SESSION["login"]) {
    echo "ログインしています。";
  } else {
    echo "ログインしていません。";
  }



 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
<!-- 共通のログインnavを読み込み -->
<?php include("menu.php"); ?>

    <h1>ログイン</h1>
    <form action="./login.php" method="POST">
        <label>メールアドレス<input type="Email" name="email"></label><br>
        <label>パスワード<input type="password" name="password"></label><br>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>
