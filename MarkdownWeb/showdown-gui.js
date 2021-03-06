window.onload = startGui;

var converter;
var convertTextTimer,processingTime;
var lastText,lastOutput,lastRoomLeft;
var convertTextSetting, convertTextButton, paneSetting;
var inputPane,previewPane,outputPane,syntaxPane;
var htmlcode;
var maxDelay = 3000; // longest update pause (in ms)


function startGui() {
	// find elements
	convertTextSetting = "continuous"; 
	convertTextButton = document.getElementById("convertTextButton");
	paneSetting = document.getElementById("paneSetting");

	inputPane = document.getElementById("inputPane");
	previewPane = document.getElementById("previewPane");
	outputPane = document.getElementById("outputPane");

	convertTextSetting.onchange = onConvertTextSettingChanged;
	paneSetting.onchange = onPaneSettingChanged;
	window.onresize = setPaneHeights;

	// First, try registering for keyup events
	// (There's no harm in calling onInput() repeatedly)
	window.onkeyup = inputPane.onkeyup = onInput;

	// In case we can't capture paste events, poll for them
	var pollingFallback = window.setInterval(function(){
		if(inputPane.value != lastText)
			onInput();
	},1000);

	// Try registering for paste events
	inputPane.onpaste = function() {
		// It worked! Cancel paste polling.
		if (pollingFallback!=undefined) {
			window.clearInterval(pollingFallback);
			pollingFallback = undefined;
		}
		onInput();
	}

	// Try registering for input events (the best solution)
	if (inputPane.addEventListener) {
		// Let's assume input also fires on paste.
		// No need to cancel our keyup handlers;
		// they're basically free.
		inputPane.addEventListener("input",inputPane.onpaste,false);
	}

	// poll for changes in font size
	// this is cheap; do it often
	window.setInterval(setPaneHeights,250);

	// start with blank page?
	if (top.document.location.href.match(/\?blank=1$/))
		inputPane.value = "";

	// refresh panes to avoid a hiccup
	onPaneSettingChanged();

	// build the converter
	converter = new Showdown.converter({extensions:['table']});

	// do an initial conversion to avoid a hiccup
	convertText();

	// give the input pane focus
	inputPane.focus();

	// start the other panes at the top
	// (our smart scrolling moved them to the bottom)
	previewPane.scrollTop = 0;
	outputPane.scrollTop = 0;
}

function getwordcount() {
    var str = $("#inputPane").val();
    var count = 0;
    for(var i = 0; i < str.length; i ++){
	   var ch = str.charAt(i);
	        if(ch > '~' || (ch >= 'A' && ch <= 'Z') || (ch >= 'a' && ch <= 'z' )){
	            count += 1;
	        }
        }
    return "字数数量：" + count;
}


//
//	Conversion
//

function highlightCode() {
    var tag = $("pre").each(function(){
        var lan = $(this).attr("class");
        if(lan !== "undefined"){
            var classname = "pre." + lan;
            document.getElements(classname).enlight({language:lan});
        }
    });
}

function convertText() {
	// get input text
	var text = inputPane.value;
	
	// if there's no change to input, cancel conversion
	if (text && text == lastText) {
		return;
	} else {
		lastText = text;
	}

	var startTime = new Date().getTime();

	// Do the conversion
	text = converter.makeHtml(text);

	// display processing time
	var endTime = new Date().getTime();	
	processingTime = endTime - startTime;
	document.getElementById("processingTime").innerHTML = null;
	// save proportional scroll positions
	saveScrollPositions();

	// update right pane
	if (paneSetting.value == "outputPane") {
		// the output pane is selected
		outputPane.value = text;
        htmlcode = text;
	} else if (paneSetting.value == "previewPane") {
		// the preview pane is selected	
        $("#previewPane").html(text);
        htmlcode = text;
        highlightCode();
        document.getElementById("wordcount").innerHTML = getwordcount();
	}

	lastOutput = text;

	// restore proportional scroll positions
	restoreScrollPositions();
};


//
//	Event handlers
//

