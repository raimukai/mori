<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>3-3-1</title>
</head>
<body>
<form method="POST" action="mission_3-3-1.php">
	名前<input type ="text" name="name"><br>
    コメント<br><textarea name="comment"></textarea><br>
	<input type="submit" value="送信"><br>
    削除対象番号<input type ="text" name="name"><br>
    <input type="submit" value="削除"><br>
<?php
    $filename = "mission_3-3.txt";
    $date = date("Y/m/d H:i:s");
    if (file_exists($filename)) {
        $num = count(file($filename))+1;
    } else {
        $num = 1;
    }
    if (isset($_POST["comment"])) 
    {
       if ($_POST["name"]=="" ||$_POST["comment"]=="") {
        }  
       else 
         {
            $fp = fopen($filename, "a");
            fwrite($fp, $num. "< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date. "\n");
            $array = file( $filename );
            foreach($array as $value)  
            {
                $str = explode("< >", $value); 
                echo $value. "<br>";
             foreach($array as $value)  
            {
                $str = explode("< >", $value); 
                foreach($str as $value2)
                {
                    echo $value2. "\n";
                }
                echo "<br />";
            }
            fclose($fp);
        }
        }
     } 

?>
</form>
</body>
</html>