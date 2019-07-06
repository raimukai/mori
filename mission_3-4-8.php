 <?php
    $filename = "mission_3-4.txt";
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
                    $n = $str[1];
                    $c = $str[2];
                    $k = $str[0];
                }
            }
            $a = $n;
            $b = $c;
            $b2 = $k;
        }
    }
?>
<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>3-4-8</title>
</head>
<body>
<form method="POST" action="mission_3-4-8.php">
    <input type ="text" name="name" placeholder="名前" value = "<?php echo $a; ?>"><br>
    <input type ="text" name="comment" placeholder="コメント" value = "<?php echo $b; ?>"><br>
    <input type ="hidden" name="kieru"  value = "<?php echo $b2; ?>"><br>
    <input type="submit" name = "sou" value="送信"><br>
    <input type ="text" name="delete" placeholder="削除対象番号"><br>
    <input type="submit" name = "del" value="削除"><br>
    <input type ="text" name="hensyuu" placeholder="編集指定番号"><br>
    <input type="submit" name = "hen" value="編集" ><br>
 <?php
 // 送信フォーム
 if(isset($_POST["sou"]))
 {
    if (!empty($_POST["kieru"]))
    {
      $fp = fopen($filename, "r+");
      $array = file( $filename );
      ftruncate($fp,0);
      foreach ($array as $value)
      {
        $str = explode("< >", $value);
        if ($str[0] == $_POST["kieru"])
        {
          $v4 = $num. "< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date. "\n";
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
        if (!empty($_POST["name"]) && !empty($_POST["comment"])) 
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
            fwrite($fp, $num. "< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date. "\n");
            $array = file( $filename );
            foreach($array as $value) // fwrite1行を配列にする
            {
              $str = explode("< >", $value); 
              foreach($str as $value2) // <>配列にする
              {
                echo $value2. "\n";
              }
              echo "<br />";
            }
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
           else
           {
               $array = file( $filename );
               foreach($array as $value) // fwrite1行を配列にする
               {
                  $str = explode("< >", $value); 
                  foreach($str as $value2) // <>配列にする
                  {
                    echo $value2. "\n";
                  }
                  echo "<br />";
               }
           }
       }
    }
  ?>
</form>
</body>
</html>