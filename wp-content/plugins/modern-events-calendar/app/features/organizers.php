<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC organizers class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_organizers extends MEC_base
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
    }
    
    /**
     * Initialize organizers feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        $this->factory->action('init', array($this, 'register_taxonomy'), 25);
        $this->factory->action('mec_organizer_edit_form_fields', array($this, 'edit_form'));
        $this->factory->action('mec_organizer_add_form_fields', array($this, 'add_form'));
        $this->factory->action('edited_mec_organizer', array($this, 'save_metadata'));
        $this->factory->action('created_mec_organizer', array($this, 'save_metadata'));
        
        $this->factory->action('mec_metabox_details', array($this, 'meta_box_organizer'), 40);
        
        $this->factory->filter('manage_edit-mec_organizer_columns', array($this, 'filter_columns'));
        $this->factory->filter('manage_mec_organizer_custom_column', array($this, 'filter_columns_content'), 10, 3);
        
        $this->factory->action('save_post', array($this, 'save_event'), 2);
    }
    
    /**
     * Registers organizer taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function register_taxonomy()
    {
        register_taxonomy(
            'mec_organizer',
            $this->main->get_main_post_type(),
            array(
                'label'=>__('Organizers', 'mec'),
                'labels'=>array(
                    'name'=>__('Organizers', 'mec'),
                    'singular_name'=>__('Organizer', 'mec'),
                    'all_items'=>__('All Organizers', 'mec'),
                    'edit_item'=>__('Edit Organizer', 'mec'),
                    'view_item'=>__('View Organizer', 'mec'),
                    'update_item'=>__('Update Organizer', 'mec'),
                    'add_new_item'=>__('Add New Organizer', 'mec'),
                    'new_item_name'=>__('New Organizer Name', 'mec'),
                    'popular_items'=>__('Popular Organizers', 'mec'),
                    'search_items'=>__('Search Organizers', 'mec'),
                ),
                'rewrite'=>array('slug'=>'events-organizer'),
                'public'=>false,
                'show_ui'=>true,
                'hierarchical'=>false,
            )
        );
        
        register_taxonomy_for_object_type('mec_organizer', $this->main->get_main_post_type());
    }
    
    /**
     * Show edit form of organizer taxonomy
     * @author Webnus <info@webnus.biz>
     * @param object $term
     */
    public function edit_form($term)
    {
        $tel = get_metadata('term', $term->term_id, 'tel', true);
        $email = get_metadata('term', $term->term_id, 'email', true);
        $url = get_metadata('term', $term->term_id, 'url', true);
        $thumbnail = get_metadata('term', $term->term_id, 'thumbnail', true);
    ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_tel"><?php _e('Tel', 'mec'); ?></label>
            </th>
            <td>
                <input type="text" placeholder="<?php esc_attr_e('Insert organizer phone number.', 'mec'); ?>" name="tel" id="mec_tel" value="<?php echo $tel; ?>" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_email"><?php _e('Email', 'mec'); ?></label>
            </th>
            <td>
                <input type="text"  placeholder="<?php esc_attr_e('Insert organizer email address.', 'mec'); ?>" name="email" id="mec_email" value="<?php echo $email; ?>" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_url"><?php _e('Link to organizer page', 'mec'); ?></label>
            </th>
            <td>
                <input type="text" placeholder="<?php esc_attr_e('Use this field to link organizer to other user profile pages', 'mec'); ?>" name="url" id="mec_url" value="<?php echo $url; ?>" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_thumbnail_button"><?php _e('Thumbnail', 'mec'); ?></label>
            </th>
            <td>
                <div id="mec_thumbnail_img"><?php if(trim($thumbnail) != '') echo '<img src="'.$thumbnail.'" />'; ?></div>
                <input type="hidden" name="thumbnail" id="mec_thumbnail" value="<?php echo $thumbnail; ?>" />
                <button class="mec_upload_image_button button" id="mec_thumbnail_button"><?php echo __('Upload/Add image', 'mec'); ?></button>
                <button class="mec_remove_image_button button <?php echo (!trim($thumbnail) ? 'mec-util-hidden' : ''); ?>"><?php echo __('Remove image', 'mec'); ?></button>
            </td>
        </tr>
    <?php
    }
    
    /**
     * Show add form of organizer taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function add_form()
    {
    ?>
        <div class="form-field">
            <label for="mec_tel"><?php _e('Tel', 'mec'); ?></label>
            <input type="text" name="tel" placeholder="<?php esc_attr_e('Insert organizer phone number.', 'mec'); ?>" id="mec_tel" value="" />
        </div>
        <div class="form-field">
            <label for="mec_email"><?php _e('Email', 'mec'); ?></label>
            <input type="text" name="email" placeholder="<?php esc_attr_e('Insert organizer email address.', 'mec'); ?>" id="mec_email" value="" />
        </div>
        <div class="form-field">
            <label for="mec_url"><?php _e('Link to organizer page', 'mec'); ?></label>
            <input type="text" name="url" placeholder="<?php esc_attr_e('Use this field to link organizer to other user profile pages', 'mec'); ?>" id="mec_url" value="" />
        </div>
        <div class="form-field">
            <label for="mec_thumbnail_button"><?php _e('Thumbnail', 'mec'); ?></label>
            <div id="mec_thumbnail_img"></div>
            <input type="hidden" name="thumbnail" id="mec_thumbnail" value="" />
            <button class="mec_upload_image_button button" id="mec_thumbnail_button"><?php echo __('Upload/Add image', 'mec'); ?></button>
            <button class="mec_remove_image_button button mec-util-hidden"><?php echo __('Remove image', 'mec'); ?></button>
        </div>
    <?php
    }
    
    /**
     * Save meta data of organizer taxonomy
     * @author Webnus <info@webnus.biz>
     * @param int $term_id
     */
    public function save_metadata($term_id)
    {
        $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        $thumbnail = isset($_POST['thumbnail']) ? $_POST['thumbnail'] : '';
        
        update_term_meta($term_id, 'tel', $tel);
        update_term_meta($term_id, 'email', $email);
        update_term_meta($term_id, 'url', $url);
        update_term_meta($term_id, 'thumbnail', $thumbnail);
    }
    
    /**
     * Filter columns of organizer taxonomy
     * @author Webnus <info@webnus.biz>
     * @param array $columns
     * @return array
     */
    public function filter_columns($columns)
    {
        unset($columns['name']);
        unset($columns['slug']);
        unset($columns['description']);
        unset($columns['posts']);
        
        $columns['id'] = __('ID', 'mec');
        $columns['name'] = __('Organizer', 'mec');
        $columns['contact'] = __('Contact info', 'mec');
        $columns['posts'] = __('Count', 'mec');
        $columns['slug'] = __('Slug', 'mec');

        return $columns;
    }
    
    /**
     * Filter content of organizer taxonomy columns
     * @author Webnus <info@webnus.biz>
     * @param string $content
     * @param string $column_name
     * @param int $term_id
     * @return string
     */
    public function filter_columns_content($content, $column_name, $term_id)
    {
        switch($column_name)
        {
            case 'id':
                
                $content = $term_id;
                break;

            case 'contact':
                
                $tel = get_metadata('term', $term_id, 'tel', true);
                $email = get_metadata('term', $term_id, 'email', true);
                
                $content = $email.(trim($tel) ? '<br />'.$tel : '');
                break;

            default:
                break;
        }

        return $content;
    }
    
    /**
     * Show organizer meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_organizer($post)
    {
        $organizers = get_terms('mec_organizer', array('orderby'=>'name', 'hide_empty'=>'0'));
        $organizer_id = get_post_meta($post->ID, 'mec_organizer_id', true);
    ?>
        <div class="mec-meta-box-fields" id="mec-organizer">
            <h4><?php _e('Event Organizer', 'mec'); ?></h4>
			<div class="mec-form-row">
				<select name="mec[organizer_id]" id="mec_organizer_id">
                    <option value="1"><?php _e('Hide organizer', 'mec'); ?></option>
					<option value="0"><?php _e('Insert a new organizer', 'mec'); ?></option>
					<?php foreach($organizers as $organizer): ?>
					<option <?php if($organizer_id == $organizer->term_id) echo 'selected="selected"'; ?> value="<?php echo $organizer->term_id; ?>"><?php echo $organizer->name; ?></option>
					<?php endforeach; ?>
				</select>
				<a class="mec-tooltip" title="<?php esc_attr_e('Choose one of saved organizers or insert new one below.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
			</div>
			<div id="mec_organizer_new_container">
				<div class="mec-form-row">
					<input type="text" name="mec[organizer][name]" id="mec_organizer_name" value="" placeholder="<?php _e('Organizer Name', 'mec'); ?>" />
					<p class="description"><?php _e('eg. John Smith', 'mec'); ?></p>
				</div>
                <div class="mec-form-row">
                    <input type="text" name="mec[organizer][tel]" id="mec_organizer_contact" value="" placeholder="<?php esc_attr_e('Insert organizer phone number.', 'mec'); ?>" />
                    <p class="description"><?php _e('eg. +1 (234) 5678', 'mec'); ?></p>
                </div>
                <div class="mec-form-row">
                    <input type="text" name="mec[organizer][email]" id="mec_organizer_contact" value="" placeholder="<?php esc_attr_e('Insert organizer email address.', 'mec'); ?>" />
                    <p class="description"><?php _e('eg. john@smith.com', 'mec'); ?></p>
                </div>
				<div class="mec-form-row">
					<input type="text" name="mec[organizer][url]" id="mec_organizer_url" value="" placeholder="<?php _e('Link to organizer page', 'mec'); ?>" />
					<p class="description"><?php _e('eg. http://yoursite.com/john-smith/', 'mec'); ?></p>
				</div>
				<div class="mec-form-row mec-thumbnail-row">
					<div id="mec_organizer_thumbnail_img"></div>
					<input type="hidden" name="mec[organizer][thumbnail]" id="mec_organizer_thumbnail" value="" />
					<button class="mec_organizer_upload_image_button button" id="mec_organizer_thumbnail_button"><?php echo __('Choose image', 'mec'); ?></button>
					<button class="mec_organizer_remove_image_button button mec-util-hidden"><?php echo __('Remove image', 'mec'); ?></button>
				</div>
			</div>
		</div>
    <?php
    }
    
    /**
     * Save event organizer data
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @return boolean
     */
    public function save_event($post_id)
    {
        // Check if our nonce is set.
        if(!isset($_POST['mec_event_nonce'])) return;

        // Verify that the nonce is valid.
        if(!wp_verify_nonce($_POST['mec_event_nonce'], 'mec_event_data')) return;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return;

        // Get Modern Events Calendar Data
        $_mec = isset($_POST['mec']) ? $_POST['mec'] : array();
        
        // Selected a saved organizer
        if(isset($_mec['organizer_id']) and $_mec['organizer_id'])
        {
            // Set term to the post
            wp_set_object_terms($post_id, (int) $_mec['organizer_id'], 'mec_organizer');
            
            return true;
        }
        
        $name = (isset($_mec['organizer']['name']) and trim($_mec['organizer']['name'])) ? $_mec['organizer']['name'] : 'Organizer Name';
        
        $term = get_term_by('name', $name, 'mec_organizer');
        
        // Term already exists
        if(is_object($term) and isset($term->term_id))
        {
            // Set term to the post
            wp_set_object_terms($post_id, (int) $term->term_id, 'mec_organizer');
            
            return true;
        }
        
        $term = wp_insert_term($name, 'mec_organizer');
        
        // An error ocurred
        if(is_wp_error($term))
        {
            #TODO show a message to user
            return false;
        }
        
        $organizer_id = $term['term_id'];
        
        if(!$organizer_id) return false;
        
        // Set Organizer ID to the parameters
        $_POST['mec']['organizer_id'] = $organizer_id;
        
        // Set term to the post
        wp_set_object_terms($post_id, (int) $organizer_id, 'mec_organizer');
            
        $tel = (isset($_mec['organizer']['tel']) and trim($_mec['organizer']['tel'])) ? $_mec['organizer']['tel'] : '';
        $email = (isset($_mec['organizer']['email']) and trim($_mec['organizer']['email'])) ? $_mec['organizer']['email'] : '';
        $url = (isset($_mec['organizer']['url']) and trim($_mec['organizer']['url'])) ? $_mec['organizer']['url'] : '';
        $thumbnail = (isset($_mec['organizer']['thumbnail']) and trim($_mec['organizer']['thumbnail'])) ? $_mec['organizer']['thumbnail'] : '';
        
        update_term_meta($organizer_id, 'tel', $tel);
        update_term_meta($organizer_id, 'email', $email);
        update_term_meta($organizer_id, 'url', $url);
        update_term_meta($organizer_id, 'thumbnail', $thumbnail);
    }
}