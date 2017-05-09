<form method="post" action="">

<h3><?php _e('Reported Posts','userpro-media'); ?></h3>

<table class="form-table">
<style>
tr.socialwalltd td div {
margin-left: 10px;
}

</style>

<tr >
<th colspan=3>
<b><?php _e('Listed below are media on the profile which users have reported as objectionable or offensive','userpro-media');?></b>
</th>
</tr>
<tr valign="top">

		<th scope="row"><label><?php _e('#','userpro-media'); ?></label></th>
		<th scope="row"><label ><?php _e('Media','userpro-media'); ?></label></th>
		<th scope="row"><label><?php _e('Users','userpro-media'); ?></label></th>
		<th scope="row"><label><?php _e('Action','userpro-media'); ?></label></th>
		
</tr>

	

<?php 

		
		$i=1;
		$reported_media=get_option("reportedmedia");
		if(!empty($reported_media)){
		foreach($reported_media as $media)
		{?>
		<tr valign="top" id="<?php echo $media['mediaid'];?>" >	
		<td ><div>
			<?php echo $i;?>
		</div></td>
		
		<?php 
			$medias=get_option('userpro_media_gallery');
			foreach ($medias as $val)
			{
				
				if(isset($val['media_id']) && $val['media_id']==$media['mediaid'])
				{?>
				<?php if(isset($val['type']) && $val['media_type']=='video' && $val['type']=='youtube') { ?>
				<td>
				<?php  $width=200;
	$height=200;
				$userurl=preg_replace(
			array('/width="\d+"/i', '/height="\d+"/i'),
			array(sprintf('width="%d"', $width), sprintf('height="%d"', $height)),
			stripslashes($val['media_url'])); 
		
	 echo  "<div class='thumbnail_media'>". $userurl."<br></div>";

  ?>
				</td><?php }
elseif($val['media_type']=='video' || $val['media_type']=='music') {?>	
				<td>
					<div class="thumbnail_media" ><embed src="<?php echo $val['media_url']?>" alt="<?php echo $val['media_display_name']?>" autoplay="false">
					
</td><?php }
 elseif($val['media_type']=='photo') {?>
<td>
<img src="<?php echo $val['thumbnail_path'];?>">
</td>
	<?php } ?>



		<td>
					<?php echo $media['userid'];?>
				</td>
				

		
		
			
	
		

		<?php   
			$path=$val['media_path'];
			$media_id    =$media['mediaid'];		
				
			?>
		<td>
		<div>
			<?php if(isset($val['type']) && $val['media_type']=='video' && $val['type']=='youtube') { 
						echo '<a href=#><i onclick="mediamanager_delete_youtubeurl('.$media_id.');" >Delete /</i></a>';
		} else {
			echo '<a href=#><i onclick="mediamanager_delete_files(\''.$path.'\','.$media_id.');" >Delete /</i></a>'; }?>
			<?php echo '<a href=#><i onclick="mediamanager_ignore_media('.$media_id.');" >Ignore</i></a>';?>
			
		</div>

		</td>	
		<?php }
				
			}?>
		<?php $i++; } 
		}?>

	</tr>

	
	
</table>



<p class="submit">
	<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes','userpro-media'); ?>"  />
	<input type="submit" name="reset-options" id="reset-options" class="button" value="<?php _e('Reset Options','userpro-media'); ?>"  />
</p>

</form>

