(function( $ ) {
	'use strict';

	$(document).ready(function(){
	
		// Initial Hide Remove if only one line
		if( $("div.rs-dash-rel-posts-row").length > 2 ) $("div.rs-dash-rel-posts-row .eg-icon-cancel").show();

		// Add Line
		$("#rs_addon_rel_post_type_add").click(function(){
			var $tableBody = $('#rs-dash-rel-posts-table');
			var $trLast = $tableBody.find("div.rs-dash-rel-posts-row:last");
		    var $trNew = $trLast.clone(true);
		    $trNew.find("select").val("");
			$trLast.after($trNew);
			if( $("div.rs-dash-rel-posts-row").length > 2 ) $("div.rs-dash-rel-posts-row .eg-icon-cancel").show();
		});

		// Remove Line
		$(".eg-icon-cancel").click(function(){
			var $this = jQuery(this);
			$this.closest("div.rs-dash-rel-posts-row").remove();
			console.log($("div.rs-dash-rel-posts-row").length);
			if( $("div.rs-dash-rel-posts-row").length <= 2 ) $("div.rs-dash-rel-posts-row .eg-icon-cancel").hide();
		});

		// Setup a click handler to initiate the Ajax request and handle the response
		$('#rs-addon-rel_posts-save').click(function(evt) {
			$('#rs_addon-rel_posts-wait').show();
			$('#rs-addon-rel_posts-save').hide();

			if (checkDuplicateField('.rs-addon-rel-post-type')) {
				//todo: call RevSlider error display
				alert("Duplicate Post Types");
				return;
			};


			$.ajax({
				url : rev_slider_addon_rel_posts.ajax_url,
				type : 'post',
				data : {
					action : 'save_rel_posts',
					nonce: 	$('#ajax_rev_slider_addon_rel_posts_nonce').text(), // The security nonce
					sliders: $('#rs-addon-rel_post-form').serialize()
				},
				success : function( response ) {
					$('#rs_addon-rel_posts-wait').hide();
					$('#rs-addon-rel_posts-save').show();
					switch(response){
						case "0":
								console.log("No Sliders");
								break;
						case "1":
								console.log("Sliders Saved");
								break;
						case "-1":
								console.log("Nonce missing");
								break;
					}
				},
				error : function ( response ){
					console.log('Ajax Error');
				}
			}); // End Ajax
			
		}); // End Click

	}); // End document ready

	function checkDuplicateField(selector) {
	    var fields = $( selector ).serializeArray();
	    var result_array = [];
	    jQuery.each( fields, function( i, field ) {
	      result_array.push(field.value);
	    });
		return duplicatetruefalse(result_array);
	}

	function duplicatetruefalse(a) {
	    var counts = [];
	    for(var i = 0; i <= a.length; i++) {
	        if(counts[a[i]] === undefined) {
	            counts[a[i]] = 1;
	        } else {
	            return true;
	        }
	    }
	    return false;
	}
})( jQuery );

