<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>3-4-5</title>
</head>
<body>
<form method="POST" action="mission_3-4-5.php">
	名前<input type ="text" name="name"><br>
    コメント<br><textarea name="comment"></textarea><br>
	<input type="submit" name = "sou" value="送信"><br>
    削除対象番号<input type ="text" name="delete"><br>
    <input type="submit" name = "del" value="削除"><br>
    編集番号指定用フォーム<input type ="text" name="hensyuu"><br>
    <input type="submit" name = "hen" value="編集"><br>
<?php
    $filename = "mission_3-4.txt";
    $date = date("Y/m/d H:i:s");
    $num = 1;
    $count = 0;
    
    if(isset($_POST["sou"]))
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
                }
            }
        }
    }
?>
</form>
</body>
</html>