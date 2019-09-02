<?php
// 掲示板管理人ホームページ
    $dsn='データーベース名';
    $user ='ユーザー名';
    $password = 'パスワード名';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $a = 1;
    $hikaku = 0;
    $daburi =0;
    $date = date("Y/m/d H:i:s");
    session_start();
    if($_SESSION['name'] == "")
    {
        header('Location: mission_6-2l.php');
    }
?>
<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>6-2</title>
</head>
<body>
    <form method="POST" action="mission_6-2hk.php">
        <p>管理人ページ</p>
        <hr>
        <p>スレッド作成</p>
        <input type="text" name="surename" placeholder="スレッド名入力"><br>
        <input type="submit" name="suresaku" value="スレッド作成"><br>
        <hr>
        <p>スレッド削除機能</p>
        <input type="text" name="deletesure" placeholder="スレッド名入力"><br>
        <input type="submit" name="suresakuzyo" value="スレッド削除"><br>
        <hr>
        <p>ユーザーBAN機能</p>
        <input type="text" name="banname" placeholder="BAN名前入力"><br>
        <input type="text" name="banid" placeholder="BANID名入力"><br>
        <input type="submit" name="acdel" value="アカウント削除"><br>
        <input type="submit" name="acall" value="アカウント一覧表示"><br>
        <p>スレッド一覧</p>
        
<?php
   if(isset($_POST["suresaku"]))
   {
        if(!empty($_POST["surename"]))
        {
          $sql = 'SELECT * FROM sure';
          $stmt = $pdo->query($sql);
          $results = $stmt->fetchAll();
          foreach ($results as $row)
          {
            if($row[0] == $_POST["surename"])
            {
                $daburi = 1;
            }
          }
          if($daburi == 1)
          {
            echo "すでに同じスレッドがあります";
            echo "<hr>";
          }
        else
        {
            $sname1 = $_POST["surename"];
            $sql1 ='SHOW TABLES';
            $result = $pdo -> query($sql1);
            foreach ($result as $row)
            {
                if(preg_match("/^a/",$row[0]))
                {
                    $hikaku = str_replace('a', '', $row[0]);
                    while($hikaku >= $a)
                    {
                        $a++;
                    }
                }
            }
            $b = "a".$a.".php";
            $c = "a".$a;
            $sql = "CREATE TABLE IF NOT EXISTS $c "
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "idname TEXT,"
            . "name char(32),"
            . "comment TEXT,"
            . "date TEXT,"
            . "pass TEXT"
            .");";
            $stmt = $pdo->query($sql);
            // スレ名とurlを保存
            $sql1 = $pdo -> prepare("INSERT INTO sure (sname, url) VALUES (:sname, :url)");
            $sql1 -> bindParam(':sname', $sname, PDO::PARAM_STR);
            $sql1 -> bindParam(':url', $url, PDO::PARAM_STR);
            $sname = $sname1;
            $url = $b;
            $sql1 -> execute();
            // 6-2書き換え
            copy("mission_6-2k.php", "$b");
            header('Location:' . $b);
        }
       }
       else
       {
            echo "スレッド名を入力してください。";
       }
   }
   
  if(isset($_POST["suresakuzyo"])) // スレッド削除
   {
      $sql = 'SELECT * FROM sure';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchAll();
      $sname = $_POST["deletesure"];
      foreach ($results as $row)
      {
          if($_POST["deletesure"] == $row[0])
          {
            $x = $row[1];
            $y = str_replace('.php', '', $x);
            $sql = 'delete from sure where sname = :sname';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':sname', $sname, PDO::PARAM_STR);
            $stmt -> execute();
            $sql = 'DROP TABLE IF EXISTS '.$y;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            unlink("$x");
          }
      }
    }
    
    if(isset($_POST["acdel"]))
    {
        if(!empty($_POST["banid"])&&!empty($_POST["banname"]))
        {
          $sql = 'SELECT * FROM login';
          $stmt = $pdo->query($sql);
          $results = $stmt->fetchAll();
          foreach ($results as $row)
          {
              if($_POST["banid"] == $row['id'] && $_POST["banname"] == $row['name'])
              {
                $id = $_POST["banid"];
                $sql = 'delete from login where id = :id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt -> execute();
              }
           }
        }
    }
    
    if(isset($_POST["acall"])) //アカウント一覧表示
    {
        $sql = 'SELECT * FROM login';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row)
        {
           echo $row['id'].',';
           echo $row['name'].',';
           echo "<hr>";
        }
    }
    
    $sql = 'SELECT * FROM sure';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row)
    {
       $d = $row[1];
       echo '<a href=' . $d . '>'.$row['sname'].'</a><br>';
       echo "<hr>";
    }
?>
    </form>
</body>
</html>