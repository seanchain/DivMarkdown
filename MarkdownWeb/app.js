/**
 * Created by seanchain on 5/11/15.
 */
$(function () {
    $("#clearPage").click(function () {
        $("#inputPane").val('');
    });
    $("#wordcount").text(getwordcount());
    $("#savepdf").click(function () {
        $.post("savepdf.php",
            {
                code: htmlcode
            }, function (res) {
                console.log("success");
                window.location.href = "./handlesave.php";
            });
    });
    $(document).delegate('#inputPane', 'keydown', function (e) {
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

    document.addEventListener("keydown", function (event) {
        if (event.keyCode === 27) {
            var curr = $("#inputPane").prop("selectionStart");
            str = "";
            for (var i = curr - 3; i < curr; i++) {
                str += $("#inputPane").val().charAt(i);
            }
            if (str == "lnk") {
                var suc = $("#inputPane").val().replace(str, "[]()");
                $("#inputPane").val(suc);
            }
            if (str == "img") {
                var suc = $("#inputPane").val().replace(str, "![]()");
                $("#inputPane").val(suc);
            }
        }
    });

});