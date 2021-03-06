<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC countdown class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_skin_countdown extends MEC_skins
{
    /**
     * @var string
     */
    public $skin = 'countdown';
    
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Registers skin actions into WordPress
     * @author Webnus <info@webnus.biz>
     */
    public function actions()
    {
    }
    
    /**
     * Initialize the skin
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     */
    public function initialize($atts)
    {
        $this->atts = $atts;
        $this->skin_options = (isset($this->atts['sk-options']) and isset($this->atts['sk-options'][$this->skin])) ? $this->atts['sk-options'][$this->skin] : array();
        
        // Date Formats
        $this->date_format_style11 = (isset($this->skin_options['date_format_style11']) and trim($this->skin_options['date_format_style11'])) ? $this->skin_options['date_format_style11'] : 'jS F Y';
        $this->date_format_style21 = (isset($this->skin_options['date_format_style21']) and trim($this->skin_options['date_format_style21'])) ? $this->skin_options['date_format_style21'] : 'jS F Y';
        
        $this->date_format_style31 = (isset($this->skin_options['date_format_style31']) and trim($this->skin_options['date_format_style31'])) ? $this->skin_options['date_format_style31'] : 'd';
        $this->date_format_style32 = (isset($this->skin_options['date_format_style32']) and trim($this->skin_options['date_format_style32'])) ? $this->skin_options['date_format_style32'] : 'F';
        $this->date_format_style33 = (isset($this->skin_options['date_format_style33']) and trim($this->skin_options['date_format_style33'])) ? $this->skin_options['date_format_style33'] : 'Y';
        
        // Background Color
        $this->bg_color = (isset($this->skin_options['bg_color']) and trim($this->skin_options['bg_color'])) ? $this->skin_options['bg_color'] : '#437df9';
        
        // Search Form Status
        $this->sf_status = false;
        
        $this->id = mt_rand(100, 999);
        
        // Set the ID
        if(!isset($this->atts['id'])) $this->atts['id'] = $this->id;
        
        // The style
        $this->style = isset($this->skin_options['style']) ? $this->skin_options['style'] : 'style1';
        
        // Override the style if the style forced by us in a widget etc
        if(isset($this->atts['style']) and trim($this->atts['style']) != '') $this->style = $this->atts['style'];
        
        // HTML class
        $this->html_class = '';
        if(isset($this->atts['html-class']) and trim($this->atts['html-class']) != '') $this->html_class = $this->atts['html-class'];
        
        // From Widget
        $this->widget = (isset($this->atts['widget']) and trim($this->atts['widget'])) ? true : false;
        
        // Init MEC
        $this->args['mec-skin'] = $this->skin;
        
        // Event ID
        $this->event_id = isset($this->skin_options['event_id']) ? $this->skin_options['event_id'] : '-1';
    }
    
    /**
     * Search and returns the filtered events
     * @author Webnus <info@webnus.biz>
     * @return list of objects
     */
    public function search()
    {
        $events = array();
        
        // Get next upcoming event ID
        if($this->event_id == '-1')
        {
            $event = $this->main->get_next_upcoming_event();
            $events[] = $event;
        }
        else
        {
            $rendered = $this->render->data($this->event_id, (isset($this->atts['content']) ? $this->atts['content'] : ''));

            $data = new stdClass();
            $data->ID = $this->event_id;
            $data->data = $rendered;
            $data->dates = $this->render->dates($this->event_id, $rendered, $this->maximum_dates);
            $data->date = isset($data->dates[0]) ? $data->dates[0] : array();

            $events[] = $data;
        }
        
        return $events;
    }
}