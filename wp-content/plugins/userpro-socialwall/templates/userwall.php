<?php
$i = (isset($i)) ? $i : '';
$layout = (isset($layout)) ? $layout : '';
?>
<div class="userpro userpro-users userpro-<?php echo $i; ?> userpro-<?php echo $layout; ?>" <?php userpro_args_to_data( $args ); ?>>

 <div class="socialwall_title"><?php

 	echo userpro_userwall_get_option( 'title' );
	$allow_userrole=array();

	$allow_userrole=explode(",",userpro_userwall_get_option('userpro-userwall_roles_can_poston_wall'));
	global $wp_roles;
        $current_user_role = '';
	foreach ( $wp_roles->role_names as $role => $name ) :

		if ( current_user_can( $role ) )
			$current_user_role= $role;

	endforeach;
		$userrole=userpro_userwall_get_option('userpro-userwall_roles_can_poston_wall');
 
 ?>
 </div>
		
</div>	
<?php

if(isset($args['posttype']))
	{
	$posttype=$args['posttype'];
	$postval='1';
	}
	else 	
	{ 	
	$posttype='';
	$postval='';	
	}
$url=home_url(add_query_arg( NULL, NULL ) );
 if (is_user_logged_in() &&  empty($userrole) && empty($args['role']) || (isset($current_user_role) && in_array($current_user_role,$allow_userrole)) || $args['role']==$current_user_role )
$postcount=userspost(get_current_user_id());
$limit_post=userpro_userwall_get_option('limit_number_of_post');

if($postcount<$limit_post || $limit_post =='-1'){

	if(is_user_logged_in() || userpro_userwall_get_option('nonloginusers')==1){
	?>
<div class="userwall-container">
<div class="textarea"><div contentEditable="true" data-text="<?php _e('Update Status...','userpro-userwall');?>" id="userpost" class="userpost"style="border: 1px solid #ccc;border-radius: 5px;width: 100%; height: 72px;overflow: hidden;"></div>

	<div class="smilies" id="smilies">
		<a href="#" title="" data-smiley="smiley1"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley1.png'?>" /></a>
		<a href="#" title="" data-smiley="smiley2"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley2.png'?>" /></a>
		<a href="#" title="" data-smiley="smiley3"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley3.png'?>" /></a>
		<a href="#" title="" data-smiley="smiley4"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley4.png'?>" /></a>
		<a href="#" title="" data-smiley="smiley5"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley5.png'?>" /></a>
		<a href="#" title="" data-smiley="smiley6"><img alt="" border="0" src="<?php echo UPS_PLUGIN_URL.'images/smiley/smiley6.png'?>" /></a>
	</div>
</div>
<div class="buttonpost"><button type="submit"  name="Post_Now" value="Post Now" title="<?php _e('Add to Wall','userpro-userwall'); ?>" onclick="user_post_data('userpost',<?php echo get_current_user_id();?>,'<?php echo $posttype;?>');"><i class="fa fa-send fa-fw"></i><b><?php _e('Add to Wall','userpro-userwall');?></b></button></div>
			
<div class="upload"><button class=userwall_upload  data-url="<?php echo $url;?>" data-posttype="<?php echo $posttype;?>" data-filetype = 'photo' type="submit"  name="upload_image" value="upload" data-allowed_extensions=jpg,png,jpeg,gif title="<?php _e('Upload','userpro-userwall'); ?>"><i class="fa fa-image fa-fw"></i> <b><?php _e('Add Photos','userpro-userwall');?></b></button> 
</div>
<img src="<?php echo UPS_PLUGIN_URL.'images/loader.GIF'?>" id="post-loader" style="float: right;"/>
</div>
<?php
	}
}

if(isset($post))
$array = get_user_meta($post->post_author,'_userpro_followers_ids');
if(isset($array['0']))
	{	
		foreach($array['0'] as  $key => $val)
		{	
		
		
			$user_ids[] = $key;


			
		}
	}

if(empty($user_ids))
$user_ids=get_current_user_id();
if(userpro_userwall_get_option('followerspost')=='0')
$user_ids='';

?>

<div id="userwalldata" data-pid="<?php echo get_the_ID();?>">
	<?php
$postargs = array(
	'posts_per_page'   => userpro_userwall_get_option( 'totalpost' ),
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => $posttype,
	'meta_value'       => $postval,
	'post_type'        => 'userpro_userwall',
	'author__in' => $user_ids,
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true ); 

$postslist = get_posts( $postargs );
$postids = array();
$postids=get_user_meta(get_current_user_id(),'userids',true );
$postids = array_values($postids);
foreach($postslist as $post)
{
    global $userpro;
        
    if(!is_array($postids)) $postids = array();

    if(in_array($post->ID,$postids))
    {
	continue;
    }
	include UPS_PLUGIN_DIR.'templates/single-post.php';
}

?>

</div>
<?php


global $wp_query,$wpdb;
$curauth = $wp_query->get_queried_object();
if(isset($args['role']))
$userrole=$args['role'];
$userids=get_users("role=$userrole");
$post_count =0;
if(!empty($userrole))
{  
	
	foreach ( $userids as $user) {
	$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'userpro_userwall' AND post_status = 'publish' AND post_author =$user->ID ");

	}
	$post_count+=$count;
}
else
{	
	
   $post_count=count($postslist);
	
}

if($post_count>=userpro_userwall_get_option( 'totalpost' ) )
{
?>
<div class="socialwall-load-more" id="socialwall-load-more"  data-url="<?php echo $url;?>"  data-post-type="<?php echo $posttype;?>" data-user-role="<?php isset($args['role'])?$args['role']:'';?>" data-max-pages="<?php  echo userpro_userwall_get_option( 'totalpost' ) ?>"><span><?php _e('Load More...','userpro-userwall')?><img src="<?php echo UPS_PLUGIN_URL.'images/loader.GIF'?>" id="loademore-loader" /></span></div>
<?php }?>
