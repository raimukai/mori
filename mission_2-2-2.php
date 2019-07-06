<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>2-2-2</title>
</head>
<body>
<form method="POST" action="mission_2-2-2.php">
	<textarea name="comment">コメント</textarea><br>
	<input type="submit" value="送信">
<?php
    if (isset($_POST["comment"]))
    {
       if ($_POST["comment"]=="")
       {
       }
       else {
        $filename = "mission_2-2.txt";
        $fp = fopen($filename, "w");
        fwrite($fp, $_POST["comment"]);
        fclose($fp);
        $content = file_get_contents($filename);
        echo $content;
        }
     }
?>
</form>
</body>
</html>