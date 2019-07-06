<?php
$filename = "mission_3-5.txt";
$date = date("Y/m/d H:i:s");
$num = 1;
$a = "";
$b = "";
$b2 ="";
$count = 0;

// 編集フォーム
if(isset($_POST["hen"]))
{
  if(!empty($_POST["hen"]))
  {
    $array = file( $filename );
    foreach($array as $value)
    {
      $str = explode("< >", $value);
      if ($str[0] == $_POST["hensyuu"])
      {
        $b2 = $str[0];
        $a = $str[1];
        $b = $str[2];
      }
    }
   }
}

?>

<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>3-5-3</title>
</head>
<body>
<form method="POST" action="mission_3-5-3.php">
    <h1>テーマ:</h1>
    <input type ="text" name="name" placeholder="名前" value = "<?php echo $a; ?>"><br>
    <input type ="text" name="comment" placeholder="コメント" value = "<?php echo $b; ?>"><br>
    <input type ="text" name="pass" placeholder="パスワードを決めてください">
    <input type="submit" name = "sou" value="送信"><br>
    <input type ="hidden" name="kieru"  value = "<?php echo $b2; ?>"><br>
    <input type ="text" name="delete" placeholder="削除対象番号"><br>
    <input type ="text" name="pass2" placeholder="パスワード入力">
    <input type="submit" name = "del" value="削除"><br>
    <br>
    <input type ="text" name="hensyuu" placeholder="編集指定番号"><br>
    <input type ="text" name="pass3" placeholder="パスワード入力">
    <input type="submit" name = "hen" value="編集" ><br>
<?php
// 送信フォーム
if(isset($_POST["sou"]))
{
  if (!empty($_POST["kieru"])) // 投稿番号
  {
    $fp = fopen($filename, "r+");
    $array = file( $filename );
    ftruncate($fp,0);
    foreach ($array as $value)
    {
      $str = explode("< >", $value);
      if ($str[0] == $_POST["kieru"])
      {
        $v4 = $str[0]."< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date. "\n";
        $fp = fopen($filename, "a");
        fwrite($fp, $v4);
      }
      else
      {   
        $v3 = $value;
        $fp = fopen($filename, "a");
        fwrite($fp, $v3);
      }
    }
    fclose($fp);
  }
  else
  {
     if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])) 
     {
        if (file_exists($filename)) 
        {
           $fp = fopen($filename, "r");
           $array = file( $filename );
           foreach($array as $value)
           {   
              $str = explode("< >", $value); 
              $count = $str[0];
           }
           $num = $count + $num;
        } 
        else 
        {
          $num = 1;
        } 
        $fp = fopen($filename, "a");
        fwrite($fp, $num."< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date."< >".$_POST["pass"]."< >". "\n");
        fclose($fp);
     }
  }
}

// 削除フォーム
if(isset($_POST["del"]))
{
  if ($_POST["del"])  
  {
    if (!empty($_POST["delete"])) 
    {
      $fp = fopen($filename, "r+");
      $array = file( $filename );
      ftruncate($fp,0);
      foreach ($array as $value)
      {
        $str = explode("< >", $value);
        if ($str[0] != $_POST["delete"])
        {
          $v3 = $value;
          $fp = fopen($filename, "a");
          fwrite($fp, $v3);
        }
      }
      fclose($fp);
    }
  }
}

// 常に文章表示
if (file_exists($filename)) 
{
    $fp = fopen($filename, "r");
    $array = file( $filename );
      foreach($array as $value) // fwrite1行を配列にする
      {
        $str = explode("< >", $value); 
        echo $str[0]."\n".$str[1]."\n".$str[2]."\n".$str[3];
        echo "<br />";
      }
}
?>
</form>
</body>
</html>