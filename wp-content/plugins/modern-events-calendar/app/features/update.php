<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC update class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_update extends MEC_base
{
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();
        
        // Import MEC Main
        $this->main = $this->getMain();
        
        // Import MEC DB
        $this->db = $this->getDB();
    }
    
    /**
     * Initialize update feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        $version = get_option('mec_version', '1.0.0');
        
        if(version_compare($version, '1.0.3', '<')) $this->version103();
        if(version_compare($version, '1.3.0', '<')) $this->version130();
        if(version_compare($version, '1.5.0', '<')) $this->version150();
        if(version_compare($version, '1.6.0', '<')) $this->version160();
    }
    
    /**
     * Update database to version 1.0.3
     * @author Webnus <info@webnus.biz>
     */
    public function version103()
    {
        // Get current MEC options
        $current = get_option('mec_options', array());
        if(is_string($current) and trim($current) == '') $current = array();
        
        // Merge new options with previous options
        $current['notifications']['new_event'] = array
        (
            'status'=>'1',
            'subject'=>'A new event is added.',
            'recipients'=>'',
            'content'=>"Hello,

            A new event just added. The event title is %%event_title%% and it's status is %%event_status%%
            The new event may need to be published. Please use this link for managing your website events: %%admin_link%%

            Regards,
            %%blog_name%%"
        );
        
        // Update it only if options already exists.
        if(get_option('mec_options') !== false)
        {
            // Save new options
            update_option('mec_options', $current);
            update_option('mec_version', '1.0.3');
        }
    }
    
    /**
     * Update database to version 1.3.0
     * @author Webnus <info@webnus.biz>
     */
    public function version130()
    {
        $this->db->q("ALTER TABLE `#__mec_events` ADD `days` TEXT NULL DEFAULT NULL, ADD `time_start` INT(10) NOT NULL DEFAULT '0', ADD `time_end` INT(10) NOT NULL DEFAULT '0'");
        
        // Save new version
        update_option('mec_version', '1.3.0');
    }
    
    /**
     * Update database to version 1.5.0
     * @author Webnus <info@webnus.biz>
     */
    public function version150()
    {
        $this->db->q("ALTER TABLE `#__mec_events` ADD `not_in_days` TEXT NOT NULL DEFAULT '' AFTER `days`");
        $this->db->q("ALTER TABLE `#__mec_events` CHANGE `days` `days` TEXT NOT NULL DEFAULT ''");
        
        // Save new version
        update_option('mec_version', '1.5.0');
    }
    
    /**
     * Update database to version 1.6.0
     * @author Webnus <info@webnus.biz>
     */
    public function version160()
    {
        // Save new version
        update_option('mec_version', '1.6.0');
    }
}