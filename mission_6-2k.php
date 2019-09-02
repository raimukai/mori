<?php
// 掲示板投稿テンプレート
$num = 1;
$count = 0;
$b = "";
$b2 ="";
session_start();
if($_SESSION['name'] == "")
{
    header('Location: mission_6-2l.php');
}
$dsn='データーベース名';
$user ='ユーザー名';
$password = 'パスワード名';
$z = basename(__FILE__);
$y = str_replace('.php', '', $z);
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$date = date("Y/m/d H:i:s");
$myurl = basename(__FILE__);
// ログイン判定
if($_SESSION['name'] == "")
{
   header('Location: mission_6-2l.php');
}

if("mission_6-2k.php" == $myurl)
{
   header('Location: mission_6-2l.php');
}



// 編集フォーム(フォームに表示させる)
if(isset($_POST["hen"])) 
{
  if(!empty($_POST["hensyuu"]) && !empty($_POST["pass3"])) 
  {
    $id = $_POST["hensyuu"];
    $sql = 'SELECT * FROM '.$y;
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) 
    {  
         if($row['id'] == $id) 
         {
            if($row['pass'] == $_POST["pass3"] && $_POST["pass3"] == $_SESSION['pass']) 
            {
                $b = $row[3];
                $b2 = $row[0];
            }
            else
            {
                echo "パスワードが違います";
            }
         }
      }
   }
}

// 送信フォーム
if(isset($_POST["sou"]))
{
  if (!empty($_POST["kieru"])) // 編集か判断
  {
    $id = $_POST["kieru"];
    $comment = $_POST["comment"];
    $sql = 'update '.$y.' set comment=:comment where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  else 
  {
   if (!empty($_POST["comment"])) 
   {
    $sql = $pdo -> prepare("INSERT INTO ".$y." (idname, name, comment, date, pass) VALUES (:idname, :name, :comment, :date, :pass)");
    $sql -> bindParam(':idname', $idname, PDO::PARAM_STR);
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $idname = $_SESSION['id'];
    $name = $_SESSION['name'];
    $comment = $_POST["comment"];
    $date = $date;
    $pass = $_SESSION['pass'];
    $sql -> execute();
   }
  }
 }
 
  // 削除フォーム
if(isset($_POST["del"]))
{
   if (!empty($_POST["delete"])&& !empty($_POST["pass2"])) 
   {

         $id = $_POST["delete"];
         $sql = 'SELECT * FROM '.$y;
         $stmt = $pdo->query($sql);
         $results = $stmt->fetchAll();
         foreach ($results as $row)
         {
            if($row['pass'] == $_POST["pass2"] && $_POST["pass2"] == $_SESSION['pass'])
            {
                if($row['id'] == $id)
                {
                    $id = $_POST["delete"];
                    $sql = 'delete from '.$y.' where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                 }
             }
          }
    }
    else
    {
      echo "パスワードか削除番号が入力されてません";
    }
 }
 
    // 表示フォーム
    $sql = 'SELECT * FROM '.$y;
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row)
    {
        echo $row[0].', ';
        echo "名前:".$row[2].', ';
        echo "ID:".$row[1].', ';
        echo $row[4].'<br>';
        echo $row[3].'<br>'; 
        echo "<hr>";
    }
?>

<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title><?php '$y' ?></title>
</head>
<body>
<form method="POST" action="<?php '$z' ?>">
    <input type ="text" name="comment"   placeholder="コメント" style="width:200px; height:50px;" value = "<?php echo $b; ?>"><br>
    <input type="submit" name = "sou" value="送信">
    <input type ="hidden" name="kieru"  value = "<?php echo $b2; ?>"><br>
    <input type ="text" name="delete" placeholder="削除対象番号"><br>
    <input type ="password" name="pass2" placeholder="パスワード入力"><br>
    <input type="submit" name = "del" value="削除"><br>
    <input type ="text" name="hensyuu" placeholder="編集指定番号"><br>
    <input type ="password" name="pass3" placeholder="パスワード入力"><br>
    <input type="submit" name = "hen" value="編集" ><br>
</form>
</body>
</html>