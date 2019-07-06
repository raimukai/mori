<?php
    $filename = "mission_1-2.txt";
    $fp = fopen($filename, "r");
    $size = filesize($filename);
    $data = fread($fp, $size);
    echo $data;
?>