jQuery(function(t){"use strict";t(document).ready(function(){t(".gbt-plugins").on("click",".button.ajax-request",function(s){s.preventDefault();var a=t(this).attr("href"),e=t(this).attr("data-plugin"),n=t(this).attr("data-verify"),r=t(this).attr("data-action"),i=t(this);i.addClass("updating-message"),i.text(gbtStrings.plugin[r].doing+"..."),jQuery.ajax({url:a,type:"get"}).complete(function(){t.post(n,{action:"gbt_get_plugins",gbt_plugin:e},function(t){!0===t?(i.removeClass("updating-message"),i.text(gbtStrings.plugin[r].done),i.attr("class","button ajax-request updated-message button-disabled")):(i.removeClass("updating-message"),i.text(gbtStrings.plugin.error),i.attr("class","button ajax-request failed-message"))})})})})}),jQuery(function(t){"use strict";t(document).ready(function(){t(".tooltip").tooltipster()}),t(".getbowtied-install-demo-button").on("click",function(s){t(this).addClass("clicked"),t(".status-log").empty().removeClass("ajax-done ajax-error status-success status-error"),t(".status-importer").attr("class","status-log doing-ajax status-importer").append(gbtStrings.start_import+"...");var a=t(this).attr("data-demo"),e={action:"gbt_demo_importer",demo_type:a};jQuery.ajax({url:gbtAjaxurl,data:e,dataType:"json",type:"post"}).complete(function(s){if(200===s.status){t(".status-importer").removeClass("doing-ajax").addClass("ajax-done"),t(".status-settings").attr("class","status-log status-settings doing-ajax").append(gbtStrings.start_settings+"...");var e={action:"gbt_after_import",demo_type:a};jQuery.ajax({url:gbtAjaxurl,data:e,dataType:"json",type:"post"}).complete(function(s){200===s.status?(t(".status-settings").attr("class","status-log status-settings ajax-done"),t(".status-final").attr("class","status-log status-final status-success").append(gbtStrings.view_site)):(t(".status-settings").attr("class","status-log status-settings ajax-error"),t(".status-final").attr("class","status-log status-final status-success").append(gbtStrings.view_site))})}else s.status,t(".status-importer").attr("class","status-log status-importer ajax-error"),t(".status-final").attr("class","status-log status-final status-error").append(gbtStrings.import_error)}),s.preventDefault()}),t(".import-try-again").on("click",function(){t(".getbowtied-install-demo-button").trigger("click")})}),jQuery(function(t){"use strict";t(document).on("click",".open-plugin-details-modal",function(){console.log("test")})});