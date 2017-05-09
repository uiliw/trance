<?php
require_once(userpro_media_path."/lib/getid3/getid3.php");
class Userpro_Media_Manager{
	function __construct(){
		$this->slug = 'userpro';
		$this->subslug = 'userpro-media';
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->plugin_data = get_plugin_data( userpro_media_path . 'index.php', false, false);
		$this->version = $this->plugin_data['Version'];
	}
	
	function get_media_list_view($media_list,$user_id){
 		global $userpro_media_api;$options=get_option('userpro_media');
              if(userpro_media_get_option('media_hidefile')=='y')
		{
			echo "  <script> 
				jQuery(document).ready(function() {
				jQuery('.description').hide();
			});</script>";
			
		}		
		switch($media_list)
		{    

			case 'photos':
					
				$user_condition = get_current_user_id() == $user_id ? 1 : 0 ;
				$media_restrict_condition =  userpro_media_get_option('media_restrict') == 'n' ? 1 : 0 ;
				
				$medias=get_option('userpro_media_gallery');$media_array=array();
				foreach($medias as $media)
				{
					if(isset($media['media_type']) && $media['media_type']=='photo' && $media['user_id']==$user_id)
					{
						if(file_exists($media['media_path']))
						{
							if( $media_restrict_condition || ($media['media_restriction'] == 'public' || $user_condition )){
								array_push($media_array,$media);
							}
						}
					}
				}
				
				$media_per_page=$options['media_per_page'];
				if(count($media_array)<=$media_per_page)
				{
					for($i=(count($media_array)-1);$i>=0;$i--)
				{
						
						if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{

						if(get_option($media_array[$i]['media_name'])!='')
						{
							$media_array[$i]['media_display_name']=get_option($media_array[$i]['media_name']);
						}
						
						if($options['media_view']=='y')
						{
							echo '<div class="thumbnail_media photos">
									<a class="userpro-tip-fade lightview" data-lightview-group="photo1" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
									</a>
									<div class="media_actions_photos">
										<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
										<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
										<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
									</div>
								   </div>';
				
					
						}
						else
						{
							echo '<div class="thumbnail_media photos">
									<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
									</a>
									<div class="media_actions_photos">
										<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
										<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
										<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
									</div>
								  </div>';
	
						}
					}
				}}
				else
				{
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{
							
						
						if(get_option($media_array[$i]['media_name'])!='')
						{	
							$media_array[$i]['media_display_name']=get_option($media_array[$i]['media_name']);
						}
					
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photos" id="'.$i.'" style="display:block">
										<a class="userpro-tip-fade lightview" data-lightview-group="photo1" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_photos">
											<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
											<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>  
									</div>';
	
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photos" id="'.$i.'" style="display:none">
										<a class="userpro-tip-fade lightview" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'><img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_photos">
											<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
											<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
									
								echo '<div class="thumbnail_media photos" id="'.$i.'" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_photos">
											<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
											<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
	
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photos" id="'.$i.'" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_photos">
											<div class="userpro_media_sharebutton">'.userpro_media_sharebutton($media_array[$i]['media_url']).'</div>
											<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
	
							}
						}
					}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page" type="button" onclick="get_previous_page_media();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page" type="button" onclick="get_next_page_media();" value="'.__('Next','userpro-media').'">';
					}
				break;
			case 'videos':$getDemo=new getID3();$media_array=array();
				$medias=get_option('userpro_media_gallery');
				
				$user_condition = get_current_user_ID() == $user_id ? 1 : 0 ;
				$media_restrict_condition =  userpro_media_get_option('media_restrict') == 'n' ? 1 : 0 ;
				
