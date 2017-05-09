<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// MEC Settings
$settings = $this->get_settings();

// Countdown on single page is disabled
if(!isset($settings['countdown_status']) or (isset($settings['countdown_status']) and !$settings['countdown_status'])) return;

$event = $event[0];
$date = $event->date;

$start_date = (isset($date['start']) and isset($date['start']['date'])) ? $date['start']['date'] : date('Y-m-d H:i:s');

$current_time = '';
$current_time .= sprintf("%02d", $date['start']['hour']).':';
$current_time .= sprintf("%02d", $date['start']['minutes']);
$current_time .= trim($date['start']['ampm']);

$start_time = date('D M j Y G:i:s', strtotime($start_date.' '.date('H:i:s', strtotime($current_time))));

$d1 = new DateTime($start_time);
$d2 = new DateTime(date("D M j Y G:i:s"));

if($d1 < $d2)
{
    echo '<div class="mec-end-counts"><h3>'.__('The Event Is Finished.', 'mec').'</h3></div>';
    return;
}

$gmt_offset = $this->get_gmt_offset();
if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') === false) $gmt_offset = ' : '.$gmt_offset;

// Generating javascript code of countdown default module
$defaultjs = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#countdown").mecCountDown(
    {
        date: "'.$start_time.$gmt_offset.'",
        format: "off"
    },
    function()
    {
    });
});
</script>';

// Generating javascript code of countdown flip module
$flipjs = '<script type="text/javascript">
var clock;
jQuery(document).ready(function()
{
    var clock;

    clock = jQuery(".clock").FlipClock(
    {
        clockFace: "DailyCounter",
        autoStart: false,
        callbacks:
        {
            stop: function()
            {
                jQuery(".message").html("The clock has stopped!")
            }
        }
    });

    var inauguration = new Date("'.$start_time.$gmt_offset.'");
    var now = Date.now();
    
    var diff = inauguration.getTime() - now;
    diff = diff / 1000;
    
    clock.setTime(diff);
    clock.setCountdown(true);
    clock.start();
    jQuery(".mec-wrap .flip-clock-wrapper ul li, a .shadow, a .inn").on("click", function(event) {
        event.preventDefault();
    });
});
</script>';
?>
<?php if($settings['countdown_list'] === 'default'): $factory->params('footer', $defaultjs); ?>
<div class="mec-countdown-details" id="mec_countdown_details">
    <div class="countdown-w ctd-simple">
        <ul class="clockdiv" id="countdown">
            <div class="days-w block-w">
                <li>
                    <i class="icon-w mec-li_calendar"></i>
                    <span class="mec-days">00</span>
                    <p class="mec-timeRefDays label-w"><?php _e('days', 'mec'); ?></p>
                </li>
            </div>
            <div class="hours-w block-w">    
                <li>
                    <i class="icon-w mec-fa-clock-o"></i>
                    <span class="mec-hours">00</span>
                    <p class="mec-timeRefHours label-w"><?php _e('hours', 'mec'); ?></p>
                </li>
            </div>  
            <div class="minutes-w block-w">
                <li>
                    <i class="icon-w mec-li_clock"></i>
                    <span class="mec-minutes">00</span>
                    <p class="mec-timeRefMinutes label-w"><?php _e('minutes', 'mec'); ?></p>
                </li>
            </div>
            <div class="seconds-w block-w">
                <li>
                    <i class="icon-w mec-li_heart"></i>
                    <span class="mec-seconds">00</span>
                    <p class="mec-timeRefSeconds label-w"><?php _e('seconds', 'mec'); ?></p>
                </li>
            </div>
        </ul>
    </div>
</div>
<?php elseif($settings['countdown_list'] === 'flip'): $factory->params('footer', $flipjs); ?>
<div class="clock"></div>
<div class="message"></div>
<?php endif;