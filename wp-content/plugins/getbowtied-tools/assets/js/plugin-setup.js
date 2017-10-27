jQuery(function($) {

	"use strict";

	$(document).ready(function(){
		$(".gbt-plugins").on("click", ".button.ajax-request", function(e){
			e.preventDefault();

			var url = $(this).attr("href");
			var pluginSlug = $(this).attr("data-plugin");
			var ajaxUrl = $(this).attr("data-verify");
			var action = $(this).attr("data-action");

			var self = $(this);

			self.addClass("updating-message"); // add wp installing spinner
			self.text(gbtStrings.plugin[action]["doing"] + "...");

			var doAction = jQuery.ajax({
				url: url,
		        type: "get"
			});

			doAction.complete(function(e, xhr){ 

				$.post(ajaxUrl,
				{
					action	  : "gbt_get_plugins",
					gbt_plugin: pluginSlug
				},
				function ( rsp ) { 
					if ( rsp === true ) {
						// The action was done correctly
						self.removeClass("updating-message");
						self.text(gbtStrings.plugin[action]["done"]);
						self.attr("class", "button ajax-request updated-message button-disabled");


					} else {
						// The action failed for whatever reason
						self.removeClass("updating-message");
						self.text(gbtStrings.plugin["error"]);
						self.attr("class", "button ajax-request failed-message");
					}
				});
			});
		})
	})
})