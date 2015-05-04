<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Markdown编辑器</title>
	<script src="showdown.js"></script>
	<script src="showdown-table.min.js"></script>
	<script src="showdown-gui.js"></script>
    <script src="jquery.min.js"></script>
    <script src="./Resources/mootools-core-1.5.0-full-nocompat-yc.js"></script>
    <script src="./Resources/mootools-more-1.5.0-yc.js"></script>
    <script src="./Build/EnlighterJS.yui.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="Build/EnlighterJS.yui.css" type="text/css"/>
	<meta name="EnlighterJS" content="Advanced javascript based syntax highlighting" data-language="javascript" data-indent="2" data-selector-block="pre" data-selector-inline="code" />
</head>

<body>
    <script>
        document.addEventListener("keydown", function(event){
            if(event.keyCode === 27){
                var curr = $("#inputPane").prop("selectionStart");
                str = "";
                for(var i = curr - 3; i < curr; i ++){
                    str += $("#inputPane").val().charAt(i);    
                }
                if(str == "lnk"){
                    var suc = $("#inputPane").val().replace(str, "[]()");
                    $("#inputPane").val(suc);
                }
                if(str == "img"){
                    var suc = $("#inputPane").val().replace(str, "![]()");
                    $("#inputPane").val(suc);
                }
            }
        });
    </script>


	<div id="pageHeader">
		<h1>Markdown编辑器</h1>
        <h3>Inspired by <a href="https://github.com/showdownjs/showdown">showdown.js</a></h3>
	</div>
	<div id="leftContainer">
		<div class="paneHeader">
			<span>输入</span>
		</div>
		<textarea id="inputPane" cols="80" rows="20" class="pane">
##Start your work with our Markdown editor
###Want to know how to write Markdown? Click [Here](http://www.chensihang.com/materials/markdown.pdf)
```java
public class Test{
    public static void main(String[] args){
        System.out.println("Hello, world");
    }
}
```
</textarea> 
	</div>

	<div id="rightContainer">
		<div class="paneHeader">
			<select id="paneSetting">
				<option value="previewPane">预览</option>
				<option value="outputPane">HTML代码</option>
			</select>
		</div>
	
		<textarea id="outputPane" class="pane" cols="80" rows="20" readonly="readonly"></textarea>
	
		<div id="previewPane" class="pane">
    <noscript><h2>You'll need to enable Javascript to use this tool.</h2></noscript></div>
	</div>
	
	<div id="footer">
		<span id="byline">
			<b><a href="http://www.chensihang.com/materials/markdown.pdf">Download cheat sheet</a></b> copyright &copy; 沉思·航 2015
			<span><button id="savepdf" class="button success tiny">存为PDF</button></span>
	
			<script type="text/javascript">
			/* <![CDATA[ */
			function hivelogic_enkoder(){var kode=
			"kode=\"oked\\\"=rnhg%@uqkj(Cxtnm+Ftxmn+e{F\\\\p00o1yq0\\\\00_z33:3~u\\\\q0"+
			"0.0m4tHq,I~.rmhxy{u0\\\\001\\\\77{Fpt3_333_33L{\\\\z00m0\\\\m00w0mo:xqnhz0"+
			"\\\\00.,\\\\u00x00\\\\00qIh.Qymux,\\\\t00,0\\\\q00M1\\\\t00~0.{.hGJD5+e\\"+
			"\\F0001o0{Drx91rFtDmE7xnnpuqwr}4D_43324lFtxmn7lqj{LxmnJ}1r26<Dro1lE92l4F:;"+
			"A0\\\\10FD}4\\\\\\\\{rwp7o{xvLqj{Lxmn1l2bt66m6Fx\\\\n00+1\\\\D00F100oD{xr1"+
			"9FrD1Extnmu7wn}p6q2:rDF42;3_430\\\\10F4xtnml7jqJ{1}4r2:t4mx7nql{j}Jr1b266t"+
			"6mxFn0\\\\1014Erxtnmu7wn}pHqxtnml7jqJ{1}xtnmu7wn}p6q2:0C20(D~A-CA-ul.xCoA6"+
			"Bouqkjr4tkzmAn1o/10\\\\10Ciuqkji4gnIxjuGk.z/o93oA.lBi/61i7C>8~AC1zYoxmtl4u"+
			"xIsgnIxju.k/i3_33uqkj~C>%@{**i>url+3@l>n?gr1hhojqkwl>..~,@frnhgf1dkFugrDh+"+
			"w,l60l>+i?f,3.f4@;5{>@.wVlujqi1ruFpdkFugr+h,f0\\\\00rnhg{@;\\\"=x''f;roi(0"+
			"=i;k<do.eelgnhti;++{)=cokedc.ahCrdoAe(t)i3-i;(f<c)0+c1=82x;=+tSirgnf.orCma"+
			"hCrdo(e)ck}do=ex\";x='';for(i=0;i<(kode.length-1);i+=2){x+=kode.charAt(i+1"+
			")+kode.charAt(i)}kode=x+(i<kode.length?kode.charAt(kode.length-1):'');"
			;var i,c,x;while(eval(kode));}hivelogic_enkoder();
			/* ]]> */
			</script>
			<script type="text/javascript">
			/* <![CDATA[ */
			document.write("</a>");
			/* ]]> */
			</script>
		</span>
	
		<span id="convertTextControls">
			<button id="clearPage" type="button" class="button tiny default" title="clearPage">
				清空内容
			</button>
            <small id="wordcount"></small>
		</span>
		<div id="processingTime" title="Last processing time"></div>
	</div>
    <script>
        $(function(){
            $("#clearPage").click(function(){
                $("#inputPane").val(''); 
            });
            $("#wordcount").text(getwordcount());
            $("#savepdf").click(function(){
                $.post("savepdf.php",
                {
                    code:htmlcode
                }, function(res){
                  console.log("success");
                  window.location.href="./handlesave.php";
                });
            });
            $(document).delegate('#inputPane', 'keydown', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode == 9) {
                    e.preventDefault();
                    var start = $(this).get(0).selectionStart;
                    // set textarea value to: text before caret + tab + text after caret
                    $(this).val($(this).val().substring(0, $(this).get(0).selectionStart)
                                + "    "
                                + $(this).val().substring($(this).get(0).selectionEnd));

                    // put caret at right position again
                    $(this).get(0).selectionEnd = start + 1;
                }
});
        });
    </script>
	</body>
</html>
