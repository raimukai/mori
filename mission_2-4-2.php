<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>2-4-2</title>
</head>
<body>
<form method="POST" action="mission_2-4-2.php">
	<input type ="text" name="comment">
	<input type="submit" value="送信"><br>
<?php
    if (isset($_POST["comment"])) 
    {
       if ($_POST["comment"]=="") {
        }  
         else 
         {
            $filename = "mission_2-4.txt";
            $fp = fopen($filename, "a");
            fwrite($fp, $_POST["comment"]. "\n");
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