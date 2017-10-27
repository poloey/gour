jQuery(function($) {

    "use strict";
   
    /* global gbtAjaxurl gbtStrings */


    $(document).ready(function() {
        $(".tooltip").tooltipster();
    });

    $(".getbowtied-install-demo-button").on("click", function(e) {
        $(this).addClass("clicked");
        $(".status-log").empty().removeClass("ajax-done ajax-error status-success status-error");
        $(".status-importer").attr("class", "status-log doing-ajax status-importer").append(gbtStrings.start_import + "...");

        var demo_type = $(this).attr("data-demo");

        var data = {
            action: "gbt_demo_importer",
            demo_type: demo_type
        };

        var runImport = jQuery.ajax({
            url: gbtAjaxurl,
            data: data,
            dataType: "json",
            type: "post"
        });

        runImport.complete(function(e, xhr){

            if(e.status === 200)
            {
                // We"re going to assune the import ran correctly
                $(".status-importer").removeClass("doing-ajax").addClass("ajax-done");
                $(".status-settings").attr("class", "status-log status-settings doing-ajax").append(gbtStrings.start_settings + "...")

                var data_2 = { 
                    action: "gbt_after_import",
                    demo_type: demo_type
                }

                var afterImport = jQuery.ajax({
                    url: gbtAjaxurl,
                    data: data_2,
                    dataType: "json",
                    type: "post"
                });

                afterImport.complete(function(rsp) {

                    if(rsp.status === 200) {
                        $(".status-settings").attr("class", "status-log status-settings ajax-done");
                        $(".status-final").attr("class", "status-log status-final status-success").append(gbtStrings.view_site);
                    } else {
                        $(".status-settings").attr("class", "status-log status-settings ajax-error");
                        $(".status-final").attr("class", "status-log status-final status-success").append(gbtStrings.view_site);
                    }
                });
            }   
            else if(e.status === 500)   
            {
                // Internal server error; most likely low resources
                $(".status-importer").attr("class", "status-log status-importer ajax-error");
                $(".status-final").attr("class", "status-log status-final status-error").append(gbtStrings.import_error);
            }   
            else    
            {
                // Not sure what happened here
                $(".status-importer").attr("class", "status-log status-importer ajax-error");
                $(".status-final").attr("class", "status-log status-final status-error").append(gbtStrings.import_error);
            }
        });

        e.preventDefault();
    });

    $(".import-try-again").on("click", function(e) {
        $(".getbowtied-install-demo-button").trigger("click");
    });

});