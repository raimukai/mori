<?php
// 貸し借りアプリ
    $dsn='データーベース名';
    $user ='ユーザー名';
    $password = 'パスワード名';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $date = date("Y-m-d");

?>
<!DOCUMENTTYPE html>
<html>
<head>
<meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
<meta charset="utf-8">
<title>bone_group</title>
</head>
<body>
<div class="center">
<h1>モノフォーム</h1>
<form method="POST" action="7-1_bone.php">
<p>貸す相手
<input type="text" name="ait" placeholder="貸す相手"><br>
<p>モノ名
<input type="text" name="thing" placeholder="モノ名"><br>
<p>日付
<input type="date" name="day"><p>
<p>期限
<input type="date"  name="eday">
<p>借りる
<input type="radio" name="lort" value ="借り">
貸す
<input type="radio" name="lort" value="貸し"><br>
<p>通知日時:
<input type="number" name="tuuti" min="0" max="100">日前に通知(100日前より可能です)</p>
<p>メモ
<input type="text" name="memo" placeholder="メモ"><br>
<input type="submit" name="touroku" value="登録"><br>
<h1>モノ削除フォーム</h1>
<p>消す番号
<input type="number" name="ait2" ><br>
<input type="submit" name="del" value="削除"><br> 

<?php
//送信フォーム
if(isset($_POST["touroku"])){
    if(!empty($_POST["ait"]) && !empty($_POST["thing"]) && !empty($_POST["day"]) && !empty($_POST["eday"])&& !empty($_POST["lort"]) && !empty($_POST["tuuti"]))
    {
        $sql = $pdo -> prepare("INSERT INTO sample (ait, thing, day, eday, lort, tuuti, memo) VALUES (:ait, :thing, :day, :eday, :lort,:tuuti, :memo)");
        $sql -> bindParam(':ait', $ait, PDO::PARAM_STR);
        $sql -> bindParam(':thing', $thing, PDO::PARAM_STR);
        $sql -> bindParam(':day', $day, PDO::PARAM_STR);
        $sql -> bindParam(':eday', $eday, PDO::PARAM_STR);
        $sql -> bindParam(':lort', $lort, PDO::PARAM_STR);
        $sql -> bindParam(':tuuti', $tuuti, PDO::PARAM_STR);
        $sql -> bindParam(':memo', $memo, PDO::PARAM_STR);
        $ait = $_POST["ait"];
        $thing = $_POST["thing"];
        $day =$_POST["day"];
        $eday =$_POST["eday"];
        $lort =$_POST["lort"];
        $tuuti = $_POST["tuuti"];
        $memo =$_POST["memo"];
        $sql -> execute();
    }
   else{
    echo "全て入力してません";
   }
}

 //削除フォーム
if(isset($_POST["del"]))
{
   if (!empty($_POST["ait2"])) 
   {
         $sql = 'SELECT * FROM sample';
         $stmt = $pdo->query($sql);
         $results = $stmt->fetchAll();
         foreach ($results as $row)
         {
            if($row[0] == $_POST["ait2"])
            {
                    $id = $_POST["ait2"];
                    $sql = 'delete from sample where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
             }
          }
    }
    else
    {
      echo "パスワードか削除番号が入力されてません";
    }
 }

    $sql = 'SELECT * FROM sample';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    echo "<table border=1 style=border-collapse:collapse;>";
    echo "\t<tr><th>番号</th><th>相手名</th><th>モノ名</th><th>日付</th><th>期限</th><th>貸しor借り</th><th>通知日時(日前)</th><th>メモ</th></tr>\n";
    foreach ($results as $row)
    {
        $t= date('Y-m-d', strtotime('-'.$row[6].'day', strtotime($row[4])));
        if($date > $row[4])
        {
                $alert = "<script type='text/javascript'>alert('$row[0]番、$row[1]さんへの$row[5]期限が過ぎています！');</script>";
                echo $alert;
        }
        else if($t <= $date)
        {
                $alert = "<script type='text/javascript'>alert('$row[0]番、$row[1]さんへの$row[5]期限が近くなってます');</script>";
                echo $alert;
        }
        echo "\t<tr>\n";
        echo "\t\t<td>{$row[0]}</td>\n";
        echo "\t\t<td>{$row[1]}</td>\n";
        echo "\t\t<td>{$row[2]}</td>\n";
        echo "\t\t<td>{$row[3]}</td>\n";
        echo "\t\t<td>{$row[4]}</td>\n";
        echo "\t\t<td>{$row[5]}</td>\n";
        echo "\t\t<td>{$row[6]}</td>\n";
        echo "\t\t<td>{$row[7]}</td>\n";
        echo "\t</tr>\n";
    }
    echo "</table>\n";
    
?>
</body>
</html>