				foreach($medias as $media)
				{
					if(isset($media['media_type']) && $media['media_type'] == 'video' && isset($media['user_id'])==$user_id)
					{
						if((isset($media['media_path']) && file_exists($media['media_path'])) || (isset($media['type']) && $media['type']=="youtube"))
						{
							if( $media_restrict_condition || ($media['media_restriction'] == 'public' || $user_condition )){
								array_push($media_array,$media);
							}
						}
					}
				}
				$media_per_page=$options['media_per_page'];
				if(count($media_array)<=$media_per_page)
				{
					
					for($i=(count($media_array)-1);$i>=0;$i--)
					{

						if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{
						
						if($options['media_view']=='y')
						{

						if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
							{
								
								echo '<div class="thumbnail_media videos" id="'.$i.'_video">
										<a class="userpro-tip-fade lightview" data-lightview-group="video1" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/></a>
										<div class="media_actions_videos">
											<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
										</div>
									  </div>';
							}
							else
								{
							echo '<div class="thumbnail_media videos" id="'.$i.'_video">
									<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a class="userpro-tip-fade lightview" data-lightview-group="video2" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'><br/>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a>
											<div class="media_actions_videos">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
												<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
											</div>
								  </div>';
								}						
						}
						else
						{

							if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
							{
									
								echo '<div class="thumbnail_media videos" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/>
										<div class="media_actions_videos">
											<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
									 	</div> 
									</div>';
							}
							else
							{	
								echo '<div class="thumbnail_media videos" id="'.$i.'_video">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<div class="media_actions_videos">
													<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
													<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
												</div>
									  </div>';
							}
						}
					}
					}}
				else
				{
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{ if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{
						
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
										
									echo '<div class="thumbnail_media videos" id="'.$i.'_video">
											<a class="userpro-tip-fade lightview" data-lightview-group="video3" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/>
											</a>
											<div class="media_actions_videos">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											</div>
										  </div>';
								}
								else
								{	
									echo '<div class="thumbnail_media videos" id="'.$i.'_video" style="display:block">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
													<a class="userpro-tip-fade lightview" data-lightview-group="video4" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
															<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
													</a>
													<div class="media_actions_videos">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
													</div>
										  </div>';
								}
							}
							elseif(isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media videos" id="'.$i.'_video">
											<a class="userpro-tip-fade lightview" data-lightview-group="video5" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/>
											</a>
											<div class="media_actions_videos">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
											</div>
											</div>';
								}
								else 
								{	
									echo '<div class="thumbnail_media videos" id="'.$i.'_video" style="display:none">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
													<a class="userpro-tip-fade lightview" data-lightview-group="video6" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
															<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
													</a>
													<div class="media_actions_videos">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
													</div>
										  </div>';
								}
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media videos" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/> </div>';
								}
								else
								{
									echo '<div class="thumbnail_media videos" id="'.$i.'_video" style="display:block">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
													<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
															<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
													</a>
													<div class="media_actions_videos">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
													</div>
										  </div>';
								}
							}
							elseif(isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media videos" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/>'.report_to_admin($media_array[$i]['media_id']).' </div>';
								}
								else
								{	
									echo '<div class="thumbnail_media videos" id="'.$i.'_video" style="display:none">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
													<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
															<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
													</a>
													<div class="media_actions_videos">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
													</div>
										  </div>';
								}
							}
						}
					}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count_video" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count_video" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count_video" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page_video" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page_video" type="button" onclick="get_previous_page_media_video();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page_video" type="button" onclick="get_next_page_media_video();" value="'.__('Next','userpro-media').'">';
					}
				break;
			case 'music':$getThumb=new getID3();$media_array=array();
				$medias=get_option('userpro_media_gallery');
				
				$user_condition = get_current_user_ID() == $user_id ? 1 : 0 ;
				$media_restrict_condition =  userpro_media_get_option('media_restrict') == 'n' ? 1 : 0 ;
				
				foreach($medias as $media)
				{
					if(isset($media['media_type']) && $media['media_type']=='music' && $media['user_id']==$user_id)
					{
						if(file_exists($media['media_path']))
						{
							if( $media_restrict_condition || ($media['media_restriction'] == 'public' || $user_condition )){
								
								array_push($media_array,$media);
							}
						}
					}
				}
				$media_per_page=$options['media_per_page'];
				if(count($media_array)<=$media_per_page)
				{
					for($i=(count($media_array)-1);$i>=0;$i--)
					{if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{
						if($options['media_view']=='y')
						{
							$getDetails=$getThumb->analyze($media_array[$i]['media_path']);
							if(isset($getDetails['comments']['picture'][0]))
							{
								$Image='data:'.$getDetails['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($getDetails['comments']['picture'][0]['data']);
							}
							if(isset($Image))
							{
													
								echo '<div class="thumbnail_media music" id="'.$i.'_music">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<div class="media_actions_music">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
												</div>
									  </div>';
							}
							else
							{
								echo '<div class="thumbnail_media music" id="'.$i.'_music">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<div class="media_actions_music">
														<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
														<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
												</div>		
									  </div>';
							}
						}
						else
						{
							echo '<div class="thumbnail_media music" id="'.$i.'_music">
									<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a>
											<div class="media_actions_music">
													<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
													<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
											</div>
								  </div>';
						}
					}}
				}
				else
				{
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{if(!array_key_exists('admin_approve',$media_array[$i]) || $media_array[$i]['admin_approve']=='0')
						{
						
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music" id="'.$i.'_music" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media[$i]['media_display_name'].'" autoplay="false"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_music">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
												<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music" id="'.$i.'_music" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media[$i]['media_display_name'].'" autoplay="false"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_music">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
												<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music" id="'.$i.'_music" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_music">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
												<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music" id="'.$i.'_music" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<div class="media_actions_music">
												<span class="report_to_admin">'.report_to_admin($media_array[$i]['media_id']).'</span></br>
												<span class="likeanddislike">'.likeanddislike($media_array[$i]['media_id']).'</span>
										</div>
									  </div>';
							}
						}
					}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count_music" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count_music" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count_music" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page_music" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page_music" type="button" onclick="get_previous_page_media_music();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page_music" type="button" onclick="get_next_page_media_music();" value="'.__('Next','userpro-media').'">';
					}
				break;
		}
	}
	
	function get_media_list_edit($media_list,$user_id){ 
		global $userpro_media_api;$options=get_option('userpro_media');
		
		switch($media_list)
		{
			case 'photos':
				if(userpro_media_get_option('media_approve')=='1')	
				echo "<br><div><b>Media will be publish on your profile once admin has approved<b></div>";
				$medias=get_option('userpro_media_gallery');$media_array=array();
				foreach($medias as $media)
				{
					if(isset($media['media_type']) && $media['media_type']=='photo' && $media['user_id']==$user_id)
					{
						if(file_exists($media['media_path']))
						{
							array_push($media_array,$media);
						}
					}
				}
				$media_per_page=$options['media_per_page'];
			
				if(count($media_array)<=$media_per_page)
				{
				
				
					
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						
						if(get_option($media_array[$i]['media_name'])!='')
						{	
							$media_array[$i]['media_display_name']=get_option($media_array[$i]['media_name']);
						}
						if($options['media_view']=='y')
						{
							
							echo '<div class="thumbnail_media photo_edit" id="'.$i.'">
									<a class="userpro-tip-fade addthis_button_compact lightview" data-lightview-group="photos1" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<img src="'.$media_array[$i]['thumbnail_path'].'" ><br/>
													<div  class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
									</a>
									<br/>
									<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
								  </div>';
		
						}
						else
						{
							echo '<div class="thumbnail_media photo_edit" id="'.$i.'">
									<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<img src="'.$media_array[$i]['thumbnail_path'].'" ><br/>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
									</a>
									<br/>
									<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
								  </div>';

			
						}
					}
				}
				else
				{
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						
						if(get_option($media_array[$i]['media_name'])!='')
						{	
							$media_array[$i]['media_display_name']=get_option($media_array[$i]['media_name']);
						}
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photo_edit" id="'.$i.'" style="display:block">
										<a class="userpro-tip-fade lightview addthis_button_compact" data-lightview-group="photos2" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photo_edit" id="'.$i.'" style="display:none">
										<a class="userpro-tip-fade lightview" data-lightview-group="photos3" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photo_edit" id="'.$i.'" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media photo_edit" id="'.$i.'" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<img src="'.$media_array[$i]['thumbnail_path'].'"><br/>
														<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a>
										<br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page" type="button" onclick="get_previous_page_media();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page" type="button" onclick="get_next_page_media();" value="'.__('Next','userpro-media').'">';
				}
				break;
			case 'videos':
				if(userpro_media_get_option('media_approve')=='1')
					echo "<br><div><b>Media will be publish on your profile once admin has approved<b></div>";
				$getDemo=new getID3();$media_array=array();
				$medias=get_option('userpro_media_gallery');
				if( isset( $medias) && is_array($medias) ){
					foreach($medias as $media)
					{
					
						if(isset($media['media_type']) && $media['media_type']=='video' && $media['user_id']==$user_id)
						{  
							if((isset($media['media_path']) && file_exists($media['media_path'])) || (isset($media['type']) && $media['type']=="youtube"))
							{  
								array_push($media_array,$media);
							}
						}
					}
				}
				$media_per_page=$options['media_per_page'];
				if(count($media_array)<=$media_per_page)
				{	
		
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						
						if($options['media_view']=='y')
						{
							
							if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
							{
								
								echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">
										<a class="userpro-tip-fade lightview" data-lightview-group="videos1" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/>
										</a>
										<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							else
							{	
								echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a class="userpro-tip-fade lightview" data-lightview-group="videos2" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a><br/>
											<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'"></div>';
							}
						}
						else
						{ 
							if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
							{
							
								echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							else
							{	
								echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a><br/>
											<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
					}
				}
				else
				{
					
					echo '<div class="thumbnail_media video_edit" id="'.$i.'_video" style="display:block">
							<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
								<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
									<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
								</a>
								<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
						  </div>';
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">
											<a class="userpro-tip-fade lightview" data-lightview-group="videos3" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/> </a>
												<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
								else
								{
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video" style="display:block">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a class="userpro-tip-fade lightview" data-lightview-group="videos4" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
							}
							elseif(isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">
											<a class="userpro-tip-fade lightview" data-lightview-group="videos5" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>'. $media_array[$i]['media_url'].' <br/> </a>
											<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
								else
								{
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video" style="display:none">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a class="userpro-tip-fade lightview" data-lightview-group="videos6" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a><input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/>
											<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
								else
								{	
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video" style="display:block">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
							}
							elseif(isset($media_array[$i]))
							{
								if(isset($media_array[$i]['type']) && $media_array[$i]['type']=='youtube')
								{
								
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video">'. $media_array[$i]['media_url'].' <br/> 
											<input class="userpro-button red" type="button" onclick="userpro_delete_youtubeurl(\''.$media_array[$i]['media_id'].'\',\''.$user_id.'\',this)" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
								else
								{	
									echo '<div class="thumbnail_media video_edit" id="'.$i.'_video" style="display:none">
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
													<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
												</a>
												<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_video\')" style="" value="'.__('Remove','userpro-media').'">
										  </div>';
								}
							}
						}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count_video" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count_video" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count_video" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page_video" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page_video" type="button" onclick="get_previous_page_media_video();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page_video" type="button" onclick="get_next_page_media_video();" value="'.__('Next','userpro-media').'">';
				}
				break;
			case 'music':
				if(userpro_media_get_option('media_approve')=='1')
					echo "<br><div><b>Media will be publish on your profile once admin has approved<b></div>";
				$getThumb=new getID3();$media_array=array();
				$medias=get_option('userpro_media_gallery');
				foreach($medias as $media)
				{
					if(isset($media['media_type']) && $media['media_type']=='music' && $media['user_id']==$user_id)
					{
						if(file_exists($media['media_path']))
						{
							array_push($media_array,$media);
						}
					}
				}
				$media_per_page=$options['media_per_page'];
				if(count($media_array)<=$media_per_page)
				{
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						if($options['media_view']=='y')
						{
							$getDetails=$getThumb->analyze($media_array[$i]['media_path']);
							if(isset($getDetails['comments']['picture'][0]))
							{
								$Image='data:'.$getDetails['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($getDetails['comments']['picture'][0]['data']);
							}
							if(isset($Image))
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a><br/>
											<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							else
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music">
										<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
											<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
											</a><br/>
											<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
						else
						{
							echo '<div class="thumbnail_media music_edit" id="'.$i.'_music">
									<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a><br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
								  </div>';
						}
					}
				}
				else
				{
					$count=1;
					for($i=(count($media_array)-1);$i>=0;$i--)
					{
						if($options['media_view']=='y')
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a><br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a><br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
						else
						{
							if($i<$media_per_page && isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music" style="display:block">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media[$i]['media_display_name'].'" autoplay="false"><br/>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a><br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
							elseif(isset($media_array[$i]))
							{
								echo '<div class="thumbnail_media music_edit" id="'.$i.'_music" style="display:none">
										<a target="_blank" href="'.$media_array[$i]['media_url'].'" '.userpro_file_type_icon($media_array[$i]['media_url']).'>
											<embed src="'.$media_array[$i]['media_url'].'" alt="'.$media_array[$i]['media_display_name'].'" autoplay="false"><br/>
												<div class="upm_display_name">'.$media_array[$i]['media_display_name'].'</div>
										</a><br/>
										<input class="userpro-button red" type="button" onclick="userpro_delete_files(\''.$media_array[$i]['media_path'].'\',\''.$user_id.'\',\''.$i.'_music\')" style="" value="'.__('Remove','userpro-media').'">
									  </div>';
							}
						}
					}
					echo '<div class="userpro-input">';
					echo '<input type="hidden" id="count_music" name="counter" value="'.$count.'">';
					echo '<input type="hidden" id="total_page_count_music" name="count" value="'.ceil(count($media_array)/$media_per_page).'">';
					echo '<input type="hidden" id="total_media_count_music" name="media_count" value="'.count($media_array).'">';
					echo '<input type="hidden" id="media_per_page_music" name="media_per_page" value="'.$media_per_page.'">';
					echo '</div>';
					echo '<input class="userpro-button paginate-button-previous" id="previous_page_music" type="button" onclick="get_previous_page_media_music();" style="display:none" value="'.__('Previous','userpro-media').'">';
					echo '<input class="userpro-button paginate-button-next" id="next_page_music" type="button" onclick="get_next_page_media_music();" value="'.__('Next','userpro-media').'">';
				}
				break;
		}
	}
	
	function userID($inst_username){
		global $wp_version;
		$username = strtolower($inst_username); // sanitization
		
		$token = get_option('UMM_instagram_access_token');
			$url = "https://api.instagram.com/v1/users/search?q=".$username."&access_token=".$token."&public_content";
			$get = wp_remote_get($url,array('user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),'sslverify'   => true,'scope'=>'public_content'));
			$json = json_decode($get['body']);

			foreach($json->data as $user){
				if($user->username == $username){
					return $user->id;
				}
			}
		
	
		return '000000'; // return this if nothing is found
	}
	
	function get_instagram_view($inst_username){
	global $wp_version;
		$token = get_option('UMM_instagram_access_token');
		
		$user_id = $this->userID($inst_username);
		if($user_id != '000000'){
		$url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent/?access_token='.$token;
		
		$content = wp_remote_get($url,array('user-agent'  => 'WordPress/' . $wp_version . '; ' . home_url(),'sslverify'   => true,'scope'=>'public_content'));
		
		return $json = json_decode($content['body'],true);
		}
	}
}

$userpro_media_manager=new Userpro_Media_Manager();
?>
