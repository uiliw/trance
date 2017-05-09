(function( $ ) {
	//'use strict';

	/*! Main Functionality for Settings SlideOut */
			jQuery('document').ready(function() {
				var a = jQuery('#revslider_maintenance_addon_settings_slideout');
				punchgs.TweenLite.set(a,{xPercent:"+100%", autoAlpha:0, display:"none"});

				jQuery('body').on('click', '#rs-dash-addons-slide-out-trigger_revslider-maintenance-addon', function() {
					//hide all wrappers
					jQuery('.rs-sbs-slideout-wrapper').each(function(){
						punchgs.TweenLite.to(jQuery(this),0.4,{xPercent:"+100%", autoAlpha:0, display:"none",overwrite:"auto",ease:punchgs.Power3.easeInOut});
					});

					//display slideout
					var a = jQuery('#revslider_maintenance_addon_settings_slideout'),
						b = jQuery('.rs-dash-addons');						
					punchgs.TweenLite.to(a,0.4,{xPercent:"0%", autoAlpha:1, display:"block",overwrite:"auto",ease:punchgs.Power3.easeOut});
				});
				jQuery('body').on('click','#revslider_maintenance_addon_settings_slideout .rs-sbs-close', function() {
					var a = jQuery('#revslider_maintenance_addon_settings_slideout');				
					punchgs.TweenLite.to(a,0.4,{xPercent:"+100%", autoAlpha:0, display:"none",overwrite:"auto",ease:punchgs.Power3.easeInOut});
				});

				//enable Scrollbars
				jQuery('#revslider_maintenance_addon_settings_slideout .rs-sbs-slideout-inner').css("max-height",$( window ).height()-300);
					setTimeout(function() {
						jQuery('#revslider_maintenance_addon_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar("update");
					},400);
				$(window).resize(function(){
					jQuery('#revslider_maintenance_addon_settings_slideout .rs-sbs-slideout-inner').css("max-height",$( window ).height()-300);
					jQuery('#revslider_maintenance_addon_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar("update");
				});

				//call scrollbars
				jQuery('#revslider_maintenance_addon_settings_slideout .rs-sbs-slideout-inner').perfectScrollbar({wheelPropagation:true, suppressScrollX:true});

				$('input[name=revslider-maintenance-addon-type]').click(function(){
					$(".revslider_maintenance_type_details").hide();
					$('#revslider_maintenance_type_'+$('input[name=revslider-maintenance-addon-type]:checked').val()).show();
				});
				//$('#revslider_maintenance_type_'+$('input[name=revslider-maintenance-addon-type]:checked').val()).show();

				$check_val = $('input[name=revslider-maintenance-addon-type]:checked').length ? $('input[name=revslider-maintenance-addon-type]:checked').val() : 'slider';
				$('#revslider_maintenance_type_'+$check_val).show();

				// Setup a click handler to initiate the Ajax request and handle the response
				$('#revslider-maintenance-addon-save').live("click",function(evt) {
					showWaitAMinute({fadeIn:300,text:rev_slider_addon.please_wait_a_moment});
					$.ajax({
						url : revslider_maintenance_addon.ajax_url,
						type : 'post',
						data : {
							action : 'save_maintenance',
							nonce: 	$('#ajax_revslider_maintenance_addon_nonce').text(), // The security nonce
							revslider_maintenance_form: $('#revslider-maintenance-addon-form').serialize()
						},
						success : function( response ) {
							switch(response){
								case "0":
										UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Ajax Error', hidedelay: 3});
										break;
								case "1":
										UniteAdminRev.showInfo({type: 'success', hideon: '', event: '', content: rev_slider_addon.settings_saved, hidedelay: 3});
										break;
								case "-1":
										UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Nonce missing', hidedelay: 3});
										break;
							}
							showWaitAMinute({fadeOut:300,text:rev_slider_addon.please_wait_a_moment});
						},
						error : function ( response ){
							UniteAdminRev.showInfo({type: 'warning', hideon: '', event: '', content: 'Ajax Error', hidedelay: 3});
						}
					}); // End Ajax
					
				}); // End Click


				// Tabs for Content Source
				$('body').on('click','.rs-submenu-tabs li', function() {
					$('.rs-submenu-tabs li').removeClass("selected");
					$(this).addClass("selected");
					$('.subcat-wrapper').hide();
					$($(this).data('content')).show();
					// Show Hide Details per Type
					//check_for_posttype( $($(this).data('content')).find('select.rs-addon-rel-slider-switch') );
				});

				$('#revslider-maintenance-addon-countdown-active').click(function(){
					check_countdown();
				});
				check_countdown();

				// Init Datepicker
				$('.datepicker').datepicker({dateFormat: "yy-mm-dd",minDate: 0});
				
			}); //end document ready

			function check_countdown(){
				if($('#revslider-maintenance-addon-countdown-active:checked').length) {
				    $("#revslider-maintenance-addon-submenu").show();
				} else {
				    $("#revslider-maintenance-addon-submenu").hide();
				}
			}

})( jQuery );