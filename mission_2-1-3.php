<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><!-- for smartphone. ここは一旦、いじらなくてOKです。 -->
	<meta charset="utf-8"><!-- 文字コード指定。ここはこのままで。 -->
	<title>2-1-1</title>
</head>
<body>
<form method="POST" action="mission_2-1-3.php">
	<textarea name="comment">コメント</textarea><br>
	<input type="submit" value="送信">
<?php
    if (isset($_POST["comment"])) {
        echo $_POST["comment"]. "を受け付けました";
    }
?>
</form>
</body>
</html>