function onConvertTextSettingChanged() {
	// If the user just enabled automatic
	// updates, we'll do one now.
	onInput();
}


function onPaneSettingChanged() {
	previewPane.style.display = "none";
	outputPane.style.display = "none";

	// now make the selected one visible
	top[paneSetting.value].style.display = "block";

	lastRoomLeft = 0;  // hack: force resize of new pane
	setPaneHeights();

	if (paneSetting.value == "outputPane") {
		// Update output pane
		outputPane.value = lastOutput;
	} else if (paneSetting.value == "previewPane") {
		// Update preview pane
		previewPane.innerHTML = lastOutput;
        highlightCode();
	}
}


function onInput() {
// In "delayed" mode, we do the conversion at pauses in input.
// The pause is equal to the last runtime, so that slow
// updates happen less frequently.
//
// Use a timer to schedule updates.  Each keystroke
// resets the timer.

	// if we already have convertText scheduled, cancel it
	if (convertTextTimer) {
		window.clearTimeout(convertTextTimer);
		convertTextTimer = undefined;
	}

	if (convertTextSetting.value != "manual") {
		var timeUntilConvertText = 0;
		if (convertTextSetting.value == "delayed") {
			// make timer adaptive
			timeUntilConvertText = processingTime;
		}

		if (timeUntilConvertText > maxDelay)
			timeUntilConvertText = maxDelay;

		// Schedule convertText().
		// Even if we're updating every keystroke, use a timer at 0.
		// This gives the browser time to handle other events.
		convertTextTimer = window.setTimeout(convertText,timeUntilConvertText);
	}
}


//
// Smart scrollbar adjustment
//
// We need to make sure the user can't type off the bottom
// of the preview and output pages.  We'll do this by saving
// the proportional scroll positions before the update, and
// restoring them afterwards.
//

var previewScrollPos;
var outputScrollPos;

function getScrollPos(element) {
	// favor the bottom when the text first overflows the window
	if (element.scrollHeight <= element.clientHeight)
		return 1.0;
	return element.scrollTop/(element.scrollHeight-element.clientHeight);
}

function setScrollPos(element,pos) {
	element.scrollTop = (element.scrollHeight - element.clientHeight) * pos;
}

function saveScrollPositions() {
	previewScrollPos = getScrollPos(previewPane);
	outputScrollPos = getScrollPos(outputPane);
}

function restoreScrollPositions() {
	// hack for IE: setting scrollTop ensures scrollHeight
	// has been updated after a change in contents
	previewPane.scrollTop = previewPane.scrollTop;

	setScrollPos(previewPane,previewScrollPos);
	setScrollPos(outputPane,outputScrollPos);
}

function getTop(element) {
	var sum = element.offsetTop;
	while(element = element.offsetParent)
		sum += element.offsetTop;
	return sum;
}

function getElementHeight(element) {
	var height = element.clientHeight;
	if (!height) height = element.scrollHeight;
	return height;
}

function getWindowHeight(element) {
	if (window.innerHeight)
		return window.innerHeight;
	else if (document.documentElement && document.documentElement.clientHeight)
		return document.documentElement.clientHeight;
	else if (document.body)
		return document.body.clientHeight;
}

function setPaneHeights() {
    console.log("called this");
//    var textarea  = inputPane;
//	var footer = document.getElementById("footer");
//
//	var windowHeight = getWindowHeight();
//	var footerHeight = getElementHeight(footer);
//	var textareaTop = getTop(textarea);
//
//	// figure out how much room the panes should fill
//	var roomLeft = windowHeight - footerHeight - textareaTop;
//
//	if (roomLeft < 0) roomLeft = 0;
//
//	// if it hasn't changed, return
//	if (roomLeft == lastRoomLeft) {
//		return;
//	}
//	lastRoomLeft = roomLeft;
//
//	// resize all panes
//	inputPane.style.height = roomLeft + "px";
//	previewPane.style.height = roomLeft + "px";
//	outputPane.style.height = roomLeft + "px";
}
