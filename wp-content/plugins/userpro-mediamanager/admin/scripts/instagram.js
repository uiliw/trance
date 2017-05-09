jQuery(document).ready(function(){

	if( !jQuery('#instagram_app_key').val() ) {
			jQuery('.instabutton').hide();
	}
		
    var page=getParameterByName('page');
    if(page == 'userpro-media' ){
	var hash = window.location.hash,
	token = hash.substring(14),
        id = token.split('.')[0];
    	
	if (hash){
	jQuery.ajax({
	url: ajaxurl,
	data: 'action=save_instagram_code&access_token='+token,
	dataType: 'JSON',
	type: 'POST',
	success:function(data){
			location.href = data.redirect_uri;
			}
		});
	}
    }
	
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
