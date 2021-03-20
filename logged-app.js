$(document).ready(function () {

    $("#diary").bind('input propertychange', function () {

        $.ajax({
            method: "POST",
            url: "updateDatabase.php",
            data: { content: $("#diary").val() }
        })
    });
});