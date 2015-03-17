<?php
$code = $_POST['code'];
$code = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Markdown编辑器</title><script type="text/javascript" src="showdown.js"></script><script type="text/javascript" src="showdown-gui.js"></script><script type="text/javascript" src="jquery.min.js"></script><link rel="stylesheet" href="github.css" type="text/css"><link rel="stylesheet" href="./tomorrow.css"><script src="./highlight.pack.js"></script></head><script>hljs.initHighlightingOnLoad();</script>'.$code;
$fp = fopen("res.html", "w");
fputs($fp, $code);
fclose($fp);

?>
