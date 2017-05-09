<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.themepunch.com
 * @since      1.0.0
 *
 * @package    Revslider_Maintenance_Addon
 * @subpackage Revslider_Maintenance_Addon/public/partials
 */

$revslider_maintenance_addon_values = array();
parse_str(get_option('revslider_maintenance_addon'), $revslider_maintenance_addon_values);

//defaults
$revslider_maintenance_addon_values['revslider-maintenance-addon-type'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-type']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-type'] : 'slider';
$revslider_maintenance_addon_values['revslider-maintenance-addon-active'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-active']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-active'] : '0';
$revslider_maintenance_addon_values['revslider-maintenance-addon-slider'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-slider']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-slider'] : '';
$revslider_maintenance_addon_values['revslider-maintenance-addon-page'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-page']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-page'] : '';

//Date Defaults
$date=date_create(date('Y-m-d G:i',time()));
$default_date = date_format($date,"F d, Y");
$default_hour = date_format($date,"G");
$default_minute = date_format($date,"i");

$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day'] : $default_date;
$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'] : $default_hour;
$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute'] : $default_minute;

$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active'] : '0';

$revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive'] = isset($revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive']) ? $revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive'] : '0';

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<title><?php echo !empty($revslider_maintenance_addon_values['revslider-maintenance-addon-page-title']) && $revslider_maintenance_addon_values['revslider-maintenance-addon-type']=="slider" ? stripslashes($revslider_maintenance_addon_values['revslider-maintenance-addon-page-title']) : get_bloginfo( 'name' );?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<style>
		body { background: transparent; }
		body:before , body:after { height:0; }
	</style>
</head>

