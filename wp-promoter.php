<?php
/*
Plugin Name: WP Promoter
Plugin URI:  http://www.orbishub.com/
Description: Promote your services with the eye catching features of WP Promoter plugin
Version: 1.3
Author: OrbisHub
Author URI: http://www.orbishub.com/
*/
?>
<?php 
if(!defined('ABSPATH')) { exit(0);}

if(!class_exists('wp_promoter')) :

class wp_promoter {
	protected static $_instance;
	protected $Version;

	public $stat;
	
	public function __construct(){
		
		$this->define_constants();
		$this->includes();
		include_once(WPP_PLUGIN_DIR.'/admin-wp-promoter.php');
		
		$this->stat = new WPP_stat();
		add_action('wp_enqueue_scripts' , array($this , 'load_scripts') );
		add_action('wp_footer' , array($this , 'display_wp_promoter'));
		add_action('admin_head' , array($this , 'load_admin_scripts') , 999);
	}
	
	public function includes() {
		include_once(WPP_PLUGIN_DIR.'/inc/class-wpp-stats.php');
		include_once(WPP_PLUGIN_DIR.'/inc/class-wpp-ajax.php');
	}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function define_constants(){
		$plugindir=explode('/', __DIR__);
		$plugindir=$plugindir[count($plugindir)-1];
		define('WPP_PLUGIN_DIR' , __DIR__);
		define('WPP_PLUGIN_URL' , WP_PLUGIN_URL .'/'. $plugindir);
	}
	
	public function load_admin_scripts() {
		wp_enqueue_style( 'wpp_minicolor_css' , WPP_PLUGIN_URL.'/minicolor/jquery.miniColors.css' );
		wp_enqueue_script( 'wpp_minicolor_js' , WPP_PLUGIN_URL.'/minicolor/jquery.miniColors.min.js' );
	}
	
	public function load_scripts() {
		wp_enqueue_style( 'wpp_custom_Css',WPP_PLUGIN_URL.'/css/custom.css');
	}
	
