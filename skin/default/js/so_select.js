$(document).ready(function () {
    $(".select_box input").click(function () {
        var thisinput = $(this);
        var thisul = $(this).parent().find("ul");
        if (thisul.css("display") == "none") {
            if (thisul.height() > 200) { thisul.css({ height: "200" + "px", "overflow-y": "scroll" }) };
            thisul.fadeIn("100");
            thisul.hover(function () { }, function () { thisul.fadeOut("100"); })
            thisul.find("li").click(function () {
                thisinput.val($(this).text());
                thisinput.attr('name', $(this).attr('name'));
                thisul.fadeOut("100");
            }).hover(function () { $(this).addClass("hover"); }, function () { $(this).removeClass("hover"); });
        }
        else {
            thisul.fadeOut("fast");
        }
    })
    //$(".so_botton").click(function () {
    //     var endinfo = "";
    //     $(".select_box input:text").each(function (i) {
    //         endinfo = $(this).attr('name') + "*";
    //     });
    //    $('.hid_txt_s').val(endinfo);
    //})
});
