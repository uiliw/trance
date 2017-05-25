<div class="profileDashboard dashboardRight" id = "dashboard-my-posts">
    <?php
        global $_POST;
        global $userpro;
        if ( is_user_logged_in() ):
            global $current_user;
            wp_get_current_user();
            $author_query = array('posts_per_page' => '-1','author' => $current_user->ID,'post_status' => array( 'pending', 'draft','publish'));
            $author_posts =  get_posts($author_query);
            if(!empty($author_posts)){
               foreach($author_posts as $single_post){
                   include UPDB_PATH.'templates/edit-my-post.php';
               }
            }
 
        endif;
 ?>
<div class='updb-new-post-add'>
<input type="button" class="updb-add-new-post" value="Add New" >
</div>
</div>
