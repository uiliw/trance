<?php

add_action('init', 'bsaStartSession', 1);
function bsaStartSession()
{
	if(!session_id()) {
		session_start();
	}
}

// -- START -- Marketing Agency Functions
function bsa_role()
{
	if ( current_user_can('manage_option') || current_user_can('install_plugins') ) {
		return 'admin';
	} else {
		$privileges = explode(',', bsa_get_opt('admin_settings', 'privileges'));
		if ( bsa_get_opt('admin_settings', 'privileges') != '' && $privileges ) {
			foreach ( $privileges as $capability ) {
				if ( current_user_can( $capability ) ) {
					return 'admin';
				}
			}
		}
		return 'user';
	}
}

function bsa_verify_role($id, $type)
{
	$model = new BSA_PRO_Model();
	$user_info = get_userdata(get_current_user_id());

	if ( bsa_role() == 'admin' ) {
		return TRUE;
	} else {
		if ( $type == 'site' ) {
			if ( bsa_site($id, 'user_id') == get_current_user_id() ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $type == 'space' ) {
			if ( bsa_space($id, 'site_id') != NULL && strpos($model->getUserSites('id', bsa_role()), bsa_space($id, 'site_id')) !== FALSE ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $type == 'ad' ) {
			if ( bsa_ad($id, 'space_id') != NULL && strpos($model->getUserSpaces(), bsa_ad($id, 'space_id')) !== FALSE ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}

function bsa_site($id, $column = NULL)
{
	$model = new BSA_PRO_Model();
	$get_site = $model->getSite($id);
	$params = explode(',', $column);

	foreach ( $params as $param ) {
		if ( isset($_SESSION['bsa_site_'.$id][$param]) && $_SESSION['bsa_site_'.$id][$param] != '' ) {
			return $_SESSION['bsa_site_'.$id][$param];
		} else {
			if ( $param != NULL ) {
				if ( $get_site[$param] ) {
					$_SESSION['bsa_site_'.$id][$param] = $get_site[$param];
					return $get_site[$param];
				} else {
					return NULL;
				}
			} else {
				if ( $get_site ) {
					$_SESSION['bsa_site_'.$id]['id'] = $get_site['id'];
					return $get_site['id'];
				} else {
					return NULL;
				}
			}
		}
	}
}
// -- END -- Marketing Agency Functions

//function bsa_space($id, $column = NULL)
//{
//	$model = new BSA_PRO_Model();
//	$get_space = $model->getSpace($id);
//	$params = explode(',', $column);
//
//	foreach ( $params as $param ) {
//		if ( isset($_SESSION['bsa_space_'.$id][$param]) && $_SESSION['bsa_space_'.$id][$param] != '' ) {
//			return $_SESSION['bsa_space_'.$id][$param];
//		} else {
//			if ( $param != NULL ) {
//				if ( $get_space[$param] ) {
//					$_SESSION['bsa_space_'.$id][$param] = $get_space[$param];
//					return $get_space[$param];
//				} else {
//					return NULL;
//				}
//			} else {
//				if ( $get_space ) {
//					$_SESSION['bsa_space_'.$id]['id'] = $get_space['id'];
//					return $get_space['id'];
//				} else {
//					return NULL;
//				}
//			}
//		}
//	}
//}
//
//function get_bsa_ads()
//{
//	$model = new BSA_PRO_Model();
//	$get_ads = $model->getAds();
//
//	return $get_ads;
//}
//
//function bsa_ad($id, $column = NULL)
//{
//	$model = new BSA_PRO_Model();
//	$get_ad = $model->getAd($id);
//	$params = explode(',', $column);
//
//	foreach ( $params as $param ) {
//		if ( isset($_SESSION['bsa_ad_'.$id][$param]) && $_SESSION['bsa_ad_'.$id][$param] != '' ) {
//			return $_SESSION['bsa_ad_'.$id][$param];
//		} else {
//			if ( $param != NULL ) {
//				if ( $get_ad[$param] ) {
//					$_SESSION['bsa_ad_'.$id][$param] = $get_ad[$param];
//					return $get_ad[$param];
//				} else {
//					return NULL;
//				}
//			} else {
//				if ( $get_ad ) {
//					$_SESSION['bsa_ad_'.$id]['id'] = $get_ad['id'];
//					return $get_ad['id'];
//				} else {
//					return NULL;
//				}
//			}
//		}
//	}
//}

function bsa_get_opt($var, $str)
{
	$get = get_option('bsa_pro_plugin_' . $var);
	if ( isset($get) && isset($get[$str]) ) {
		return $get[$str];
	} else {
		return null;
	}
}

function bsa_get_trans($var, $str)
{
	$get = get_option('bsa_pro_plugin_trans_' . $var);
	if ( isset($get) && isset($get[$str]) ) {
		return $get[$str];
	} else {
		return null;
	}
}

function bsa_space($id, $column = NULL)
{
	$params = explode(',', $column);

	if ( $params != null ) {
		foreach ( $params as $param ) {
			if ( $param != '' ) {
				if ( isset($_SESSION['bsa_space_'.$id][$param]) && $_SESSION['bsa_space_'.$id][$param] != '' ) {
					return $_SESSION['bsa_space_'.$id][$param];
				} else {
					$model = new BSA_PRO_Model();
					$get_space = $model->getSpace($id);
					if ( $param != null ) {
						if ( isset($get_space[$param]) ) {
							$_SESSION['bsa_space_'.$id][$param] = $get_space[$param];
							return $get_space[$param];
						} else {
							return null;
						}
					} else {
						if ( isset($get_space) ) {
							$_SESSION['bsa_space_'.$id]['id'] = $get_space['id'];
							return $get_space['id'];
						} else {
							return null;
						}
					}
				}
			} else {
				$model = new BSA_PRO_Model();
				$get_space = $model->getSpace($id);
				if ( isset($get_space) ) {
					$_SESSION['bsa_space_'.$id]['id'] = $get_space['id'];
					return $get_space['id'];
				} else {
					return null;
				}
			}
		}
	} else {
		$model = new BSA_PRO_Model();
		$get_space = $model->getSpace($id);
		if ( isset($get_space) ) {
			$_SESSION['bsa_space_'.$id]['id'] = $get_space['id'];
			return $get_space['id'];
		} else {
			return null;
		}
	}
}

function get_bsa_ads()
{
	$model = new BSA_PRO_Model();
	$get_ads = $model->getAds();

	return $get_ads;
}

function bsa_ad($id, $column = NULL)
{
	$params = explode(',', $column);

	if ( $params != null ) {
		foreach ( $params as $param ) {
			if ( $param != '' ) {
				if ( isset($_SESSION['bsa_ad_'.$id][$param]) && $_SESSION['bsa_ad_'.$id][$param] != '' ) {
					return $_SESSION['bsa_ad_'.$id][$param];
				} else {
					$model = new BSA_PRO_Model();
					$get_ad = $model->getAd($id);
					if ( $param != null ) {
						if ( isset($get_ad[$param]) ) {
							$_SESSION['bsa_ad_'.$id][$param] = $get_ad[$param];
							return $get_ad[$param];
						} else {
							return null;
						}
					} else {
						if ( isset($get_ad) ) {
							$_SESSION['bsa_ad_'.$id]['id'] = $get_ad['id'];
							return $get_ad['id'];
						} else {
							return null;
						}
					}
				}
			} else {
				$model = new BSA_PRO_Model();
				$get_ad = $model->getAd($id);
				if ( isset($get_ad) ) {
					$_SESSION['bsa_ad_'.$id]['id'] = $get_ad['id'];
					return $get_ad['id'];
				} else {
					return null;
				}
			}
		}
	} else {
		$model = new BSA_PRO_Model();
		$get_ad = $model->getAd($id);
		if ( isset($get_ad) ) {
			$_SESSION['bsa_ad_'.$id]['id'] = $get_ad['id'];
			return $get_ad['id'];
		} else {
			return null;
		}
	}
}

// generate form url
function bsaFormURL($sid = null, $type = null)
{
	$ofu = get_option('bsa_pro_plugin_ordering_form_url');
	$mfu = get_site_option('bsa_pro_plugin_order_form_url');
	$oau = get_option('bsa_pro_plugin_agency_ordering_form_url');
	$mau = get_site_option('bsa_pro_plugin_agency_order_form_url');
	$form_url = ((isset($type) && $type == 'agency') ? ((is_multisite()) ? $mau : $oau) : ((is_multisite()) ? $mfu : $ofu));

	if ( $sid == null && $type == null ) {
		return $form_url;
	} elseif ( $sid != null && $type != null ) {
		return $form_url.(( strpos($form_url, '?') == TRUE ) ? '&sid='.$sid : '?sid='.$sid).(bsa_space($sid, 'site_id') != '' ? '&site_id='.bsa_space($sid, 'site_id') : '');
	} else {
		return $form_url.(( strpos($form_url, '?') == TRUE ) ? '&sid='.$sid : '?sid='.$sid);
	}
}

function bsaGetExampleAd($template, $edit = null)
{
	if ( isset($edit) ) {
		$ad = array(
			array(
				"template" => $template,
				"id" => 0,
				"title" => get_option('bsa_pro_plugin_trans_example_title'),
				"description" => get_option('bsa_pro_plugin_trans_example_desc'),
				"url" => get_option('bsa_pro_plugin_trans_example_url'),
				"img" => plugins_url('/bsa-pro-scripteo/frontend/img/example.jpg')
			)
		);
	} else {
		if ( isset($_POST['bsa_ad_id']) ) {
			$ad = array(
				array(
					"template" => $template,
					"id" => 0,
					"title" => bsa_ad($_POST['bsa_ad_id'], "title"),
					"description" => bsa_ad($_POST['bsa_ad_id'], "description"),
					"url" => bsa_ad($_POST['bsa_ad_id'], "url"),
					"img" => bsa_ad($_POST['bsa_ad_id'], "img")
				)
			);
		} else {
			$ad = null;
		}
	}

	return $ad;
}

function bsaCreateCustomAdTemplates()
{
	$custom_templates = get_option('bsa_pro_plugin_custom_templates');
	if ( $custom_templates ) {
		$custom_templates = explode(',', $custom_templates);
		foreach ( $custom_templates as $custom_template ) {
			if ( $custom_template != '' ) {
				$template = explode('--', $custom_template);
				$width = $template[0];
				$height = $template[1];
				bsaCreateAdTemplate($width, $height);
			}
		}
	}
}

function bsaGetPost($name)
{
	if (isset($_POST[$name])) {
		return $_POST[$name];
	} else {
		return '';
	}
}

function bsa_crop_tool($crop = null, $img_url = null, $width = null, $height = null)
{
	if ( $img_url != null ) {
		if ( $crop == 'yes' && $width != null && $height != null && bsa_get_opt('other', 'crop_tool') != 'no' ) {
			return bfi_thumb($img_url, array('width' => $width, 'height' => $height, 'crop' => true));
		} else if ( $crop == 'ajax' ) {
			return $img_url;
		} else {
			return $img_url;
		}
	} else {
		return plugins_url('/bsa-pro-scripteo/frontend/img/example.jpg');
	}
}

function bsa_column_exists($table, $column)
{
	$model = new BSA_PRO_Model();
	$if_exists = $model->columnExists($table, $column);

	if ( $if_exists != FALSE ) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function bsa_option_exists($id, $table, $column)
{
	if ( isset($id) && $id != '' && isset($table) && $table != '' && isset($column) && $column != '' ) {

		if ( $table == 'sites' ) {
			if ( bsa_site($id, $column) != NULL || bsa_site($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $table == 'spaces' ) {
			if ( bsa_space($id, $column) != NULL || bsa_space($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $table == 'ads' ) {
			if ( bsa_ad($id, $column) != NULL || bsa_ad($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function bsa_counter($id, $type)
{
	$model = new BSA_PRO_Model();
	$get_counter = $model->getCounter($id, $type);

	if ( $get_counter ) {
		return $get_counter;
	} else {
		return NULL;
	}
}

add_filter( 'the_content', 'bsa_load_ads_in_content' );
function bsa_load_ads_in_content($content) {
	if ( get_option('bsa_pro_plugin_before_hook') != '' && get_option('bsa_pro_plugin_before_hook') != null || get_option('bsa_pro_plugin_after_hook') != '' && get_option('bsa_pro_plugin_after_hook') != null ) {
		$get_before 		= explode(';', get_option('bsa_pro_plugin_before_hook'));
		$get_after 			= explode(';', get_option('bsa_pro_plugin_after_hook'));
		$before_content 	= null;
		$after_content 		= null;

		if ( isset($get_before) ) {
			foreach ( $get_before as $before ) {
				$before_content 	.= do_shortcode($before);
			}
		}
		if ( isset($get_after) ) {
			foreach ( $get_after as $after ) {
				$after_content 		.= do_shortcode($after);
			}
		}
		return $before_content.$content.$after_content;
	} else {
		return $content;
	}
}

add_filter( 'the_content', 'bsa_load_ads_after_paragraphs' );
function bsa_load_ads_after_paragraphs( $content ) {
	$p_tag				= '</p>';
	$paragraphs = explode( $p_tag, $content );
	foreach ($paragraphs as $key => $paragraph) {
		for ( $i = 1; $i <= 10; $i++ ) {
			$after_paragraph 	= $i;
			if ( get_option('bsa_pro_plugin_after_' . $i . '_paragraph') != '' && get_option('bsa_pro_plugin_after_' . $i . '_paragraph') != null ) {
				$get_after = explode(';', get_option('bsa_pro_plugin_after_' . $i . '_paragraph'));
				foreach ( $get_after as $after ) {
//					if ( trim( $paragraph ) ) {
//						$paragraphs[$key] .= $p_tag;
//					}
					if ( $after_paragraph == $key + 1 ) {
						$paragraphs[$key] .= do_shortcode($after);
					}
				}
			}
		}
	}
	if ( isset($get_after) ) {
		return implode( '', $paragraphs );
	} else {
		return $content;
	}
}

// bp hooks
add_filter( 'wp_footer', 'bsa_load_bp_hooks' );
function bsa_load_bp_hooks( ) {
	//	var_dump(!bp_is_blog_page());
	if ( function_exists('bp_is_current_component') && bp_is_current_component( 'activity' ) ) { // show ads after activity
		for ( $i = 1; $i <= 20; $i++ ) {
			$get_hooks = get_option('bsa_pro_plugin_bp_stream_hook');
			if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
				$shortcodes = explode(';', $get_hooks[$i]);
				foreach ( $shortcodes as $shortcode ) {
					$get_shortcode 	= shortcode_parse_atts($shortcode);
					$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
					$max_width 		= (isset($get_shortcode['max_width']) ? trim($get_shortcode['max_width'], ']') : null);
					$delay 			= (isset($get_shortcode['delay']) ? trim($get_shortcode['delay'], ']') : null);
					$padding_top 	= (isset($get_shortcode['padding_top']) ? trim($get_shortcode['padding_top'], ']') : null);
					$attachment 	= (isset($get_shortcode['attachment']) ? trim($get_shortcode['attachment'], ']') : null);
					$crop 			= (isset($get_shortcode['crop']) ? trim($get_shortcode['crop'], ']') : null);
					$if_empty 		= (isset($get_shortcode['if_empty']) ? trim($get_shortcode['if_empty'], ']') : null);
					?>
					<div class="bsa_pro_buddypress_stream_<?php echo $i.$id ?>" style="display:none"><?php echo bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty) ?></div>
					<script>
						(function ($) {
							$(document).ready(function () {
								$( ".activity-item" ).each( function( i, el ) {
									if ( i + 1 == <?php echo $i ?> ) {
//										console.log(i+1);
//										console.log(el);
										$( '.bsa_pro_buddypress_stream_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
									}
								});
							});
						})(jQuery);
					</script>
				<?php
				}
			}
		}
	}
}

// bbp hooks
add_filter( 'wp_footer', 'bsa_load_bbp_hooks' );
function bsa_load_bbp_hooks( ) {
	if ( class_exists( 'bbPress' ) ) {
		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			if ( function_exists( 'bbp_is_single_forum' ) && bbp_is_single_forum() ) { // show ads after topic
				for ( $i = 1; $i <= get_option( '_bbp_topics_per_page', '15' ); $i++ ) {
					$get_hooks = get_option('bsa_pro_plugin_bbp_forum_hook');
					if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
						$shortcodes = explode(';', $get_hooks[$i]);
						foreach ( $shortcodes as $shortcode ) {
							$get_shortcode 	= shortcode_parse_atts($shortcode);
							$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
							?>
							<div class="bsa_pro_bbpress_forum_<?php echo $i.$id ?>" style="display:none"><?php echo do_shortcode($shortcode) ?></div>
							<script>
								(function ($) {
									$(document).ready(function () {
										$( "#bbpress-forums .type-topic" ).each( function( i, el ) {
											if ( i + 1 == <?php echo $i ?> ) {
//												console.log(i+1);
//												console.log(el);
												$( '.bsa_pro_bbpress_forum_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
											}
										});
									});
								})(jQuery);
							</script>
						<?php
						}
					}
				}
			} else if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() ) { // show ads after reply
				for ( $i = 1; $i <= get_option( '_bbp_replies_per_page', '15' ); $i++ ) {
					$get_hooks = get_option('bsa_pro_plugin_bbp_topic_hook');
					if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
						$shortcodes = explode(';', $get_hooks[$i]);
						foreach ( $shortcodes as $shortcode ) {
							$get_shortcode 	= shortcode_parse_atts($shortcode);
							$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
							?>
							<div class="bsa_pro_bbpress_reply">TEST121</div>
							<div class="bsa_pro_bbpress_reply_<?php echo $i.$id ?>" style="display:none"><?php echo do_shortcode($shortcode) ?></div>
							<script>
								(function ($) {
									$(document).ready(function () {
										$( "#bbpress-forums .type-reply" ).each( function( i, el ) {
											if ( i + 1 == <?php echo $i ?> ) {
//												console.log(i+1);
//												console.log(el);
												$( '.bsa_pro_bbpress_reply_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
											}
										});
									});
								})(jQuery);
							</script>
						<?php
						}
					}
				}
			}
		}
	}
}

function bsa_number_format($number)
{
	// default format
	$format = ((get_option('bsa_pro_plugin_currency_format')) ? explode('|', get_option('bsa_pro_plugin_currency_format')) : array(2, '.', ''));

	// if new
	if (isset($_GET['bsa_currency_format'])) {
		update_option('bsa_pro_plugin_currency_format', $_GET['bsa_currency_format']);
		$format = explode('|', $_GET['bsa_currency_format']);
	}
	$number = (isset($number) && $number > 0 ? $number : 0);

	return number_format($number, $format[0], $format[1], $format[2]);
}

function bsa_get_user_geo_data()
{
	if ( session_id() ) {
		if ( isset($_SESSION['bsaProGeoUser']) ) {
			return $_SESSION['bsaProGeoUser'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
			$response = wp_remote_get('http://ip-api.com/php/'.$ip);

			if( is_array($response) ) {
				$getGeoData = @unserialize($response['body']);
				if ( isset($getGeoData) ) {
					$_SESSION['bsaProGeoUser'] = $getGeoData;
					return $getGeoData;
				} else {
					return 'no_code';
				}
			} else {
				return 'no_code';
			}
		}
	} else {
		return 'no_code';
	}
}

function bsa_pro_verify_device($space_id)
{
	$detect = new BSA_Mobile_Detect();

	if ( isset($space_id) && bsa_space($space_id, 'devices') != '' && bsa_space($space_id, 'devices') != null && bsa_space($space_id, 'devices') != 'mobile,tablet,desktop' ) {

		if( !$detect->isMobile() && !$detect->isTablet() && in_array('desktop', explode(',', bsa_space($space_id, 'devices')), false) === true || // If desktop device.
			$detect->isTablet() && in_array('tablet', explode(',', bsa_space($space_id, 'devices')), false) === true || // If tablet device.
			$detect->isMobile() && !$detect->isTablet() && in_array('mobile', explode(',', bsa_space($space_id, 'devices')), false) === true ) { // If mobile device.

			if ( !$detect->isMobile() && !$detect->isTablet() ) {
//				echo 'desktop';
				if ( in_array('desktop', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} elseif ( $detect->isTablet() ) {
//				echo 'tablet';
				if ( in_array('tablet', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} elseif ( $detect->isMobile() && !$detect->isTablet() ) {
//				echo 'mobile';
				if ( in_array('mobile', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}

		} else {
			return false;
		}

	} else {
		return true;
	}
}

function bsa_pro_verify_geo($type, $countries)
{
	if ( $type != null && $countries != null && $countries != '' ) {
		$get_user_data = bsa_get_user_geo_data();
		if ( isset($get_user_data) || $get_user_data == 'no_code' ) {

			if ( $type == 'show' && $countries != null && $countries != '' || $type == 'hide' && $countries != null && $countries != '' ) {
				if ( isset($get_user_data['countryCode']) && $type == 'show' && in_array($get_user_data['countryCode'], explode(',', $countries), false) === true || // valid countries
					 isset($get_user_data['countryCode']) && $type == 'hide' && in_array($get_user_data['countryCode'], explode(',', $countries), false) !== true ) { // valid countries
					return true;
				} else {
					return false;
				}
			}

			if ( $type == 'show_advanced' && $countries != null && $countries != '' ) {
				if ($type == 'show_advanced' && in_array($get_user_data['regionName'], explode(',', $countries), false) === true || // valid region
					$type == 'show_advanced' && in_array($get_user_data['city'], explode(',', $countries), false) === true || // valid cities
					$type == 'show_advanced' && in_array($get_user_data['zip'], explode(',', $countries), false) === true) { // valid zip
					return true;
				} else {
					return false;
				}
			}

			if ( $type == 'hide_advanced' && $countries != null && $countries != '' ) {
				if ($type == 'hide_advanced' && in_array($get_user_data['regionName'], explode(',', $countries), false) !== true && // valid region
					$type == 'hide_advanced' && in_array($get_user_data['city'], explode(',', $countries), false) !== true && // valid cities
					$type == 'hide_advanced' && in_array($get_user_data['zip'], explode(',', $countries), false) !== true) { // valid zip
					return true;
				} else {
					return false;
				}
			}

			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

// get close actions
function bsaGetCloseActions($sid, $type)
{
	if ( bsa_space($sid, 'close_action') != null && bsa_space($sid, 'close_action') != '' ) {
		$get_close_action = explode(',', bsa_space($sid, 'close_action'));
		if ( $type == 'show_ads' ) {
			if ( isset($get_close_action[0]) ) {
				return number_format($get_close_action[0], 0, '', '');
			} else {
				return 0;
			}
		} elseif ( $type == 'show_close_btn' ) {
			if ( isset($get_close_action[1]) ) {
				return number_format($get_close_action[1], 0, '', '');
			} else {
				return 0;
			}
		} elseif ( $type == 'close_ads' ) {
			if ( isset($get_close_action[2]) ) {
				return number_format($get_close_action[2], 0, '', '');
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}

// capping function - capped ads
function bsaGetCappedAds($sid)
{
	$model 			= new BSA_PRO_Model();
	$capped_ads 	= (isset($_SESSION['bsa_capped_ads_'.$sid]) ? $_SESSION['bsa_capped_ads_'.$sid] : null);
	$ads 			= $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.$capped_ads);

	if ( isset($ads) ) {
		foreach ( $ads as $ad ) {
			$aid 			= $ad['id'];
			$ad_capping 	= bsa_ad($aid, 'capping');
			$sessionAdCapping 	= (isset($_SESSION['capped_ad_'.$aid]) ? $_SESSION['capped_ad_'.$aid] : null);

			if ( !isset($sessionAdCapping) ) {
				$_SESSION['capped_ad_'.$aid] = $ad_capping;
			}
		}

		foreach ( $ads as $ad ) {
			$aid 			= $ad['id'];
			$ad_capping 	= bsa_ad($aid, 'capping');

			if ( $ad_capping != null && $ad_capping != '' && $ad_capping > 0 ) { // if capping isset
				$sessionAdCapping 	= (isset($_SESSION['capped_ad_'.$aid]) ? $_SESSION['capped_ad_'.$aid] : null);

//			var_dump($sessionAdCapping);
				if ( !isset($sessionAdCapping) ) {
					$_SESSION['capped_ad_'.$aid] = $ad_capping;
				} else {
					if ( $sessionAdCapping > 0 ) {
						$_SESSION['capped_ad_'.$aid] = $sessionAdCapping - 1;
					} else {
						$capped_ads .= (strpos($capped_ads, ','.$aid) !== false) ? null : ','.$aid;
					}
				}
			}
		}
	}
//	var_dump($capped_ads);

	if ( $capped_ads ) {
		$_SESSION['bsa_capped_ads_'.$sid] = $capped_ads;
		return $capped_ads;
	} else {
		return null;
	}
}

function bsa_pro_ad_space($space_id = null, $max_width = null, $delay = null, $padding_top = null, $attachment = null, $crop = null, $if_empty = null, $custom_image = null)
{
	if ( $space_id == null ) {
		echo "<strong>ADS Error</strong> Missing <strong>id</strong> parameter!";
		return '';
	} else {
		$show_in_country = bsa_space($space_id, 'show_in_country');
		$hide_in_country = bsa_space($space_id, 'hide_in_country');
		$show_in_advanced = bsa_space($space_id, 'show_in_advanced');
		$hide_in_advanced = bsa_space($space_id, 'hide_in_advanced');

		$get_ids = json_decode(bsa_space($space_id, 'advanced_opt'));
		$get_blog_id = ( is_multisite() ? get_current_blog_id() : null );
		if ( isset($get_ids) && in_array($get_blog_id.get_the_ID(), explode(',', $get_ids->hide_for_id)) && get_the_ID() > 0 ) { // Hide for specific pages
			return null;
		}

		if ((get_option('bsa_pro_plugin_' . 'hide_if_logged') == 'yes' && is_user_logged_in()) != true && // Hide for logged users
			bsa_pro_verify_geo('show', $show_in_country) && bsa_pro_verify_geo('hide', $hide_in_country) && // Show / Hide in Countries
			bsa_pro_verify_geo('show_advanced', $show_in_advanced) && bsa_pro_verify_geo('hide_advanced', $hide_in_advanced) && // Show / Hide in Regions, Cities, ZipCodes
			bsa_pro_verify_device($space_id) // Verify device
		) {

			// Rand Space ID
			$space_ids = explode(',', $space_id);
			$space_rand_id = array_rand($space_ids, 1);
			$space_id = $space_ids[$space_rand_id];

			// if in category or has tag
			if (bsa_space($space_id, 'id') && bsa_space($space_id, 'in_categories') != '' && bsa_space($space_id, 'in_categories') != null ||
				bsa_space($space_id, 'id') && bsa_space($space_id, 'has_tags') != '' && bsa_space($space_id, 'has_tags') != null
			) {
				$get_categories = bsa_space($space_id, 'in_categories');
				$get_tags = bsa_space($space_id, 'has_tags');
				$exp_categories = explode(',', $get_categories);
				$exp_tags = explode(',', $get_tags);

				$taxonomy_cat = 'empty';
				$taxonomy_tag = 'empty';
				if (is_array($exp_categories)) {
					foreach ($exp_categories as $category) {
						if ( has_term( $category, 'category' ) && !is_category() || is_category(get_cat_name($category)) ) {
							$taxonomy_cat = 'isset';
							break;
						}
					}
				}
				if (is_array($exp_tags)) {
					foreach ($exp_tags as $tag) {
						if (has_term($tag, 'post_tag')) {
							$taxonomy_tag = 'isset';
							break;
						}
					}
				}
				if ($get_categories == '' && $get_categories == null && $get_tags == '' && $get_tags == null ||
					$get_categories == '' && $get_categories == null && $taxonomy_tag == 'isset' ||
					$taxonomy_cat == 'isset' && $get_tags == '' && $get_tags == null ||
					$taxonomy_cat == 'isset' && $taxonomy_tag == 'isset'
				) {
					$taxonomy = 'isset';
				} else {
					$taxonomy = 'empty';
				}
			} else {
				$taxonomy = 'none';
			}

			if (bsa_space($space_id, 'id') && bsa_space($space_id, 'status') == 'active' && $taxonomy == 'isset' ||
				bsa_space($space_id, 'id') && bsa_space($space_id, 'status') == 'active' && $taxonomy == 'none'
			) {

				if (glob(plugin_dir_path(__FILE__) . "../frontend/template/" . bsa_space($space_id, 'template') . ".php") == null) {
					$styleName = 'default';
				} else {
					$styleName = bsa_space($space_id, 'template');
				}

				$sid 		= $space_id;
				$model 		= new BSA_PRO_Model();
				$ads 		= $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.bsaGetCappedAds($sid));
				$type 		= (bsa_space($sid, 'site_id') != NULL) ? 'agency' : null;
				$crop 		= ($crop == 'no' || $crop == 'ajax') ? $crop : null;
				$rel 		= (bsa_get_opt('admin_settings', 'nofollow') == 'yes' ? ' rel="nofollow"' : null);

				if ( defined('W3TC') ): ?>

					<?php if (!defined('W3TC_DYNAMIC_SECURITY')) { define('W3TC_DYNAMIC_SECURITY', md5(rand(0,9999))); } ?>

					<!--mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> $ads -->
					<?php $ads = $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.bsaGetCappedAds($sid)); ?>
					<!--/mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->

				<?php endif;

				$example = null;
				if ( !isset($if_empty) && get_option('bsa_pro_plugin_example_ad') == 'yes' && count($ads) <= 0 ) { // example ads if empty ad space
					$example = true;
				}

				if (count($ads) > 0 || count($ads) == 0 && !isset($if_empty) ) {
					if (isset($sid) && bsa_space($sid, 'display_type') == 'corner') {
						echo '<div class="bsaProCorner bsaProCorner-' . $sid . '">'; // -- START -- CORNER
						echo '
				<div class="bsaProRibbon"></div>
					<div class="bsaProCornerContent">
						<div class="bsaProCornerInner">';
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'floating' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-right' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-right'
					) {
						echo '<div class="bsaProFloating bsaProFloating-' . $sid . '" style="display: none"><div class="bsaFloatingButton"><span class="bsaFloatingClose bsaFloatingClose-' . $sid . '"></span></div>'; // -- START -- FLOATING
					} elseif (isset($sid) && strpos(bsa_space($sid, 'display_type'), 'carousel') !== false) {
						echo '<div class="bsaProCarousel bsaProCarousel-' . $sid . '" style="display:none">'; // -- START -- CAROUSEL
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'top_scroll_bar' || isset($sid) && bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
						echo '<div class="bsaProScrollBar bsaProScrollBar-' . $sid . '">'; // -- START -- TOP / BOTTOM SCROLL BAR
						if (bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
							echo '<div class="bsaProScrollBarButton"><span class="bsaProScrollBarClose bsaProScrollBarClose-' . $sid . '"></span></div>';
						}
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'popup' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup'
					) {
						echo '
					<div class="bsaPopupWrapperBg bsaPopupWrapperBg-' . $sid . ' bsaHidden" style="display:none"></div>

					<div class="bsaPopupWrapper bsaPopupWrapper-' . $sid . ' bsaHidden" style="display:none">

						<div class="bsaPopupWrapperInner">
				'; // -- START -- POPUP, EXIT POPUP
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'layer') {
						echo '
					<div class="bsaPopupWrapperBg bsaPopupWrapperBg-' . $sid . ' bsaHidden"></div>

					<div class="bsaPopupWrapper bsaPopupWrapper-' . $sid . ' bsaHidden">
				'; // -- START -- LAYER
					}

					// -- START -- DEFAULT
					require dirname(__FILE__) . '/../frontend/template/' . $styleName . '.php';
					// -- END -- DEFAULT

					if (isset($sid) && bsa_space($sid, 'display_type') != 'popup' &&
						bsa_space($sid, 'display_type') != 'corner' &&
						bsa_space($sid, 'display_type') != 'layer' &&
						bsa_space($sid, 'display_type') != 'exit_popup' &&
						bsa_space($sid, 'display_type') != 'background' &&
						bsa_space($sid, 'display_type') != 'link') {
						if ( bsaGetCloseActions($sid, 'show_ads') > 0 ): ?>
							<style>
								.bsaProContainer-<?php echo $sid?> {
									display: none;
								}
							</style>
						<?php endif; ?>
						<script>
							(function ($) {
								var bsaProContainer = $('.bsaProContainer-<?php echo $sid?>');
								var number_show_ads = "<?php echo bsaGetCloseActions($sid, 'show_ads') ?>";
								var number_hide_ads = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								if ( number_show_ads > 0 ) {
									setTimeout(function () { bsaProContainer.fadeIn(); }, number_show_ads * 1000);
								}
								if ( number_hide_ads > 0 ) {
									setTimeout(function () { bsaProContainer.fadeOut(); }, number_hide_ads * 1000);
								}
							})(jQuery);
						</script>
					<?php
					}

					if (isset($sid) && bsa_space($sid, 'display_type') == 'background') {
						?>
						<style>
							body {
								background-position: top center !important;
								<?php echo ((bsa_space($sid, 'ads_bg') != null) ? 'background-color: '.bsa_space($sid, 'ads_bg').' !important;' : null) ?>
								background-repeat: no-repeat !important;
								background-attachment: <?php echo ((isset($attachment) && $attachment == 'scroll') ? 'scroll' : 'fixed' ) ?> !important;
								padding-top: <?php echo ((isset($padding_top) && $padding_top != '') ? $padding_top.'px' : 'inherit') ?> !important;
							}
						</style>
						<script>
							(function ($) {
								$(document).ready(function () {
									var body = "body";
									var getImage = $(".bsaProContainer-<?php echo $sid ?> .bsaProItemInner__img").css("background-image");
									var getUrl = $(".bsaProContainer-<?php echo $sid ?> .bsaProItem__url").attr('href');
									$(".bsaProContainer-<?php echo $sid ?>").hide();
									$(body).css("background-image", getImage);
									$(body).click(function (e) {
										var body_target = $(e.target);
										if (body_target.is(body) == true) {
											window.open(getUrl, "_blank");
										}
									});
									$(document).mousemove(function (e) {
										var body_target = $(e.target);
										if (body_target.is(body)) {
											body_target.css("cursor", "pointer");
										} else {
											$(body).css("cursor", "auto");
										}
									});
								});
							})(jQuery);
						</script>
					<?php
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'corner') {
						echo '
						</div>
					</div>
				</div>'; // -- END -- CORNER
						?>
						<script>
							(function ($) {
								var body = $(document);
								$(window).scroll(function () {
									if ($(window).scrollTop() >= (body.height() - (body.height() - (body.height() * (<?php echo (($delay != 0 && $delay != NULL) ? $delay : $delay) / 100 ?>)))) - $(window).height()) {
										setTimeout(function () {
											<?php if ( bsaGetCloseActions($sid, 'show_ads') == 0 ): ?>
											$(".bsaProCorner-<?php echo $sid ?>").fadeIn();
											<?php endif; ?>
										}, 400);
									}
								});
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_ads') ?>";
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								if ( number_show > 0 ) {
									setTimeout(function () { bsaProCorner.fadeIn(400); }, number_show * 1000);
								}
								if ( number_close > 0 ) {
									setTimeout(function () { bsaProCorner.fadeOut(400); }, number_close * 1000);
								}
								var bsaProCorner = $(".bsaProCorner-<?php echo $sid ?>");
								bsaProCorner.appendTo(document.body);
							})(jQuery);
						</script>
						<style>
							.bsaProCorner-<?php echo $sid ?> {
								display: <?php echo (bsaGetCloseActions($sid, 'show_ads') > 0) ? 'none' : 'block' ?>;
								position: fixed;
								width: 150px;
								height: 150px;
								z-index: 10000;
								top: <?php echo (( is_user_logged_in() ) ? '32px' : '0') ?>;
								right: 0;
								-webkit-transition: all .5s; /* Safari */
								transition: all .5s;
							}
							.bsaProCorner:hover {
								width: 250px;
								height: 250px;
							}
						</style>
					<?php
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'floating' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-right' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-right'
					) {
						echo '</div>'; // -- END -- FLOATING
						?>
						<script>
							(function ($) {
								var body = $(document);
								$(window).scroll(function () {
									if ($(window).scrollTop() >= (body.height() - (body.height() - (body.height() * (<?php echo (($delay != 0 && $delay != NULL) ? $delay : $delay) / 100 ?>)))) - $(window).height()) {
										setTimeout(function () {
											$(".bsaProFloating-<?php echo $sid ?>").fadeIn();
										}, 400);
									}
								});
								var bsaProFloating = $(".bsaProFloating-<?php echo $sid ?>");
								var bsaFloatingClose = $(".bsaFloatingClose-<?php echo $sid ?>");
								bsaProFloating.appendTo(document.body);
								bsaFloatingClose.click(function () {
									setTimeout(function () {
										bsaProFloating.removeClass("zoomInDown").addClass("animated zoomOutUp");
									}, 400);
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () { bsaProFloating.fadeOut(400); }, number_close * 1000);
									setTimeout(function () { bsaProFloating.remove(); }, (number_close * 1000) + 400);
								}
								if ( number_show > 0 ) {
									if ( number_show == 1000 ) {
										bsaFloatingClose.remove();
									} else {
										bsaFloatingClose.hide();
										setTimeout(function () {
											bsaFloatingClose.fadeIn();
										}, number_show * 1000);
									}
								}
							})(jQuery);
						</script>
						<style>
							.bsaProFloating-<?php echo $sid ?> {
								position: fixed;
								max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width : '320') ?>px;
								width: 90%;
								z-index: 10000;
							<?php if ( bsa_space($sid, 'display_type') == 'floating-top-left' ) {
									echo '
										top: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										left: 15px;
									';
								} elseif ( bsa_space($sid, 'display_type') == 'floating-top-right' ) {
									echo '
										top: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										right: 15px;
									';
								} elseif ( bsa_space($sid, 'display_type') == 'floating-bottom-left' ) {
									echo '
										bottom: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										left: 15px;
									';
								} else {
									echo '
										bottom: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										right: 15px;
									';
								}
							?>
							}

							<?php if ( bsa_space($sid, 'display_type') == 'floating-top-left' || bsa_space($sid, 'display_type') == 'floating-bottom-left' ) {
									echo '
										.bsaProFloating-'.$sid.' .bsaFloatingButton {
											float: left;
										}
									';
								}
							?>
						</style>
					<?php
					} elseif (isset($sid) && strpos(bsa_space($sid, 'display_type'), 'carousel') !== false) {
					echo '</div>'; // -- END -- CAROUSEL
					?>
					<script>
						(function ($) {
							function bsaOwlCarousel() {
								var owl = $(".bsa-owl-carousel-<?php echo $sid; ?>");
								owl.owlCarousel({
									autoPlay: <?php echo (($delay != 0 && $delay != NULL) ? $delay : 5) * 1000 ?>,
									autoWidth: true,
									slideSpeed: 400,
									paginationSpeed: 700,
									rewindSpeed: 1000,
									singleItem : true,
									<?php echo ((bsa_space($sid, 'display_type') == 'carousel_fade') ? 'transitionStyle : "bsaFade",' : null) ?>
									nav: false,
									dots: false
								});
							}
							$(document).ready(function () {
								setTimeout(function () {
									var owlCarousel = $(".bsaProCarousel-<?php echo $sid; ?>");
									var crop = "<?php echo $crop; ?>";
									var ajax = $('.bsa_pro_ajax_load-<?php echo $sid; ?>');
									if ( crop == "ajax" ) {
										if ( ajax.children.length > 0 ) {
											owlCarousel.fadeIn();
											bsaOwlCarousel();
											setTimeout(function () {
												ajax.fadeIn();
											}, 100);
										}
									} else {
										bsaOwlCarousel();
										owlCarousel.fadeIn();
									}
								}, 700);
							});
						})(jQuery);
					</script>
					<style>
						.bsaProCarousel-<?php echo $sid?> {
							max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width : '728') ?>px;
							width: 100%;
							overflow: hidden;
						}
					</style>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'top_scroll_bar' || isset($sid) && bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
					if (bsa_space($sid, 'display_type') == 'top_scroll_bar') {
						echo '<div class="bsaProScrollBarButton"><span class="bsaProScrollBarClose bsaProScrollBarClose-' . $sid . '"></span></div>';
					}
					echo '</div>'; // -- END -- TOP / BOTTOM SCROLL BAR
					?>
					<script>
						(function ($) {
							$(document).ready(function () {
								var bsaScrollBarWrapper = $('.bsaProScrollBar-<?php echo $sid?>');
								var bsaScrollBarInner = $('.bsaProScrollBar-<?php echo $sid?> .bsaProContainer-<?php echo $sid?> .bsaProItems');
								var bsaScrollBarClose = $(".bsaProScrollBarClose-<?php echo $sid ?>");
								bsaScrollBarWrapper.appendTo(document.body);
								bsaScrollBarInner.simplyScroll({
									speed: 2
								});
								bsaScrollBarClose.click(function () {
									setTimeout(function () {
										bsaScrollBarWrapper.removeClass("zoomInDown").addClass("animated zoomOutUp");
									}, 400);
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () { bsaScrollBarWrapper.fadeOut(400); }, number_close * 1000);
									setTimeout(function () { bsaScrollBarWrapper.remove(); }, (number_close * 1000) + 400);
								}
								if ( number_show > 0 ) {
									if ( number_show == 1000 ) {
										bsaScrollBarClose.remove();
									} else {
										bsaScrollBarClose.hide();
										setTimeout(function () {
											bsaScrollBarClose.fadeIn();
										}, number_show * 1000);
									}
								}
							});
						})(jQuery);
					</script>
					<style>
						.bsaProScrollBar-<?php echo $sid?> {
							width: 100%;
							position: fixed;
						<?php if ( bsa_space($sid, 'display_type') == 'top_scroll_bar' ): ?> top: <?php echo (( is_user_logged_in() ) ? '32px' : '0') ?>;
						<?php else: ?> bottom: 0;
						<?php endif; ?> left: 0;
							z-index: 10000;
						}
						.bsaProScrollBar-<?php echo $sid?> .bsaProItem {
							margin: 0 !important;
						}
						.bsaProScrollBar-<?php echo $sid?>, .bsaProScrollBar-<?php echo $sid?> .bsaProItems, .bsaProScrollBar-<?php echo $sid?> .bsaProContainer .bsaProItem.bsaReset {
							clear: none;
						}
						/* Explicitly set height/width of each list item */
						.simply-scroll .simply-scroll-list .bsaProItem {
							float: left; /* Horizontal scroll only */
							width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : 1920 / bsa_space($sid, 'col_per_row')).'px' ?> !important;
							height: auto;
						}
					</style>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'popup') {
					echo '</div><span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- POPUP
					?>
					<script>
						(function ($) {
							var ads = "<?php echo count($ads); ?>";
							if ( ads > 0 ) {
								var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid?>");
								var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid?>");
								var bsaBody = $("body");
								if (bsaPopupWrapper.hasClass('bsaClosed') == false) {
									setTimeout(function () {
										bsaBody.css({
											"overflow": "hidden",
											"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
										});
										bsaPopupWrapper.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
										bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
									}, <?php echo bsaGetCloseActions($sid, 'show_ads') * 1000 ?>);
								}
								$(document).ready(function () {
									var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
									bsaPopupClose.click(function () {
										bsaBody.css({"overflow": "visible", "height": "auto"});
										bsaPopupClose.addClass("animated zoomOut");
										bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut bsaClosed").fadeOut();
										bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
									});
									var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
									var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
									if ( number_close > 0 ) {
										bsaPopupWrapperBg.removeClass('animated');
										bsaPopupWrapper.removeClass('animated');
										setTimeout(function () {
											bsaPopupWrapperBg.fadeOut();
											bsaPopupWrapper.fadeOut();
										}, number_close * 1000);
									}
									if ( number_show > 0 ) {
										if ( number_show == 1000 ) {
											bsaPopupClose.remove();
										} else {
											bsaPopupClose.hide();
											setTimeout(function () {
												bsaPopupClose.fadeIn();
											}, number_show * 1000);
										}
									}
								});
							}
						})(jQuery);
					</script>
					<?php if (bsa_option_exists($sid, 'spaces', 'ad_extra_color_1') || $max_width != ''): ?>
						<style>
							<?php if ($max_width != ''): ?>
							.bsaPopupWrapper-<?php echo $sid ?> .bsaProContainer {
								max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : '100%') ?> !important;
								margin: 0 auto;
							}
							<?php endif; ?>
							<?php if (bsa_option_exists($sid, 'spaces', 'ad_extra_color_1')): ?>
							.bsaPopupWrapper-<?php echo $sid ?> {
								background-color: <?php echo bsa_space($sid, 'ad_extra_color_1')?>;
							}
							<?php endif; ?>
						</style>
					<?php endif; ?>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'layer') {
					echo '<span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- LAYER
					?>
					<script>
						(function ($) {
							var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid ?>");
							var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid ?>");
							var bsaBody = $("body");
							setTimeout(function () {
								var getImage = $(".bsaProContainer-<?php echo $sid ?> .bsaProItemInner__img").css("background-image");
								$(".bsaProContainer-<?php echo $sid ?>").hide();
								bsaBody.css({
									"overflow": "hidden",
									"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
								});
								bsaPopupWrapper.css("background-image", getImage).appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
								bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
							}, <?php echo bsaGetCloseActions($sid, 'show_ads') * 1000 ?>);
							$(document).ready(function () {
								var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
								bsaPopupClose.click(function () {
									bsaBody.css({"overflow": "visible", "height": "auto"});
									bsaPopupClose.addClass("animated zoomOut");
									bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
									bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
								});
								var getUrl = $(".bsaProContainer-<?php echo $sid ?> .bsaProItem__url").attr('href');
								$(bsaPopupWrapper).click(function (e) {
									var layer_target = $(e.target);
									if (layer_target.is(bsaPopupWrapper) == true) {
										window.open(getUrl, "_blank");
									}
								});
								$(document).mousemove(function (e) {
									var layer_target = $(e.target);
									if (layer_target.is(bsaPopupWrapper)) {
										layer_target.css("cursor", "pointer");
									} else {
										$(bsaPopupWrapper).css("cursor", "auto");
									}
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () {
										bsaPopupWrapperBg.fadeOut(400);
										bsaPopupWrapper.fadeOut(400);
										setTimeout(function () { bsaPopupWrapperBg.remove(); bsaPopupWrapper.remove(); }, 400);
									}, number_close * 1000);
								}
								if ( number_show > 0 ) {
									if ( number_show == 1000 ) {
										bsaPopupClose.remove();
									} else {
										bsaPopupClose.hide();
										setTimeout(function () {
											bsaPopupClose.fadeIn();
										}, number_show * 1000);
									}
								}
							});
						})(jQuery);
					</script>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup') {
					echo '</div><span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- EXIT POPUP
					?>
					<script>
						(function ($) {
							var ads = "<?php echo count($ads); ?>";
							if ( ads > 0 ) {
								var isDesktop = (function () {
									return !('ontouchstart' in window) || !('onmsgesturechange' in window);
								})();
								window.isDesktop = isDesktop;
								if (isDesktop) {
									var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid ?>");
									var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid ?>");
									var bsaBody = $("body");
									$(document).ready(function () {
										var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
										bsaPopupClose.click(function () {
											bsaBody.css({"overflow": "visible", "height": "auto"});
											bsaPopupClose.addClass("animated zoomOut");
											bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
											bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
										});
									});
									$(document).bind("mouseleave", function () {
										if (bsaPopupWrapper.hasClass('fadeIn') == false && bsaPopupWrapper.hasClass('bsaClosed') == false) {
											bsaBody.css({
												"overflow": "hidden",
												"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
											});
											bsaPopupWrapper.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn bsaClosed").fadeIn();
											bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
										}
									});
								}
							}
						})(jQuery);
					</script>
					<style>
						.bsaPopupWrapper-<?php echo $sid ?> .bsaProContainer {
							max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : '100%') ?>;
							margin: 0 auto;
						}
						.bsaPopupWrapper-<?php echo $sid ?> {
							background-color: <?php echo bsa_space($sid, 'ad_extra_color_1')?>;
						}
					</style>
				<?php
				}
			}
		} else {
				return null;
		}
	}
}
	return null;
}

function bsaProSpaceCss($sid, $type, $param = null) {
	echo '<style>';
	if ( isset($sid) && isset($type) && $type == 'vertical' ) {
//		echo '.bsaProContainer-'.$sid.' .bsaProItem:nth-child('.$param['items'].'n+1) {';
		echo '
		.bsaProContainer-'.$sid.' .bsaProItem {
			clear: both;
			width: 100% !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		';
	}
	echo '</style>';
}

function bsaProResize($sid, $width, $height) {
	if ( isset($sid) && isset($width) && isset($height) && bsa_space($sid, "display_type") != 'corner' || !isset($sid) ) {
		echo '<script>
			(function($){
				function bsaProResize() {
					var sid = "'.$sid.'";
					var object = $(".bsaProContainer-" + sid + " .bsaProItemInner__img");
					var animateThumb = $(".bsaProContainer-" + sid + " .bsaProAnimateThumb");
					var innerThumb = $(".bsaProContainer-" + sid + " .bsaProItemInner__thumb");
					var parentWidth = "'.$width.'";
					var parentHeight = "'.$height.'";
					var objectWidth = object.width();
					if ( objectWidth < parentWidth ) {
						var scale = objectWidth / parentWidth;
						if ( objectWidth > 0 && objectWidth != 100 && scale > 0 ) {
							animateThumb.height(parentHeight * scale);
							innerThumb.height(parentHeight * scale);
							object.height(parentHeight * scale);
						} else {
							animateThumb.height(parentHeight);
							innerThumb.height(parentHeight);
							object.height(parentHeight);
						}
					} else {
						animateThumb.height(parentHeight);
						innerThumb.height(parentHeight);
						object.height(parentHeight);
					}
				}
				$(document).ready(function(){
					bsaProResize();
					$(window).resize(function(){
						bsaProResize();
					});
				});
			})(jQuery);
		</script>';
	}
}

function bsaProCountdown ( $sid, $aid, $ad_limit, $ad_model )
{
	if ( $sid != null && bsa_get_opt('other', 'countdown') == 'yes' ) {
		if ( $ad_model == 'cpd' ) {
			$randCounter = rand(1,1000);
			?>
			<div id="bsaCountdown-<?php echo $randCounter.$sid.$aid ?>" class="bsaCountdown">
				<span class="days"></span>
				<span class="hours"></span>
				<span class="minutes"></span>
				<span class="seconds"></span>
			</div>
			<script>
				function getCurrTime(endtime) {
					var t = Date.parse(endtime) - Date.parse(new Date());
					var seconds = Math.floor((t / 1000) % 60);
					var minutes = Math.floor((t / 1000 / 60) % 60);
					var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
					var days = Math.floor(t / (1000 * 60 * 60 * 24));
					return {
						'total': t,
						'days': days,
						'hours': hours,
						'minutes': minutes,
						'seconds': seconds
					};
				}

				function initClock(id, endtime) {
					var clock = document.getElementById(id);
					var daysSpan = clock.querySelector('.days');
					var hoursSpan = clock.querySelector('.hours');
					var minutesSpan = clock.querySelector('.minutes');
					var secondsSpan = clock.querySelector('.seconds');

					function updClock() {
						var t = getCurrTime(endtime);

						daysSpan.innerHTML = t.days + ' d';
						hoursSpan.innerHTML = ('0' + t.hours).slice(-2) + ' h';
						minutesSpan.innerHTML = ('0' + t.minutes).slice(-2) + ' m';
						secondsSpan.innerHTML = ('0' + t.seconds).slice(-2) + ' s';

						if (t.total <= 0) {
							clearInterval(timeinterval);
						}
					}

					updClock();
					var timeinterval = setInterval(updClock, 1000);
				}

				var deadline = new Date(<?php echo $ad_limit * 1000 ?>);
				initClock('bsaCountdown-<?php echo $randCounter.$sid.$aid ?>', deadline);
			</script>
		<?php
		} else {
			?>
			<div class="bsaCountdown">
				<?php if ($ad_model == 'cpc'): ?>
				<span class="clicks"><?php echo $ad_limit ?> clicks</span>
				<?php else: ?>
				<span class="views"><?php echo $ad_limit ?> views</span>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}

function bsa_upload_url($type = 'baseurl')
{
	if ( is_multisite() ) {
		$upload_basedir = get_site_option('bsa_pro_plugin_main_basedir');
		$upload_baseurl = get_site_option('bsa_pro_plugin_main_baseurl');
	} else {
		$upload_dir = wp_upload_dir();
		$upload_basedir = $upload_dir['basedir'];
		$upload_baseurl = $upload_dir['baseurl'];
	}
	if ( $type == 'basedir' )
		$upload_path = $upload_basedir.'/bsa-pro-upload/';
	else
		$upload_path = $upload_baseurl.'/bsa-pro-upload/';

	if( ! file_exists( $upload_path ) )
		wp_mkdir_p( $upload_path );

	if ( is_ssl() )
		$upload_path = str_replace( 'http://', 'https://', $upload_path );

	return $upload_path;
}

add_shortcode( 'bsa_pro_ad_space', 'create_bsa_pro_short_code_space' );
function create_bsa_pro_short_code_space( $atts, $content = null )
{
	$a = shortcode_atts( array(
		'id' 				=> $atts['id'],
		'max_width' 		=> ( isset($atts['max_width']) ) ? $atts['max_width'] : '',
		'delay' 			=> ( isset($atts['delay']) ) ? $atts['delay'] : '',
		'padding_top' 		=> ( isset($atts['padding_top']) ) ? $atts['padding_top'] : '',
		'attachment' 		=> ( isset($atts['attachment']) ) ? $atts['attachment'] : '',
		'crop' 				=> ( isset($atts['crop']) ) ? $atts['crop'] : '',
		'if_empty' 			=> ( isset($atts['if_empty']) ) ? $atts['if_empty'] : null,
		'custom_image' 		=> ( isset($atts['custom_image']) ) ? $atts['custom_image'] : null,
	), $atts );

	ob_start();
	// Rand Space ID
	$space_ids = explode(',', $a['id']);
	$space_rand_id = array_rand($space_ids, 1);
	$a['id'] = $space_ids[$space_rand_id];

	if ( get_option('bsa_pro_plugin_'.'hide_if_logged') != 'yes' && is_user_logged_in() || !is_user_logged_in() ) { // Hide for logged users
		if ($content != null && bsa_space($a['id'], 'display_type') == 'link') {
			?>
			<style>
				.bsaProLink-<?php echo $a['id'] ?> .bsaProLinkHover-<?php echo $a['id'] ?> {
					left: 0;
					width: <?php echo $a['max_width'].'px' ?>;
				}
			</style>
			<?php
			echo '<div class="bsaProLink bsaProLink-' . $a['id'] . '">' . $content . '<div class="bsaProLinkHover bsaProLinkHover-' . $a['id'] . '">';
		}

		if ( $a['if_empty'] != null or $a['if_empty'] != '' ) {
			$model 	= new BSA_PRO_Model();
			$ads 	= $model->getActiveAds($a['id'], bsa_space($a['id'], 'max_items'), null, '0'.bsaGetCappedAds($a['id']));

			// the main ad space
			if ( bsa_space($a['id']) != null && bsa_space($a['id'], 'status') == 'active' && count($ads) > 0 ) {
				echo bsa_pro_ad_space($a['id'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop'], $a['if_empty'], $a['custom_image']);
			} else {
				// if the main ad space is empty
				echo bsa_pro_ad_space($a['if_empty'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop']);
			}
		} else {
			// the main ad space
			if ( bsa_space($a['id']) != null )
				echo bsa_pro_ad_space($a['id'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop'], $a['if_empty'], $a['custom_image']);
		}

		if ($content != null && bsa_space($a['id'], 'display_type') == 'link') {
			echo '</div></div>';
		}
	}
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_ajax_ad_space', 'create_bsa_pro_ajax_short_code_space' );
function create_bsa_pro_ajax_short_code_space( $atts, $content = null )
{
	$a = shortcode_atts( array(
		'id' 			=> $atts['id'],
		'max_width' 	=> ( isset($atts['max_width']) && $atts['max_width'] != '' ) ? $atts['max_width'] : null,
		'delay' 		=> ( isset($atts['delay']) && $atts['delay'] != '' ) ? $atts['delay'] : null,
		'padding_top' 	=> ( isset($atts['padding_top']) && $atts['padding_top'] != '' ) ? $atts['padding_top'] : null,
		'attachment' 	=> ( isset($atts['attachment']) && $atts['attachment'] != '' ) ? $atts['attachment'] : null
	), $atts );

	$advanced_opt = json_decode(bsa_space($a["id"], 'advanced_opt'));
	$get_blog_id = ( get_current_blog_id() >= 1 ? get_current_blog_id() : 0 );

	ob_start();
	echo '<div class="bsa_pro_ajax_load bsa_pro_ajax_load-'.$a["id"].'" style="display:'.(strpos(bsa_space($a['id'], 'display_type'), 'carousel') !== false ? 'none' : 'block').'">';

	echo '</div>';
	echo '
	<script>
	(function($) {
		$.post("'.admin_url("admin-ajax.php").'", {
			action:"bsa_pro_ajax_load_ad_space",
			pid:"'.$get_blog_id.get_the_ID().'",
			id:"'.$a["id"].'",
			max_width:"'.$a["max_width"].'",
			delay:"'.$a["delay"].'",
			padding_top:"'.$a["padding_top"].'",
			attachment:"'.$a["attachment"].'",
			hide_for_id:"'.$advanced_opt->hide_for_id.'"
		}, function(result) {
			$(".bsa_pro_ajax_load-"+"'.$a["id"].'").html(result);
		});
	})(jQuery);
	</script>
	';
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_form_and_stats', 'create_bsa_pro_short_code_form_and_stats' );
function create_bsa_pro_short_code_form_and_stats()
{
	ob_start();
	if ( isset($_GET['bsa_pro_stats']) && isset($_GET['bsa_pro_id']) && isset($_GET['bsa_pro_email']) && bsa_ad($_GET['bsa_pro_id'], 'buyer_email') == $_GET['bsa_pro_email'] ) {
		require dirname(__FILE__) . '/BSA_PRO_Stats.php';
	} else {
		require dirname(__FILE__) . '/BSA_PRO_Ordering_form.php';
	}
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_agency_form', 'create_bsa_pro_short_code_agency_form' );
function create_bsa_pro_short_code_agency_form()
{
	ob_start();
	if ( isset($_GET['bsa_pro_stats']) && isset($_GET['bsa_pro_id']) && isset($_GET['bsa_pro_email']) && bsa_ad($_GET['bsa_pro_id'], 'buyer_email') == $_GET['bsa_pro_email'] ) {
		require dirname(__FILE__) . '/BSA_PRO_Agency_Stats.php';
	} else {
		require dirname(__FILE__) . '/BSA_PRO_Agency_Ordering_form.php';
	}
	return ob_get_clean();
}

add_action( 'wp', 'bsa_pro_wp_redirect' );
function bsa_pro_wp_redirect() {
	if ( isset( $_GET['bsa_pro_url'] ) && isset( $_GET['bsa_pro_id'] ) ) {
		$model = new BSA_PRO_Model();
		wp_redirect( $model->bsaProCounter() );
		exit;
	}
}

add_action( 'vc_before_init', 'ads_pro_plugin_ad_space' );
function ads_pro_plugin_ad_space() {
	vc_map( array(
		"name" => __( "ADS PRO", "my-text-domain" ),
		"base" => "ads_pro_ad_space",
		"class" => "",
		"icon" => plugins_url('../frontend/img/small-logo.png', __FILE__),
		"category" => __( "Content", "my-text-domain"),
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Space ID", "my-text-domain" ),
				"param_name" => "id",
				"value" => __( "1", "my-text-domain" ),
				"description" => __( "Enter Space ID here.", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Max width", "my-text-domain" ),
				"param_name" => "max_width",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Max width of ad space in pixels, eg. 468", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Delay", "my-text-domain" ),
				"param_name" => "delay",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Param in seconds for a popup & slider ads, eg. 3", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Padding top", "my-text-domain" ),
				"param_name" => "padding_top",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Param in pixels for a background ads, eg. 100", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Attachment", "my-text-domain" ),
				"param_name" => "attachment",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Param for a background ads, eg. scroll or fixed", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Crop", "my-text-domain" ),
				"param_name" => "crop",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "If you do not want to use cropping for images, enter 'no'", "my-text-domain" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Show other Ad Space if empty", "my-text-domain" ),
				"param_name" => "if_empty",
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Show other Ad Space if empty e.g. 2", "my-text-domain" )
			),
			array(
				"type" => "textarea",
				"holder" => "",
				"class" => "",
				"heading" => __( "Content", "my-text-domain" ),
				"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
				"value" => __( NULL, "my-text-domain" ),
				"description" => __( "Enter your content.", "my-text-domain" )
			)
		)
	) );
}

add_shortcode( 'ads_pro_ad_space', 'ads_pro_ad_space_function' );
function ads_pro_ad_space_function( $atts, $content = null )
{
	extract( shortcode_atts( array(
		'id' 				=> $atts['id'],
		'max_width' 		=> ( isset($atts['max_width']) ) ? $atts['max_width'] : null,
		'delay' 			=> ( isset($atts['delay']) ) ? $atts['delay'] : null,
		'padding_top' 		=> ( isset($atts['padding_top']) ) ? $atts['padding_top'] : null,
		'attachment' 		=> ( isset($atts['attachment']) ) ? $atts['attachment'] : null,
		'crop' 				=> ( isset($atts['crop']) ) ? $atts['crop'] : null,
		'if_empty' 			=> ( isset($atts['if_empty']) ) ? $atts['if_empty'] : null,
	), $atts ) );

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	$id 				= "{$id}";
	$max_width 			= "{$max_width}";
	$delay 				= "{$delay}";
	$padding_top 		= "{$padding_top}";
	$attachment 		= "{$attachment}";
	$crop 				= "{$crop}";
	$if_empty 			= "{$if_empty}";

	ob_start();
	if ( get_option('bsa_pro_plugin_'.'hide_if_logged') != 'yes' && is_user_logged_in() || !is_user_logged_in() ) { // Hide for logged users
		if ( $content != null && bsa_space($id, 'display_type') == 'link' ) {
			?>
			<style>
				.bsaProLink-<?php echo $id ?> .bsaProLinkHover-<?php echo $id ?> {
					left: 0;
					width: <?php echo $max_width.'px' ?>;
				}
			</style>
			<?php
			echo '<div class="bsaProLink bsaProLink-'.$id.'">'.$content.'<div class="bsaProLinkHover bsaProLinkHover-'.$id.'">';
		}

		if ( $if_empty != null or $if_empty != '' ) {
			$model 	= new BSA_PRO_Model();
			$ads 	= $model->getActiveAds($id, bsa_space($id, 'max_items'), null, '0'.bsaGetCappedAds($id));

			// the main ad space
			if ( bsa_space($id) != null && bsa_space($id, 'status') == 'active' && count($ads) > 0 ) {
				bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty);
			} else {
				// if the main ad space is empty
				bsa_pro_ad_space($if_empty, $max_width, $delay, $padding_top, $attachment, $crop);
			}
		} else {
			// the main ad space
			if ( bsa_space($id) != null )
				bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty);
		}

		if ( $content != null && bsa_space($id, 'display_type') == 'link' ) {
			echo '</div></div>';
		}
	}
	return ob_get_clean();
}

// AdBlock Detection Shortcode
add_shortcode( 'bsa_pro_adblock_notice', 'bsa_pro_adblock_notice_function' );
function bsa_pro_adblock_notice_function( $atts )
{
	extract( shortcode_atts( array(
		'message' 	=> (isset($atts['message']) ? $atts['message'] : '<h3>Page blocked!</h3><p>Please disable <strong>AdBlocker</strong> to view this page.</p>'),
	), $atts ) );

	$message 		= "{$message}";

	ob_start();
	echo "
<div class='bsaBlurWrapper' style='display:none'>
	<div class='bsaBlurInner'>
		<div class='bsaBlurInnerContent'>
			".$message."
		</div>
	</div>
</div>
<div class='afs_ads'>&nbsp;</div>
<script>
(function ($) {
    var message = '{$message}';
	// Define a function for showing the message.
	// Set a timeout of 2 seconds to give adblocker
	// a chance to do its thing
	var tryMessage = function() {
		setTimeout(function() {
			if(!document.getElementsByClassName) return;
			var ads = document.getElementsByClassName('afs_ads'),
				ad  = ads[ads.length - 1];
			if(!ad
				|| ad.innerHTML.length == 0
				|| ad.clientHeight === 0) {
				$('body').addClass('bsaBlurContent');
				$('.bsaBlurWrapper').appendTo('body').fadeIn();
				//window.location.href = '[URL of the donate page. Remove the two slashes at the start of thsi line to enable.]';
			} else {
				ad.style.display = 'none';
			}
		}, 2000);
	};
	/* Attach a listener for page load ... then show the message */
	if(window.addEventListener) {
		window.addEventListener('load', tryMessage, false);
	} else {
		window.attachEvent('onload', tryMessage); //IE
	}
})(jQuery);
</script>
	";
	return ob_get_clean();
}

// user panel shortcode
add_shortcode( 'bsa_pro_user_panel', 'create_bsa_pro_user_panel' );
function create_bsa_pro_user_panel()
{
	if (get_option('bsa_pro_plugin_symbol_position') == 'before') {
		$before = get_option('bsa_pro_plugin_currency_symbol');
	} else {
		$before = '';
	}
	if (get_option('bsa_pro_plugin_symbol_position') != 'before') {
		$after = get_option('bsa_pro_plugin_currency_symbol');
	} else {
		$after = '';
	}
	$user_info = get_userdata(1);
	$model 			= new BSA_PRO_Model();
	$getUserAds 	= $model->getUserAds(get_current_user_id(), 'all', $user_info->user_email);
	ob_start();
	echo '<div class="bsaProPanelContainer">'; // start container ?>
	<table id="bsaProPanelTable">
		<thead>
			<tr>
				<th class="bsaProFirst"><?php echo bsa_get_trans('user_panel', 'ad_content'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'buyer'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'stats'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'display_limit'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'order_details'); ?></th>
				<th class="bsaProLast"><?php echo bsa_get_trans('user_panel', 'actions'); ?></th>
			</tr>
		</thead>
		<tbody style="background-color: <?php echo bsa_get_opt('user_panel', 'body_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', 'body_color'); ?>;">
		<?php if ( count($getUserAds) > 0 && is_user_logged_in() ): ?>
			<?php foreach ( $getUserAds as $key => $entry ): ?>
				<tr>
					<td class="bsaProFirst">
						<img src="<?php echo bsa_crop_tool('yes', ( $entry['img'] != '' ) ? bsa_upload_url().$entry['img'] : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'), 50, 50 ); ?>" />
						<div class="bsaProContent">
							<?php echo ( $entry['title'] != '' ) ? "<strong>".$entry['title']."</strong><br>" : ""; ?>
							<?php echo ( $entry['description'] != '' ) ? $entry['description']."<br>" : ""; ?>
							<a href="<?php echo $entry['url']; ?>" target="_blank"><?php echo $entry['url']; ?></a>
						</div>
					</td>
					<td><?php echo $entry['buyer_email']; ?></td>
					<td class="bsaNoWrap">
						<?php
						$views = bsa_counter($entry['id'], 'view');
						$clicks = bsa_counter($entry['id'], 'click'); ?>
						<?php echo bsa_get_trans('user_panel', 'views'); ?> <strong><?php echo ( $views != NULL ) ? $views : 0; ?></strong><br>
						<?php echo bsa_get_trans('user_panel', 'clicks'); ?> <strong><?php echo ( $clicks != NULL ) ? $clicks : 0; ?></strong><br>
						<?php if ( $views != NULL && $clicks != NULL ): ?>
							<?php echo bsa_get_trans('user_panel', 'ctr'); ?> <strong><?php echo number_format(($clicks / $views) * 100, 2, '.', '').'%'; ?></strong><br>
						<?php endif; ?>
						<a target="_blank" href="<?php echo get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') ?>bsa_pro_stats=1&bsa_pro_email=<?php echo str_replace('@', '%40', $entry['buyer_email']); ?>&bsa_pro_id=<?php echo $entry['id']; ?>">
							<?php echo bsa_get_trans('user_panel', 'full_stats'); ?>
						</a>
					</td>
					<td>
						<?php
						if ( $entry['ad_model'] == 'cpd' ) {
							$time = time();
							$limit = $entry['ad_limit'];
							$diff = $limit - $time;
							$ad_limit = $diff;
							$limit_value = ( $diff < 86400 /* 1 day in sec */ ) ? ( $diff > 0 ) ? '0 '.strtolower(bsa_get_trans('user_panel', 'days')) : '0 '.strtolower(bsa_get_trans('user_panel', 'days')) : number_format($diff / 24 / 60 / 60).' '.strtolower(bsa_get_trans('user_panel', 'days'));
							$diffTime = date('d M Y (H:m:s)', time() + $diff);
						} else {
							$ad_limit = $entry['ad_limit'];
							$limit_value = ($entry['ad_model'] == 'cpc') ? $entry['ad_limit'].' '.strtolower(bsa_get_trans('user_panel', 'clicks')) : $entry['ad_limit'].' '.strtolower(bsa_get_trans('user_panel', 'views'));
							$diffTime = '';
						}
						?>
						<strong><?php echo $limit_value; ?></strong><br>
						<?php echo ( $entry['ad_model'] == 'cpd' ) ? $diffTime : ''; ?>
					</td>
					<td class="bsaNoWrap">
						<?php $billing_model = bsa_get_trans('user_panel', $entry['ad_model']); ?>
						<?php echo bsa_get_trans('user_panel', 'billing_model'); ?> <strong><?php echo $billing_model; ?></strong><br>
						<?php echo bsa_get_trans('user_panel', 'cost'); ?> <strong><?php echo $before.$entry['cost'].$after; ?></strong>
						<?php if ( $entry['paid'] == 1 ): ?>
							(<?php echo bsa_get_trans('user_panel', 'paid'); ?>)
						<?php elseif ( $entry['paid'] == 2 || $entry['cost'] == 0 ): ?>
							(<?php echo bsa_get_trans('user_panel', 'free'); ?>)
						<?php else: ?>
							(<?php echo bsa_get_trans('user_panel', 'not_paid'); ?>)
						<?php endif; ?><br>
						<?php
						if ( $entry['status'] == 'pending' && $ad_limit > 0 ) {
							$status = array("pending", bsa_get_trans('user_panel', 'pending'));
						} else if ( $entry['status'] == 'active' && $ad_limit > 0 ) {
							$status = array("active", bsa_get_trans('user_panel', 'active'));
						} else {
							$status = array("expired", bsa_get_trans('user_panel', 'expired'));
						}
						?>
						<?php echo bsa_get_trans('user_panel', 'status'); ?>
						<span class="bsaProPanelStatus <?php echo $status[0]; ?>" style="background-color: <?php echo bsa_get_opt('user_panel', $status[0].'_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', $status[0].'_color'); ?>;">
							<?php echo $status[1]; ?>
						</span>
					</td>
					<td class="bsaProLast bsaNoWrap">
						<?php
						if ( bsa_space($entry['space_id'], 'space_id') > 0 ) {
							$form_type = (bsa_space($entry['space_id'], 'site_id') != NULL) ? 'agency' : null;
							if ( isset($form_type) ) { // generate form url
								$form_url = bsaFormURL($entry['space_id'], $form_type); // get agency form url
							} else {
								$form_url = bsaFormURL($entry['space_id']); // get order form url
							}
						} else {
							$form_url = bsaFormURL();
						}

						if ( $status[0] == 'pending' ): ?>
							<?php if ( $entry['paid'] != 1 && $entry['paid'] != 2 ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id']; ?>">
									<?php echo bsa_get_trans('user_panel', 'pay_now'); ?></a><br>
							<?php endif; ?>
						<?php elseif ( $status[0] == 'active' ): ?>
							<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-add-new-ad&ad_id=<?php echo $entry['id']; ?>" target="_blank">
								<?php echo bsa_get_trans('user_panel', 'edit'); ?></a>
						<?php elseif ( $status[0] == 'expired' ): ?>
							<?php if ( $entry['ad_model'] == 'cpm' ):
								$type = bsa_get_trans('user_panel', 'views');
							elseif ( $entry['ad_model'] == 'cpc' ):
								$type = bsa_get_trans('user_panel', 'clicks');
							else:
								$type = bsa_get_trans('user_panel', 'days');
							endif;

							// show renewal options
							if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_1") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=1'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_1").' '.strtolower($type); ?>
								</a><br>
							<?php endif; ?>
							<?php if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_2") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=2'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_2").' '.strtolower($type); ?>
								</a><br>
							<?php endif; ?>
							<?php if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_3") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=3'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_3").' '.strtolower($type); ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td class="bsaCenter" colspan="6">
					<a class="buyButton" href="<?php echo bsaFormURL(); ?>"><?php echo bsa_get_trans('user_panel', 'buy_ads'); ?></a>
				</td>
			</tr>
		<?php else: ?>
			<?php if ( is_user_logged_in() ): ?>
				<tr>
					<td class="bsaCenter" colspan="6">
						<a href="<?php echo bsaFormURL(); ?>"><?php echo bsa_get_trans('user_panel', 'first_purchase'); ?></a>
					</td>
				</tr>
			<?php else: ?>
				<tr>
					<td class="bsaCenter" colspan="6">
						<a href="<?php echo wp_login_url( bsaFormURL() ); ?>"><?php echo bsa_get_trans('user_panel', 'login_here'); ?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<?php
	echo '</div>'; // end container
	?>
	<style>
		#bsaProPanelTable a {
			color: <?php echo bsa_get_opt('user_panel', 'link_color'); ?>;
		}
		#bsaProPanelTable .buyButton {
			background-color: <?php echo bsa_get_opt('user_panel', 'button_bg'); ?>;
			color: <?php echo bsa_get_opt('user_panel', 'button_color'); ?>;
		}
		#bsaProPanelTable .buyButton:hover {
			background-color: <?php echo bsa_get_opt('user_panel', 'button_color'); ?>;
			color: <?php echo bsa_get_opt('user_panel', 'button_bg'); ?>;
		}
		#bsaProPanelTable th {
			background-color: <?php echo bsa_get_opt('user_panel', 'head_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', 'head_color'); ?>;
		}
		<?php if ( bsa_get_opt('user_panel', 'separator') != '' ): ?>
		#bsaProPanelTable th,
		#bsaProPanelTable tr {
			border-bottom: 1px solid <?php echo bsa_get_opt('user_panel', 'separator'); ?>;
		}
		<?php endif; ?>
	</style>
	<?php
	return ob_get_clean();
}

add_action( 'admin_bar_menu', 'ads_pro_bar_link', 999 );
function ads_pro_bar_link( $wp_admin_bar ) {
	if ( 	get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && is_multisite() && is_main_site() ||
		get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && !is_multisite() ||
		get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && get_current_blog_id() != 1 && is_main_site(1) ) {
		$model = new BSA_PRO_Model();
		$get_free_ads = $model->getUserCol(get_current_user_id(), 'free_ads');
		$free_ads = ((bsa_role() == 'admin') ? null : '('. get_option('bsa_pro_plugin_trans_free_ads') .' ' . (($get_free_ads['free_ads'] > 0) ? $get_free_ads['free_ads'] : 0) . ')');
		$link = ((bsa_role() == 'admin') ? 'admin.php?page=bsa-pro-sub-menu' : 'admin.php?page=bsa-pro-sub-menu-users');
		$args = array(
			'id'    => 'ads_pro_bar_link',
			'title' => '<img src="'.plugins_url('../frontend/img/bsa-icon.png', __FILE__).'" alt="" style="width:16px;display:inline-block;"> ADS PRO ' . $free_ads,
			'href'  => get_admin_url(1).$link,
			'meta'  => array( 'class' => 'ads_pro_bar_link' ),
			'icon'  => plugins_url('../frontend/img/bsa-icon.png', __FILE__)
		);
		if ( $get_free_ads['free_ads'] >= 0 or bsa_role() == 'admin') {
			$wp_admin_bar->add_node( $args );
		}
	}
}

add_action( 'bsa_cron_jobs','bsa_do_pending_tasks' );
function bsa_do_pending_tasks() { // CRON Function
	$cron = new BSA_PRO_Model();
	$cron->doCronTasks();
}

add_action( 'bsa_cron_views_stats','bsa_function_views_stats' );
function bsa_function_views_stats() {
	$model = new BSA_PRO_Model();
	$get_views_counter = get_option('bsa_pro_plugin_dashboard_views');
	$get_daily_counter = $model->getDailyViews(time() - (30 * 60));

	if ( $get_daily_counter[0] > 0 ) {
		update_option('bsa_pro_plugin_dashboard_views', ($get_views_counter + $get_daily_counter[0])); // increase views stats
	}

	wp_schedule_single_event( time() + (30 * 60), 'bsa_cron_views_stats', array( time() ) );
}

//// do action
//do_action('bsa_pro_action', 'test argument');
//
//// add action
//add_action( 'bsa_pro_action', 'testBsaProAction' );
//function testBsaProAction($test) {
//	if ( $test != null ) {
//		echo "TEST ADS PRO ACTION" . " " . $test;
//	} else {
//		echo "TEST ADS PRO ACTION!";
//	}
//}
