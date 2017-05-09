<form method="post" action="">

<h3><?php _e('Admin Approve','userpro-media'); ?></h3>

<table class="form-table">


<tr >
<th colspan=3>

</th>
</tr>
<tr valign="top">

		<th scope="row"><label><?php _e('#','userpro-media'); ?></label></th>
		<th scope="row"><label ><?php _e('Media','userpro-media'); ?></label></th>
		<th scope="row"><label><?php _e('Users','userpro-media'); ?></label></th>
		<th scope="row"><label><?php _e('Action','userpro-media'); ?></label></th>
		
</tr>

	

<?php 

		
		$n=1;
		$media_array=get_option('userpro_media_gallery');

		for($i=(count($media_array)-1);$i>=0;$i--)
		{
		if(isset($media_array[$i]['admin_approve']) && $media_array[$i]['admin_approve']=='1')
		{ 
		?>
		<tr valign="top" id="<?php echo $media_array[$i]['media_id'];?>" >	
		<td ><div>
			<?php echo $n;?>
		</div></td>
		
		<?php if(isset($media_array[$i]['type']) && $media_array[$i]['media_type']=='video' && $media_array[$i]['type']=='youtube') { ?>
				<td>
				<?php  $width=200;
	$height=200;
				$userurl=preg_replace(
			array('/width="\d+"/i', '/height="\d+"/i'),
			array(sprintf('width="%d"', $width), sprintf('height="%d"', $height)),
			stripslashes($media_array[$i]['media_url'])); 
		
	 echo  "<div class='thumbnail_media'>". $userurl."<br></div>";

  ?>
				</td><?php }
elseif($media_array[$i]['media_type']=='video' || $media_array[$i]['media_type']=='music') {?>	
				<td>
					<div class="thumbnail_media" ><embed src="<?php echo $media_array[$i]['media_url']?>" alt="<?php echo $media_array[$i]['media_display_name']?>" autoplay="false">
					
</td><?php }
 elseif($media_array[$i]['media_type']=='photo') {?>
<td>

<img src="<?php echo $media_array[$i]['thumbnail_path'];?>">
</td>
	<?php } ?>



				
				<td>
					<?php echo $media_array[$i]['user_id'];?>
				</td>
				

		
		
			
	
		
		<td>
		<div>
			<?php echo '<a href=#><i onclick="mediamanager_approve_media('.$media_array[$i]['media_id'].');" >Approve</i></a>';?>
			
			
		</div>

		</td>	
		<?php }
				
			
		$n++;}  ?>

	</tr>

	
	
</table>



<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro-media'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-media'); ?>"  />
</p>

</form>

