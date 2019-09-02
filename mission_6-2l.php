<?php
    $dsn='データーベース名';
    $user ='ユーザー名';
    $password = 'パスワード名';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $date = date("Y/m/d H:i:s");
    $a = 0;
    $b = 0;
?>
<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>6-2</title>
</head>
<body>
    <form method="POST" action="mission_6-2l.php">
        <h4>新規登録</h4>
        <input type="text" name="mail" placeholder="メールアドレス"><br>
        <input type="text" name="id" placeholder="ID登録"><br>
        <input type="text" name="name" placeholder="ニックネーム"><br>
        <input type="text" name="pass" placeholder="パスワードを登録"><br>
        <p>IDは好きなIDを入力してください。なおメールアドレスとIDはすでに登録済みなものは登録できません</p><br>
        <input type="submit" name="touroku" value="登録"><br>
<?php
// 登録機能
if(isset($_POST["touroku"]))
{
   if (!empty($_POST["mail"]) && !empty($_POST["id"]) && !empty($_POST["name"]) && !empty($_POST["pass"])) 
   {
    $sql = 'SELECT * FROM login';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if($_POST["mail"] == $row['mail'])
        {
            $a = 1;
        }
        else if($_POST["id"] == $row['id'])
        {
            $a = 2;
        }
    }
        if($a == 1)
        {
            echo "すでに存在しているメールアドレスです";
        }
        else if($a == 2)
        {
            echo "すでに存在しているIDです";
        }
        else if($a == 3)
        {
            echo "すでに存在しているメールアドレスとIDです";
        }
        else
        {
            $sql = $pdo -> prepare("INSERT INTO login ( mail, id, name, pass) VALUES (:mail, :id, :name, :pass)");
            $sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
            $sql -> bindParam(':id', $id, PDO::PARAM_STR);
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
            $mail = $_POST["mail"];
            $id = $_POST["id"];
            $name = $_POST["name"];
            $pass = $_POST["pass"];
            $sql -> execute();
            echo "登録できました！ログインフォームからログインしてください";
       }
  }
   else
   {
       echo "入力漏れがあります";
   }
}
   ?>
    <hr>
        <h4>ログインはこちらから</h4>
        <input type="text" name="mail2" placeholder="メールアドレス"><br>
        <input type="password" name="pass2" placeholder="パスワード"><br>
        <input type="submit" name="login" value="ログイン"><br>
<?php
// ログイン機能
if(isset($_POST["login"]))
{
   if (!empty($_POST["mail2"]) && !empty($_POST["pass2"])) 
   {
    $sql = 'SELECT * FROM login';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        if($_POST["mail2"] == $row['mail'] && $_POST["pass2"] == $row['pass'])
        {
            $c = $row['id'];
            $d = $row['name'];
            $p = $row['pass'];
            $b = 1;
            break;
        }
        else
        {
            $b = 0;
        }
  }
        if($b == 0)
        {
            echo "メールアドレスかパスワードに誤りがあります";
        }
        else
        {
            session_start();
            $_SESSION['name'] = $d;
            $_SESSION['id'] = $c;
            $_SESSION['pass'] = $p;
            if($_SESSION['id'] == "raimukai")
            {
                header('Location: mission_6-2hk.php');
            }
            else
            {
                header('Location: mission_6-2h.php');
            }
        }
     }
   else
   {
        echo "記入漏れがあります";
   }
}

?>
    </form>
</body>
</html>