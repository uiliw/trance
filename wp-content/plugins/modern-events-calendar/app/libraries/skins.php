<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC skins class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_skins extends MEC_base
{
    /**
     * Default skin
     * @var string
     */
    public $skin = 'list';
    
    /**
     * @var array
     */
    public $atts = array();
    
    /**
     * @var array
     */
    public $args = array();
    
    /**
     * @var int
     */
    public $maximum_dates = 6;
    
    /**
     * Maximum days for loop
     * @var int
     */
    public $max_days_loop = 366;
    
	/**
     * Offset for don't load duplicated events in list/grid views on load more action
     * @var int
     */
	public $offset = 0;
	
	/**
     * Offset for next load more action
     * @var int
     */
	public $next_offset = 0;
	
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // MEC factory library
        $this->factory = $this->getFactory();
        
        // MEC main library
        $this->main = $this->getMain();
        
        // MEC file library
        $this->file = $this->getFile();
        
        // MEC db library
        $this->db = $this->getDB();
        
        // MEC render library
        $this->render = $this->getRender();
        
        // MEC request library
        $this->request = $this->getRequest();
        
        // Found Events
        $this->found = 0;
        
        // How to show multiple days events
        $this->multiple_days_method = $this->main->get_multiple_days_method();
    }
    
    /**
     * Registers skin actions into WordPress hooks
     * @author Webnus <info@webnus.biz>
     */
    public function actions()
    {
    }
    
    /**
     * Loads all skins
     * @author Webnus <info@webnus.biz>
     */
    public function load()
    {
        // MEC add filters
        $this->factory->filter('posts_join', array($this, 'join'), 10, 2);
        $this->factory->filter('posts_where', array($this, 'where'), 10, 2);
        
        $skins = $this->main->get_skins();
        foreach($skins as $skin=>$skin_name)
        {
            $path = MEC::import('app.skins.'.$skin, true, true);
            $skin_path = apply_filters('mec_skin_path', $skin);

            if($skin_path != $skin and $this->file->exists($skin_path)) $path = $skin_path;
            if(!$this->file->exists($path)) continue;

            include_once $path;

            $skin_class_name = 'MEC_skin_'.$skin;

            // Create Skin Object Class
            $SKO = new $skin_class_name();

            // init the actions
            $SKO->actions();
        }
    }
    
    /**
     * Get path of one skin file
     * @author Webnus <info@webnus.biz>
     * @param string $file
     * @return string
     */
    public function get_path($file = 'tpl')
    {
        return MEC::import('app.skins.'.$this->skin.'.'.$file, true, true);
    }
    
    /**
     * Returns path of skin tpl
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function get_tpl_path()
    {
        $path = $this->get_path('tpl');
        
        // Apply filters
        $filtered_path = apply_filters('mec_get_skin_tpl_path', $this->skin);
        if($filtered_path != $this->skin and $this->file->exists($filtered_path)) $path = $filtered_path;
        
        return $path;
    }
    
    /**
     * Returns path of skin render file
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function get_render_path()
    {
        $path = $this->get_path('render');
        
        // Apply filters
        $filtered_path = apply_filters('mec_get_skin_render_path', $this->skin);
        if($filtered_path != $this->skin and $this->file->exists($filtered_path)) $path = $filtered_path;
        
        return $path;
    }
    
    /**
     * Returns calendar file path of calendar views
     * @author Webnus <info@webnus.biz>
     * @param string $style
     * @return string
     */
    public function get_calendar_path($style = 'calendar')
    {
        $path = $this->get_path($style);
        
        // Apply filters
        $filtered_path = apply_filters('mec_get_skin_calendar_path', $this->skin);
        if($filtered_path != $this->skin and $this->file->exists($filtered_path)) $path = $filtered_path;
        
        return $path;
    }
    
    /**
     * Generates skin output
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function output()
    {
        ob_start();
        include $this->get_tpl_path();
        return ob_get_clean();
    }
    
    /**
     * Returns keyword query for adding to WP_Query
     * @author Webnus <info@webnus.biz>
     * @return null|string
     */
    public function keyword_query()
    {
        // Add keyword to filters
        if(isset($this->atts['s']) and trim($this->atts['s']) != '') return $this->atts['s'];
        else return NULL;
    }
    
    /**
     * Returns taxonomy query for adding to WP_Query
     * @author Webnus <info@webnus.biz>
     * @return array
     */
    public function tax_query()
    {
        $tax_query = array('relation'=>'AND');
        
        // Add event label to filter
        if(isset($this->atts['label']) and trim($this->atts['label'], ', ') != '')
        {
            $tax_query[] = array(
                'taxonomy'=>'mec_label',
                'field'=>'term_id',
                'terms'=>explode(',', trim($this->atts['label'], ', '))
            );
        }
        
        // Add event category to filter
        if(isset($this->atts['category']) and trim($this->atts['category'], ', ') != '')
        {
            $tax_query[] = array(
                'taxonomy'=>'mec_category',
                'field'=>'term_id',
                'terms'=>explode(',', trim($this->atts['category'], ', '))
            );
        }
        
        // Add event location to filter
        if(isset($this->atts['location']) and trim($this->atts['location'], ', ') != '')
        {
            $tax_query[] = array(
                'taxonomy'=>'mec_location',
                'field'=>'term_id',
                'terms'=>explode(',', trim($this->atts['location'], ', '))
            );
        }
        
        // Add event organizer to filter
        if(isset($this->atts['organizer']) and trim($this->atts['organizer'], ', ') != '')
        {
            $tax_query[] = array(
                'taxonomy'=>'mec_organizer',
                'field'=>'term_id',
                'terms'=>explode(',', trim($this->atts['organizer'], ', '))
            );
        }
        
        return $tax_query;
    }
    
    /**
     * Returns meta query for adding to WP_Query
     * @author Webnus <info@webnus.biz>
     * @return array
     */
    public function meta_query()
    {
        $meta_query = array();
        $meta_query['relation'] = 'AND';
        
        return $meta_query;
    }
    
    /**
     * Returns tag query for adding to WP_Query
     * @author Webnus <info@webnus.biz>
     * @return array
     */
    public function tag_query()
    {
        $tag = '';
        
        // Add event tags to filter
        if(isset($this->atts['tag']) and trim($this->atts['tag'], ', ') != '')
        {
            $tag = $this->atts['tag'];
        }
        
        return $tag;
    }
    
    /**
     * Returns author query for adding to WP_Query
     * @author Webnus <info@webnus.biz>
     * @return array
     */
    public function author_query()
    {
        $author = '';
        
        // Add event authors to filter
        if(isset($this->atts['author']) and trim($this->atts['author'], ', ') != '')
        {
            $author = $this->atts['author'];
        }
        
        return $author;
    }
    
    /**
     * Set the current day for filtering events in WP_Query
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function setToday($today = NULL)
    {
        if(is_null($today)) $today = date('Y-m-d');
        
        $this->args['mec-today'] = $today;
        $this->args['mec-now'] = strtotime($this->args['mec-today']);
        
        $this->args['mec-year'] = date('Y', $this->args['mec-now']);
        $this->args['mec-month'] = date('m', $this->args['mec-now']);
        $this->args['mec-day'] = date('d', $this->args['mec-now']);
        
        $this->args['mec-week'] = (int) ((date('d', $this->args['mec-now']) - 1) / 7) + 1;
        $this->args['mec-weekday'] = date('N', $this->args['mec-now']);
    }
    
    /**
     * Join MEC table with WP_Query for filtering the events
     * @author Webnus <info@webnus.biz>
     * @param string $join
     * @param object $wp_query
     * @return string
     */
    public function join($join, &$wp_query)
    {
        if(is_string($wp_query->query_vars['post_type']) and $wp_query->query_vars['post_type'] == $this->main->get_main_post_type() and $wp_query->get('mec-init', false))
        {
            $join .= $this->db->_prefix(" LEFT JOIN `#__mec_events` AS mece ON #__posts.ID = mece.post_id ");
        }

        return $join;
    }
    
    /**
     * Adding MEC filter query to WP_Query
     * @author Webnus <info@webnus.biz>
     * @param string $where
     * @param object $wp_query
     * @return string
     */
    public function where($where, &$wp_query)
    {
        if(is_string($wp_query->query_vars['post_type']) and $wp_query->query_vars['post_type'] == $this->main->get_main_post_type() and $wp_query->get('mec-init', false))
        {
            // Start and End date
            $date_query = "`start`<='".$wp_query->get('mec-today')."' AND (`end`='0000-00-00' OR `end`>='".$wp_query->get('mec-today')."')";
            
            // No recuring events
            if($this->multiple_days_method == 'first_day' or ($this->multiple_days_method == 'first_day_listgrid' and in_array($wp_query->get('mec-skin', ''), array('list', 'grid')))) $rec_no = "`repeat`='0' AND `start`='".$wp_query->get('mec-today')."' AND (`end`='0000-00-00' OR `end`>='".$wp_query->get('mec-today')."')";
            else $rec_no = "`repeat`='0' AND ".$date_query;
            
            // Normal Recuring events
            $rec_normal = "`repeat`='1' AND DATEDIFF('".$wp_query->get('mec-today')."', start) % rinterval=0 AND ".$date_query;
            
            // Complex Recuring events
            $rec_complex = "`repeat`='1' AND (`year`='".$wp_query->get('mec-year')."' OR `year`='*') AND
                    (`month` LIKE '%,".$wp_query->get('mec-month').",%' OR `month`='*') AND
                    (`day` LIKE '".(($this->multiple_days_method == 'all_days' or ($this->multiple_days_method == 'first_day_listgrid' and !in_array($wp_query->get('mec-skin', ''), array('list', 'grid')))) ? '%' : '').",".$wp_query->get('mec-day').",%' OR `day`='*') AND
                    (`week` LIKE '%,".$wp_query->get('mec-week').",%' OR `week`='*') AND
                    (`weekday` LIKE '%,".$wp_query->get('mec-weekday').",%' OR `weekday`='*') AND ".$date_query;
            
            // Weekday Recuring events
            $rec_weekdays = "`repeat`='1' AND `weekdays` LIKE '%,".$wp_query->get('mec-weekday').",%' AND ".$date_query;
            
            // Days (In)
            $rec_days_in = "`days` LIKE '%".$wp_query->get('mec-today')."%'";
            
            // Days (Not In)
            $rec_days_not_in = "`not_in_days` NOT LIKE '%".$wp_query->get('mec-today')."%'";
            
            // Hide past events
            $time_query = '';
            
            if(!$wp_query->get('mec-past-events') and $wp_query->get('mec-today') == date('Y-m-d'))
            {
                $hour = date('G');
                $minute = date('i');
                
                $seconds = $this->main->time_to_seconds($hour, $minute);
                
                // Normal Recuring events
                $time_query = "`time_start`!='0' AND `time_start`>='$seconds'";
            }
            
            $where .= $this->db->_prefix(" AND (($rec_no) OR ($rec_normal) OR ($rec_complex) OR ($rec_weekdays) OR ($rec_days_in)) AND $rec_days_not_in".(trim($time_query) ? ' AND '.$time_query : ''));
        }
        
        return $where;
    }
    
    /**
     * Perform the search
     * @author Webnus <info@webnus.biz>
     * @return array of objects \stdClass
     */
    public function search()
    {
        $i = 0;
        $found = 0;
        $events = array();
        
        while($i < $this->max_days_loop and $found < $this->limit)
        {
            $today = date('Y-m-d', strtotime('+'.$i.' Days', strtotime($this->start_date)));
            $this->setToday($today);
            
            // Check Finish Date
            if(isset($this->maximum_date) and strtotime($today) > strtotime($this->maximum_date)) break;
            
            // Extending the end date
            $this->end_date = $today;
            
            // Limit
            $this->args['posts_per_page'] = 1000;
			
			// Continue to load rest of events in the first date
            if($i === 0) $this->args['offset'] = $this->offset;
			// Load all events in the rest of dates
			else $this->args['offset'] = 0;
			
            // The Query
            $query = new WP_Query($this->args);
            
            if($query->have_posts())
            {
                // The Loop
                while($query->have_posts())
                {
                    $query->the_post();
                    
                    if(!isset($events[$today])) $events[$today] = array();
                    
                    $rendered = $this->render->data(get_the_ID());
                    
                    $data = new stdClass();
                    $data->ID = get_the_ID();
                    $data->data = $rendered;
                    
                    $data->date = array
                    (
                        'start'=>array('date'=>$today),
                        'end'=>array('date'=>$this->main->get_end_date($today, $rendered))
                    );
                    
                    $events[$today][] = $data;
                    $found++;
					
					if($found >= $this->limit)
					{
						// Next Offset
						$this->next_offset = ($query->post_count-($query->current_post+1)) > 0 ? ($query->post_count-($query->current_post+1)) : 0;
						
						// Move to next day
						if($this->next_offset === 0) $this->end_date = date('Y-m-d', strtotime('+1 Days', strtotime($today)));
						
						break;
					}
                }
            }
            
            // Restore original Post Data
            wp_reset_postdata();

            $i++;
        }
        
        // Set found events
        $this->found = $found;
        
        return $events;
    }
    
    /**
     * Run the search command
     * @author Webnus <info@webnus.biz>
     * @return array of objects
     */
    public function fetch()
    {
        // Events! :)
        return $this->events = $this->search();
    }
    
    /**
     * Draw Monthly Calendar
     * @author Webnus <info@webnus.biz>
     * @param string|int $month
     * @param string|int $year
     * @param array $events
     * @return string
     */
    public function draw_monthly_calendar($year, $month, $events = array(), $style = 'calendar')
    {
        $calendar_path = $this->get_calendar_path($style);
        
        // Generate Month
        ob_start();
        include $calendar_path;
        return ob_get_clean();
    }
    
    /**
     * Generates Search Form
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function sf_search_form()
    {
        // If no fields specified
        if(!count($this->sf_options)) return '';
        
        $fields = '';
        $first_row = 'not-started';
        
        foreach($this->sf_options as $field=>$options)
        {
            $type = isset($options['type']) ? $options['type'] : '';
            
            // Field is disabled
            if(!trim($type)) continue;
            
            if(in_array($field, array('category', 'location', 'organizer', 'label')) and $first_row == 'not-started')
            {
                $first_row = 'started';
                $fields .= '<div class="mec-dropdown-wrap">';
            }
            
            if(!in_array($field, array('category', 'location', 'organizer', 'label')) and $first_row == 'started')
            {
                $first_row = 'finished';
                $fields .= '</div>';
            }
            
            $fields .= $this->sf_search_field($field, $options);
        }
        
        $form = '';
        if(trim($fields)) $form .= '<div id="mec_search_form_'.$this->id.'" class="mec-search-form mec-totalcal-box">'.$fields.'</div>';
        
        return $form;
    }
    
    /**
     * Generate a certain search field
     * @author Webnus <info@webnus.biz>
     * @param string $field
     * @param array $options
     * @return string
     */
    public function sf_search_field($field, $options)
    {
        $type = isset($options['type']) ? $options['type'] : '';
        
        // Field is disabled
        if(!trim($type)) return '';
        
        $output = '';

        if($field == 'category')
        {
            if($type == 'dropdown')
            {
                $output .= '<div class="mec-dropdown-search">
                    <i class="mec-sl-folder"></i>';
                
                $output .= wp_dropdown_categories(array
                (
                    'echo'=>false,
                    'taxonomy'=>'mec_category',
                    'name'=>'',
                    'id'=>'mec_sf_category_'.$this->id,
                    'hierarchical'=>true,
                    'show_option_none'=>__('Category', 'mec'),
                    'option_none_value'=>'',
                    'selected'=>(isset($this->atts['category']) ? $this->atts['category'] : ''),
                    'orderby'=>'name',
                    'order'=>'ASC',
                    'show_count'=>0,
                ));
                
                $output .= '</div>';
            }
        }
        elseif($field == 'location')
        {
            if($type == 'dropdown')
            {
                $output .= '<div class="mec-dropdown-search">
                    <i class="mec-sl-location-pin"></i>';
                
                $output .= wp_dropdown_categories(array
                (
                    'echo'=>false,
                    'taxonomy'=>'mec_location',
                    'name'=>'',
                    'id'=>'mec_sf_location_'.$this->id,
                    'hierarchical'=>true,
                    'show_option_none'=>__('Location', 'mec'),
                    'option_none_value'=>'',
                    'selected'=>(isset($this->atts['location']) ? $this->atts['location'] : ''),
                    'orderby'=>'name',
                    'order'=>'ASC',
                    'show_count'=>0,
                ));
                
                $output .= '</div>';
            }
        }
        elseif($field == 'organizer')
        {
            if($type == 'dropdown')
            {
                $output .= '<div class="mec-dropdown-search">
                    <i class="mec-sl-user"></i>';
                
                $output .= wp_dropdown_categories(array
                (
                    'echo'=>false,
                    'taxonomy'=>'mec_organizer',
                    'name'=>'',
                    'id'=>'mec_sf_organizer_'.$this->id,
                    'hierarchical'=>true,
                    'show_option_none'=>__('Organizer', 'mec'),
                    'option_none_value'=>'',
                    'selected'=>(isset($this->atts['organizer']) ? $this->atts['organizer'] : ''),
                    'orderby'=>'name',
                    'order'=>'ASC',
                    'show_count'=>0,
                ));
                
                $output .= '</div>';
            }
        }
        elseif($field == 'label')
        {
            if($type == 'dropdown')
            {
                $output .= '<div class="mec-dropdown-search">
                    <i class="mec-sl-tag"></i>';
                
                $output .= wp_dropdown_categories(array
                (
                    'echo'=>false,
                    'taxonomy'=>'mec_label',
                    'name'=>'',
                    'id'=>'mec_sf_label_'.$this->id,
                    'hierarchical'=>true,
                    'show_option_none'=>__('Label', 'mec'),
                    'option_none_value'=>'',
                    'selected'=>(isset($this->atts['label']) ? $this->atts['label'] : ''),
                    'orderby'=>'name',
                    'order'=>'ASC',
                    'show_count'=>0,
                ));
                
                $output .= '</div>';
            }
        }
        elseif($field == 'month_filter')
        {
            if($type == 'dropdown')
            {
                $time = isset($this->start_date) ? strtotime($this->start_date) : '';

                $output .= '<div class="mec-date-search">
                    <i class="mec-sl-calendar"></i>
                    <select id="mec_sf_month_'.$this->id.'">';

                $output .= in_array($this->skin, array('list', 'grid')) ? '<option id="mec_sf_skip_date_'.$this->id.'" value="ignor_date">'.__('Ignore month and years', 'mec').'</option>' : '';

                $m = date('m', $time);
                $Y = date('Y', $time);

                for($i = 1; $i <= 12; $i++) $output .= '<option value="'.($i < 10 ? '0'.$i : $i).'" '.($i == $m ? 'selected="selected"' : '').'>'.date_i18n('F', mktime(0, 0, 0, $i, 10)).'</option>';
                $output .= '</select><select id="mec_sf_year_'.$this->id.'">';

                for($i = -2; $i <= 3; $i++)
                {
                    $year = date('Y')+$i;
                    $output .= '<option value="'.$year.'" '.($year == $Y ? 'selected="selected"' : '').'>'.$year.'</option>';
                }

                $output .= '</select></div>';
            }
        }
        elseif($field == 'text_search')
        {
            if($type == 'text_input')
            {
                $output .= '<div class="mec-text-input-search">
                    <i class="mec-sl-magnifier"></i>
                    <input type="search" value="'.(isset($this->atts['s']) ? $this->atts['s'] : '').'" id="mec_sf_s_'.$this->id.'" />
                </div>';
            }
        }
        
        return $output;
    }
    
    public function sf_apply($atts, $sf = array(), $apply_sf_date = 1)
    {
        // Return normal atts if sf is empty
        if(!count($sf)) return $atts;
        
        // Apply Text Search Query
        if(isset($sf['s'])) $atts['s'] = $sf['s'];
        
        // Apply Category Query
        if(isset($sf['category'])) $atts['category'] = $sf['category'];
        
        // Apply Location Query
        if(isset($sf['location'])) $atts['location'] = $sf['location'];
        
        // Apply Organizer Query
        if(isset($sf['organizer'])) $atts['organizer'] = $sf['organizer'];
        
        // Apply Label Query
        if(isset($sf['label'])) $atts['label'] = $sf['label'];
        
        // Apply SF Date or Not
        if($apply_sf_date == 1)
        {
            // Apply Month of Month Filter
            if(isset($sf['month']) and trim($sf['month'])) $this->request->setVar('mec_month', $sf['month']);

            // Apply Year of Month Filter
            if(isset($sf['year']) and trim($sf['year'])) $this->request->setVar('mec_year', $sf['year']);

            // Apply to Start Date
            if(isset($sf['month']) and trim($sf['month']) and isset($sf['year']) and trim($sf['year']))
            {
                $start_date = $sf['year'].'-'.$sf['month'].'-'.(isset($sf['day']) ? $sf['day'] : '01');
                $this->request->setVar('mec_start_date', $start_date);

                $skins = $this->main->get_skins();
                foreach($skins as $skin=>$label)
                {
                    $atts['sk-options'][$skin]['start_date_type'] = 'date';
                    $atts['sk-options'][$skin]['start_date'] = $start_date;
                }
            }
        }
        
        return $atts;
    }
}