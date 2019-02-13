<?php
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "J15012";  // ユーザ名
$db['pass'] = "j15012";  // ユーザ名のパスワード
$db['dbname'] = "peppers";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["email"])) { //値が空の時
        $errorMessage = 'メールアドレスが未入力です。';
    }
    else if (empty($_POST["username"])) {
        $errorMessage = '名前が未入力です。';
    }
    else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }
    else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["email"]) && !empty($_POST["username"]) &&  !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        // 入力したユーザIDとパスワードを格納
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO users(teacher,username,  password) VALUES (?,?, ?)");



            $stmt->execute(array($email,$username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）

            // echo $email;
            $email = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            $signUpMessage =  '登録が完了しました。';  // ログイン時に使用するIDとパスワード
            // $signUpMessage =  '登録が完了しました。あなたの登録IDは '.$email. ' です。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';




            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>

                <label for="email">ユーザID(メールアドレスを入力)</label>
                <br><input type="email" id="email" name="email" value="" placeholder="例)〇〇〇〇@sangi.jp" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
                <br>
                <label for="username">名前</label>
                <br><input type="text" id="username" name="username" value="" placeholder="Pepperに表示されます" value="<?php if (!empty($_POST["email"])) {echo htmlspecialchars($_POST["email"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード</label>
                <br><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード(確認用)</label>
                <br><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
