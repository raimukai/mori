﻿<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>3-1-2</title>
</head>
<body>
<form method="POST" action="mission_3-1-2.php">
	名前<input type ="text" name="name"><br>
    コメント<br><textarea name="comment"></textarea><br>
	<input type="submit" value="送信"><br>
<?php
    $date = date("Y/m/d H:i:s");
    $count = 1;
    if (isset($_POST["comment"])) 
    {
       if ($_POST["comment"]=="" || $_POST["name"] == "") {
        }  
         else 
         {
            $count = count(array);
            $filename = "mission_3-1.txt";
            $fp = fopen($filename, "a");
            fwrite($fp, $count."< >".$_POST["name"]."< >".$_POST["comment"]."< >".$date. "\n");
            fclose($fp);
            $array = file( $filename );
            foreach($array as $value)  
            {
                 echo $value. "<br>";
            }
        }
     } 
?>
</form>
</body>
</html>