<body <?php body_class(); ?>>
<div>
	<?php
		if($revslider_maintenance_addon_values['revslider-maintenance-addon-type'] == 'slider'){
			$content = '[rev_slider alias="'.$revslider_maintenance_addon_values['revslider-maintenance-addon-slider'].'"]';
		}
		else {
			$content = get_post_field('post_content', $revslider_maintenance_addon_values['revslider-maintenance-addon-page']);
		}
		echo do_shortcode($content);
	?>

	<?php if($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-active']){ ?>
	<script>
		
		tpj(document).ready(function() {
			var targetdate = '<?php echo ($revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-day']." ".$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-hour'].":".$revslider_maintenance_addon_values['revslider-maintenance-addon-countdown-minute']); ?>:00' ,// i.e. '2015/12/31 24:00',
			    slidechanges = [
			                    { days:0, hours:0, minutes:0, seconds:12, slide:2},
			                    { days:0, hours:0, minutes:0, seconds:0, slide:3}
			                    ],
			    quickjump = 15000,
			    t_days,
				t_hours,
				t_minutes,
				t_seconds;

			 id_array = jQuery(".rev_slider_wrapper:first").attr("id").split("_");
			 id = id_array[2];
    		 jQuery.globalEval('var api = revapi'+id+';');

    		 function maint_quick_change(a) {    		 	
    		 	 jQuery(".tp-caption:contains('%"+a+"%')" ).each(function(){    	
				 	var _ = jQuery(this);					 
					_.html(_.html().replace('%'+a+'%','<'+a+' class="'+a+'" style="display:inline-block;position:relative;">00</'+a+'>'));										
				  }); 
    		 	 return jQuery('.'+a);
    		 }

    		 t_days = maint_quick_change("t_days");
    		 t_hours = maint_quick_change("t_hours");
    		 t_minutes = maint_quick_change("t_minutes");
    		 t_seconds = maint_quick_change("t_seconds");
					
		   
			// countdown.js jQuery Engine MADE BY HILIOS
			// https://github.com/hilios/jQuery.countdown
			!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery)}(function(t){"use strict";function e(t){if(t instanceof Date)return t;if(String(t).match(o))return String(t).match(/^[0-9]*$/)&&(t=Number(t)),String(t).match(/\-/)&&(t=String(t).replace(/\-/g,"/")),new Date(t);throw new Error("Couldn't cast `"+t+"` to a date object.")}function s(t){var e=t.toString().replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1");return new RegExp(e)}function n(t){return function(e){var n=e.match(/%(-|!)?[A-Z]{1}(:[^;]+;)?/gi);if(n)for(var a=0,o=n.length;o>a;++a){var r=n[a].match(/%(-|!)?([a-zA-Z]{1})(:[^;]+;)?/),l=s(r[0]),c=r[1]||"",u=r[3]||"",f=null;r=r[2],h.hasOwnProperty(r)&&(f=h[r],f=Number(t[f])),null!==f&&("!"===c&&(f=i(u,f)),""===c&&10>f&&(f="0"+f.toString()),e=e.replace(l,f.toString()))}return e=e.replace(/%%/,"%")}}function i(t,e){var s="s",n="";return t&&(t=t.replace(/(:|;|\s)/gi,"").split(/\,/),1===t.length?s=t[0]:(n=t[0],s=t[1])),1===Math.abs(e)?n:s}var a=[],o=[],r={precision:100,elapse:!1};o.push(/^[0-9]*$/.source),o.push(/([0-9]{1,2}\/){2}[0-9]{4}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),o.push(/[0-9]{4}([\/\-][0-9]{1,2}){2}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),o=new RegExp(o.join("|"));var h={Y:"years",m:"months",n:"daysToMonth",w:"weeks",d:"daysToWeek",D:"totalDays",H:"hours",M:"minutes",S:"seconds"},l=function(e,s,n){this.el=e,this.$el=t(e),this.interval=null,this.offset={},this.options=t.extend({},r),this.instanceNumber=a.length,a.push(this),this.$el.data("countdown-instance",this.instanceNumber),n&&("function"==typeof n?(this.$el.on("update.countdown",n),this.$el.on("stoped.countdown",n),this.$el.on("finish.countdown",n)):this.options=t.extend({},r,n)),this.setFinalDate(s),this.start()};t.extend(l.prototype,{start:function(){null!==this.interval&&clearInterval(this.interval);var t=this;this.update(),this.interval=setInterval(function(){t.update.call(t)},this.options.precision)},stop:function(){clearInterval(this.interval),this.interval=null,this.dispatchEvent("stoped")},toggle:function(){this.interval?this.stop():this.start()},pause:function(){this.stop()},resume:function(){this.start()},remove:function(){this.stop.call(this),a[this.instanceNumber]=null,delete this.$el.data().countdownInstance},setFinalDate:function(t){this.finalDate=e(t)},update:function(){if(0===this.$el.closest("html").length)return void this.remove();var e,s=void 0!==t._data(this.el,"events"),n=new Date;e=this.finalDate.getTime()-n.getTime(),e=Math.ceil(e/1e3),e=!this.options.elapse&&0>e?0:Math.abs(e),this.totalSecsLeft!==e&&s&&(this.totalSecsLeft=e,this.elapsed=n>=this.finalDate,this.offset={seconds:this.totalSecsLeft%60,minutes:Math.floor(this.totalSecsLeft/60)%60,hours:Math.floor(this.totalSecsLeft/60/60)%24,days:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToWeek:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToMonth:Math.floor(this.totalSecsLeft/60/60/24%30.4368),totalDays:Math.floor(this.totalSecsLeft/60/60/24),weeks:Math.floor(this.totalSecsLeft/60/60/24/7),months:Math.floor(this.totalSecsLeft/60/60/24/30.4368),years:Math.abs(this.finalDate.getFullYear()-n.getFullYear())},this.options.elapse||0!==this.totalSecsLeft?this.dispatchEvent("update"):(this.stop(),this.dispatchEvent("finish")))},dispatchEvent:function(e){var s=t.Event(e+".countdown");s.finalDate=this.finalDate,s.elapsed=this.elapsed,s.offset=t.extend({},this.offset),s.strftime=n(this.offset),this.$el.trigger(s)}}),t.fn.countdown=function(){var e=Array.prototype.slice.call(arguments,0);return this.each(function(){var s=t(this).data("countdown-instance");if(void 0!==s){var n=a[s],i=e[0];l.prototype.hasOwnProperty(i)?n[i].apply(n,e.slice(1)):null===String(i).match(/^[$A-Z_][0-9A-Z_$]*$/i)?(n.setFinalDate.call(n,i),n.start()):t.error("Method %s does not exist on jQuery.countdown".replace(/\%s/gi,i))}else new l(this,e[0],e[1])})}});


			var currentd,currenth,currentm,currents;

			function animateAndUpdate(o,nt,ot) {
			   if (ot==undefined) {    
			     o.html(nt);
			   } else {      
			      if (o.css("opacity")>0) {
			      punchgs.TweenLite.fromTo(o,0.45,
			  		{autoAlpha:1,rotationY:0,scale:1},
			  		{autoAlpha:0,rotationY:-180,scale:0.5,ease:punchgs.Back.easeIn,onComplete:function() { o.html(nt);} });

			  punchgs.TweenLite.fromTo(o,0.45,
			  		{autoAlpha:0,rotationY:180,scale:0.5},
			  		{autoAlpha:1,rotationY:0,scale:1,ease:punchgs.Back.easeOut,delay:0.5 });
			      } else {
			         o.html(nt);
			      }
			   }
			  return nt;
			}

			function countprocess(event) {


			  var newd = event.strftime('%D'),
			      newh = event.strftime('%H'),
			      newm = event.strftime('%M'),
			      news = event.strftime('%S');

			<?php if($revslider_maintenance_addon_values['revslider-maintenance-addon-auto-deactive']){ ?>if(newd=="00" && newh=="00" && newm=="00" && news=="00") window.location.reload();<?php } ?>

			if (newd != currentd) currentd = animateAndUpdate(t_days,newd,currentd);
			if (newh != currenth) currenth = animateAndUpdate(t_hours,newh,currenth);
			if (newm != currentm) currentm = animateAndUpdate(t_minutes,newm,currentm);
			if (news != currents) currents = animateAndUpdate(t_seconds,news,currents);			  			

			  jQuery.each(slidechanges,function(i,obj) {
			    var dr = obj.days==undefined || obj.days>=newd,
			        hr = obj.hours==undefined || obj.hours>=newh,
			        mr = obj.minutes==undefined || obj.minutes>=newm,
			        sr = obj.seconds==undefined || obj.seconds>=news;
			      if (dr && hr && mr && sr && !obj.changedown) {
			         api.revshowslide(obj.slide);
			         obj.changedown = true;
			      }
			  })
			}

			api.countdown(targetdate, countprocess);
		});
	</script>
	<?php } ?>
</div><!-- .site-content -->
<?php wp_footer(); ?>

</body>
</html>