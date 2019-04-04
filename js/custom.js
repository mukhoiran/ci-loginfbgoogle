jQuery.noConflict();
ddsmoothmenu.init({
    mainmenuid: "menu", //menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'smoothmenu', //class added to menu's outer DIV
    //customtheme: ["#1c5a80", "#18374a"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
});
//Colorbox
jQuery(document).ready(function() {
    jQuery(".save_form").colorbox({
        iframe: true,
        innerWidth: 420,
        innerHeight: 300,
        height: 300,
        initialHeight: 290,
        maxHeight: 320
    });
});
jQuery(".slide_body").hide();
//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
$(".slide_edit_button, .option-click").live('click', function() {
    /*
     //display as an accordion
     $(".slide_header").removeClass("active");	
     $(".slide_body").slideUp("fast");
     */
    //toggle for each
    $(this).parent().toggleClass("active").next().slideToggle("fast");
    return false; //Prevent the browser jump to the link anchor
});

function fg_tipsy(id) {
    jQuery(function() {
        jQuery(id).tipsy({
            gravity: 'w',
            fade: true,
            title: 'ftext',
        });

    });
}


function ping_sess() {
    $.ajax({
        type: "POST",
        url: base_url + "logout/ping_data",
        success: function(data) {
            if (data == '0') {
                setInterval(function() {
                    alert("logout");
                    window.location.assign(base_url);
                }, 5000);

            } else {
                setInterval(function() {
                    ping_sess();

                }, 5000);
            }


        }
    });
}