	public function display_wp_promoter() {
		$options = get_option( 'wp_promoter_option' );
		if(isset($options['enable_wp_promoter']) &&  $options['enable_wp_promoter'] == 'on' && !isset($_COOKIE['wp_promoter'])) {
		?>
		
		
		<style>
		.wp-promoter-popup {	
			width: <?php echo $options['popup_width']; ?>px;
			height: <?php echo $options['popup_height']; ?>px;
		}
		
		
		<?php 
		switch ($options['position_wp_promoter']){
			case 'top':
				?>
				body{
					margin-top: <?php echo $options['push_body']; ?>px !important;
					top: <?php echo $options['push_body']; ?>px !important;
				}
		
				#wpadminbar {
					top: <?php echo $options['push_body']; ?>px !important;
				}
				.wpp-promo-bar{
					position: fixed;
					top: 0px;
					width: 100%;
				}
				<?php 
			break;
			case 'bottom':
				?>
				body{
					margin-bottom: <?php echo $options['push_body']; ?>px !important;
					bottom: <?php echo $options['push_body']; ?>px !important;
				}
					.wpp-promo-bar{
					position: fixed;
					bottom: 0px;
					width: 100%;
				}
				<?php 
			break;
			case 'left':
				?>
				body{
					margin-left: <?php echo $options['push_body']; ?>px !important;
					left: <?php echo $options['push_body']; ?>px !important;
				}
					.wpp-promo-bar{
						position: fixed;
						left: 0px;
						height: 100%;
						min-width: 100px;
						width: 200px;
						top: 0px;
					}
				<?php 
			break;
			case 'right':
				?>
					body{
					margin-right: <?php echo $options['push_body']; ?>px !important;
					right: <?php echo $options['push_body']; ?>px !important;
				}
					.wpp-promo-bar{
						position: fixed;
						right: 0px;
						height: 100%;
						top: 0px;
						min-width: 100px;
					}
				<?php
			break;
			default:	
				?>
					body,site-header{
					margin-top: <?php echo $options['push_body']; ?>px !important;
					top: <?php echo $options['push_body']; ?>px !important;
				}
					.wpp-promo-bar{
						position: fixed;
						top: 0px;
						width: 100%;
					}
				<?php 	
			break;
		}
		?>
			.wpp-promo-bar{
				background-color: <?php echo (isset($options['bg_color_wp_promoter']) && $options['bg_color_wp_promoter'] != '') ? $options['bg_color_wp_promoter'] : 'orange'  ; ?>;
				color: <?php echo (isset($options['msg_color_wp_promoter']) && $options['msg_color_wp_promoter'] != '') ? $options['msg_color_wp_promoter'] : '#fff'; ?>;
			}
			.wpp-link {
				background: none repeat scroll 0% 0% <?php echo (isset($options['btn_bg_color_wp_promoter']) && $options['btn_bg_color_wp_promoter'] != '') ? $options['btn_bg_color_wp_promoter'] : '#414';?>;
				color: <?php echo (isset($options['btn_text_color_wp_promoter']) && $options['btn_text_color_wp_promoter'] != '') ? $options['btn_text_color_wp_promoter'] : '#FFF';?> !important; 
				border: 1px outset <?php echo (isset($options['btn_border_color_wp_promoter']) && $options['btn_border_color_wp_promoter'] != '') ? $options['btn_border_color_wp_promoter'] : '#FFF'; ?>;
			}
			.wpp-link:HOVER {
				text-decoration: none;
				border: 1px inset <?php echo (isset($options['btn_border_color_wp_promoter']) && $options['btn_border_color_wp_promoter'] != '') ? $options['btn_border_color_wp_promoter'] : '#FFF'; ?>;
			}
		</style>
		
		<script type="text/javascript">
		jQuery(function(){
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			jQuery.post(
					 ajaxurl, 
					    {
					        'action': 'wpp-add_bar_impression',
					    }, 
					    function(response){
					      
					    }
			);
			jQuery("#wpp-bar-link").click(function(e){
				e.preventDefault();
				jQuery.post(
						 ajaxurl, 
						    {
						        'action': 'wpp-bar_btn_click',
						    }, 
						    function(response){
						       window.location = jQuery('#wpp-bar-link').attr('href');
						    }
				);
			});
				jQuery('#close_wp_promoter').click(function(){
					jQuery.post(
							 ajaxurl, 
							    {
							        'action': 'wpp-bar_close_click',
							    }, 
							    function(response){
							      //  alert('The server responded: ' + response);
							    }
					);
					jQuery('#wpp-wp_promoter').hide();
					jQuery("body").attr('style' , 'margin-<?php echo $options["position_wp_promoter"] ?>:0px !important; <?php echo $options["position_wp_promoter"] ?>: 0px !important; ');
					jQuery("#wpadminbar").attr('style' , 'margin-top:0px !important; top: 0px !important;');
					
					setCookie("wp_promoter" , "hide" , 7);
				});
			});

			function setCookie(cname, cvalue, exdays) {
			    var d = new Date();
			    d.setTime(d.getTime() + (exdays*24*60*60*1000));
			    var expires = "expires="+d.toUTCString();
			    document.cookie = cname + "=" + cvalue + "; " + expires;
			}
		</script>
		<div class="wpp-promo-bar" id="wpp-wp_promoter"><?php echo stripslashes($options['text_wp_promoter']); ?> 
		<?php if($options['link_text_wp_promoter'] != '') {?>		<a class="wpp-link" id="wpp-bar-link" href="<?php echo $options['link_wp_promoter']; ?>" ><?php echo $options['link_text_wp_promoter']; ?></a><?php  } ?>
		<span class="wpp-close" id="close_wp_promoter">X</span>
		</div>
		<?
		}
		if(isset($options['enable_wp_promoter_popup']) &&  $options['enable_wp_promoter_popup'] == 'on' && !isset($_COOKIE['wp_promoter_popup'])) {
		?>
			<script type="text/javascript">
			jQuery(function(){
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				jQuery.post(
						 ajaxurl, 
						    {
						        'action': 'wpp-add_popup_impression',
						    }, 
						    function(response){
						      
						    }
				);
				jQuery("#wpp-popup-link").click(function(e){
					e.preventDefault();
					jQuery.post(
							 ajaxurl, 
							    {
							        'action': 'wpp-popup_btn_click',
							    }, 
							    function(response){
							       window.location = jQuery('#wpp-popup-link').attr('href');
							    }
					);
				});
				jQuery('#wpp-popup').hide();
				setTimeout(function(){
					jQuery('#wpp-popup').show();
				}, 3000);
				jQuery('#close-wpp-popup').click(function(){
					jQuery.post(
							 ajaxurl, 
							    {
							        'action': 'wpp-popup_close_click',
							    }, 
							    function(response){
							       
							    }
					);
					jQuery('#wpp-popup').hide();
					setCookie("wp_promoter_popup" , "hide" , 7);
				});
			});
		</script>
		<style>
		.wp-promoter-popup {
			display: none;
			background-color: <?php echo (isset($options['bg_color_wpp_popup']) && $options['bg_color_wpp_popup'] != '' ) ? $options['bg_color_wpp_popup'] : 'orange'?>;
			color: <?php echo (isset($options['msg_color_wpp_popup']) && $options['msg_color_wpp_popup'] != '' ) ? $options['msg_color_wpp_popup'] : '#FFF'?>;
			
		}
		</style>
			<div id="wpp-popup" class="wp-promoter-popup">
				<div>
					<?php echo stripslashes($options['text_wp_promoter_popup']); ?> 
				</div>
				<?php if($options['link_wp_promoter_popup'] != '' && $options['link_text_wp_promoter_popup'] != '') {?>
					<a class="wpp-link" id="wpp-popup-link" href="<?php echo $options['link_wp_promoter_popup'];?>"><?php echo $options['link_text_wp_promoter_popup'];?></a>
				<?php } ?>
				<span class="wpp-close" id="close-wpp-popup">X</span>
			</div>
			<?php 
		}
	}
	
}
endif;
$wpp = wp_promoter::instance();

