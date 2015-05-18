<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Markdown编辑器</title>
    <script src="showdown.js"></script>
    <script src="showdown-table.min.js"></script>
    <script src="showdown-gui.js"></script>
    <script src="jquery.min.js"></script>
    <script src="./Resources/mootools-core-1.5.0-full-nocompat-yc.js"></script>
    <script src="./Resources/mootools-more-1.5.0-yc.js"></script>
    <script src="./Build/EnlighterJS.yui.js"></script>
    <script src="app.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link rel="stylesheet" href="Build/EnlighterJS.yui.css" type="text/css"/>
    <meta name="EnlighterJS" content="Advanced javascript based syntax highlighting" data-language="javascript"
          data-indent="2" data-selector-block="pre" data-selector-inline="code"/>
</head>

<body>
<div id="pageHeader">
    <h1>Markdown编辑器</h1>

    <h3>Inspired by <a href="https://github.com/showdownjs/showdown">showdown.js</a></h3>
</div>
<div id="leftContainer">
    <div class="paneHeader">
        <span>输入</span>
    </div>
    <textarea id="inputPane" class="pane">
##Start your work with our Markdown editor
###Want to know how to write Markdown? Click [Here](http://www.chensihang.com/materials/markdown.pdf)
```java
public class Test{
    public static void main(String[] args){
        System.out.println("Hello, world");
    }
}
```</textarea>
</div>
<div id="rightContainer">
    <div class="paneHeader">
        <select id="paneSetting">
            <option value="previewPane">预览</option>
            <option value="outputPane">源码</option>
        </select>
    </div>

    <textarea id="outputPane" class="pane" cols="80" rows="20" readonly="readonly"></textarea>

    <div id="previewPane" class="pane">
        <noscript><h2>You'll need to enable Javascript to use this tool.</h2></noscript>
    </div>
</div>

<div id="footer">
		<span id="byline">
			<b><a href="http://www.chensihang.com/materials/markdown.pdf">Download cheat sheet</a></b> copyright &copy;
            沉思·航 2015
		</span>
        <span id="savepdf"><button class="button success tiny">存为PDF</button></span>
	
		<span id="convertTextControls">
			<button id="clearPage" type="button" class="button tiny default" title="clearPage">
                清空内容
            </button>
            <small id="wordcount"></small>
		</span>

    <span id="processingTime" title="Last processing time"></span>
</div>
</body>
</html>
