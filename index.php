
<?php
// 新しいセッションを開始 ログインを開始
session_start();

// データーベースの読み込み
require_once("database.php");

// データベースに登録
function userCreate($dbh, $userName, $email, $password) {
    $stmt = $dbh->prepare("INSERT INTO users(user_name, email, password) VALUES(?,?,?)");
    $data = [];
    $data[] = $userName;
    $data[] = $email;
    // パスワードを暗号化する
    $data[] = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute($data);
}

// POSTに値が入っている時送信する
if (!empty($_POST)) {
    userCreate($dbh, $_POST["user_name"], $_POST["email"], $_POST["password"],);
}
// ログインしているときにログインしていることを表示する
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
    <title>ユーザー登録</title>
</head>
<body>
<!-- 共通のログインnavを読み込み -->
<?php include("menu.php"); ?>

    <h1>ユーザー登録</h1>
    <!-- 自分に送信する -->
        <form action="./lesson.php" method="POST">
            <label>名前<input type="text" name="user_name"></label><br>
            <label>メールアドレス<input type="Email" name="email"></label><br>
            <label>パスワード<input type="password" name="password"></label><br>
            <button type="submit">登録</button>
        </form>
</body>
</html>