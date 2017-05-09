<?php
function rev_addons_filter( $addons ) {
   
   $addons['revslider-maintenance-addon'] = (object) array(
   'slug'            => 'revslider-maintenance-addon',
   'version_from'    => '5.2.0', //at which version should it be shown
   'version_to'    => '9.9.9', //if higher than here, it will be removed
   'title'            => 'Coming Soon & Maintenance',
   'line_1'        => 'Simple Coming Soon & Maintenance Page',
   'line_2'        => 'Informative and awesome!',
   'available'        => '1.0.0',
   'background'    => '',
   'button'        => 'Configure'
   );

   return $addons;

}

add_filter('rev_addons_filter', 'rev_addons_filter');
?>