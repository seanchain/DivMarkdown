<?php

function convert()
{
    $url = "./res.html";
    $filename = "./res.pdf";
    exec("/usr/local/bin/wkhtmltopdf $url $filename");
}

$code = $_POST['code'];
$code = '<head><script src="./Resources/mootools-core-1.5.0-full-nocompat-yc.js"></script>
    <script src="./Resources/mootools-more-1.5.0-yc.js"></script>
    <script src="./Build/EnlighterJS.yui.js"></script>
    <link rel="stylesheet" href="theme.css" type="text/css" />
    <link rel="stylesheet" href="Build/EnlighterJS.yui.css" type="text/css"/>
	<meta name="EnlighterJS" content="Advanced javascript based syntax highlighting" data-language="javascript" data-indent="2" data-selector-block="pre" data-selector-inline="code" /></head>'.$code;
$fp = fopen("res.html", "w");
fputs($fp, $code);
fclose($fp);
convert();
?>
