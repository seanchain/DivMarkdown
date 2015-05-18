<?php

$md = $_POST['md'];
echo $md;
$fp = fopen("res.md", "w");
fputs($fp, $md);
fclose($fp);

?>