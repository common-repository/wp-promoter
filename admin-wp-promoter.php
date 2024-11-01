<?
class wp_promoterSettings
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;
	public $stat;
	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_head' , array($this , 'load_admin_scripts') );
	}

	public function load_admin_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_style('jquery_ui_css' , WPP_PLUGIN_URL.'/css/jquery-ui.css');
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
		'Settings Promotional Bar',
		'WP Promoter',
		'manage_options',
		'wp_promoter-setting-admin',
		array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		
		if(isset($_POST['update_wp_promoter'])) {
			if(isset($_POST['enable_wp_promoter']))
				$wp_promoter_option['enable_wp_promoter'] = $_POST['enable_wp_promoter'];
				$wp_promoter_option['text_wp_promoter'] = $_POST['text_wp_promoter'];
				$wp_promoter_option['link_text_wp_promoter'] = $_POST['link_text_wp_promoter'];
				$wp_promoter_option['link_wp_promoter'] = $_POST['link_wp_promoter'];
				$wp_promoter_option['bg_color_wp_promoter'] = $_POST['bg_color_wp_promoter'];
				$wp_promoter_option['msg_color_wp_promoter'] = $_POST['msg_color_wp_promoter'];
				$wp_promoter_option['btn_text_color_wp_promoter'] = $_POST['btn_text_color_wp_promoter'];
				$wp_promoter_option['btn_bg_color_wp_promoter'] = $_POST['btn_bg_color_wp_promoter'];
				$wp_promoter_option['btn_border_color_wp_promoter'] = $_POST['btn_border_color_wp_promoter'];
				$wp_promoter_option['position_wp_promoter']	=	$_POST['position_wp_promoter'];
				$wp_promoter_option['enable_wp_promoter_popup']	=	$_POST['enable_wp_promoter_popup'];
				$wp_promoter_option['text_wp_promoter_popup']	=	$_POST['text_wp_promoter_popup'];
				$wp_promoter_option['bg_color_wpp_popup']	=	$_POST['bg_color_wpp_popup'];
				$wp_promoter_option['msg_color_wpp_popup']	=	$_POST['msg_color_wpp_popup'];
				$wp_promoter_option['link_wp_promoter_popup']	=	$_POST['link_wp_promoter_popup'];
				$wp_promoter_option['link_text_wp_promoter_popup']	=	$_POST['link_text_wp_promoter_popup'];
				$wp_promoter_option['push_body']	=	$_POST['push_body'];
				$wp_promoter_option['popup_width']	=	$_POST['popup_width'];
				$wp_promoter_option['popup_height']	=	$_POST['popup_height'];
				update_option('wp_promoter_option' , $wp_promoter_option);
		}
		// Set class property
		$this->options = get_option( 'wp_promoter_option' );
		?>
		<style>

th {
			text-align: left;
		}
</style>
		<script type="text/javascript">
		jQuery(document).ready(function() { 
			jQuery("#reset-stats").click(function(e){
				e.preventDefault();
				jQuery.post(
						 ajaxurl, 
						    {
						        'action': 'wpp-reset_stats',
						    }, 
						    function(response){
						       window.location.reload();
						    }
				);
			});
			jQuery(".colors").miniColors({change: function(hex, rgb) { 
				}
			}); 
		});
		</script>
        <div class="wrap" >
            <?php screen_icon(); ?>

			 <script>
				jQuery(function() {
					jQuery( "#accordion" ).accordion();
				});
			</script>
			<h2>wp Promoter Settings<span style="float: right;"><a href="http://support.orbishub.com/">For Any Help</a></span></h2>           
            <form method="post" action="options-general.php?page=wp_promoter-setting-admin">
				<div id="accordion">
					<h3>General Settings</h3>
					<div>
						<table style="text-align: left;">
            				<tr>
            					<th>Enable Bar</th>
            					<td><input type="checkbox" name="enable_wp_promoter" value="on" <?php echo (isset($this->options['enable_wp_promoter']) && $this->options['enable_wp_promoter'] == 'on') ? 'checked="checked"' : ''; ?>/></td>
            				</tr>
            				<tr>
            					<th>Enable Popup</th>
            					<td><input type="checkbox" name="enable_wp_promoter_popup" value="on" <?php echo (isset($this->options['enable_wp_promoter_popup']) && $this->options['enable_wp_promoter_popup'] == 'on') ? 'checked="checked"' : ''; ?>/></td>
            				</tr>
            				<tr>
            					<th>Popup Width</th>
            					<td><input type="text" name="popup_width" value="<?php echo (isset($this->options['popup_width'])) ? $this->options['popup_width'] : '700';?>"/></td>
            				</tr>
            				<tr>
            					<th>Popup Height</th>
            					<td><input type="text" name="popup_height" value="<?php echo (isset($this->options['popup_height'])) ? $this->options['popup_height'] : '300';?>"/></td>
            				</tr>
            			</table>
					</div>
					<h3>Content Settings</h3>
					<div>
						<table style="text-align: left">
							<tr>
            					<th>Bar Message</th>
            					<td><textarea cols="60" rows="6" name="text_wp_promoter"><?php echo (isset($this->options['text_wp_promoter']) && $this->options['text_wp_promoter'] != '') ? stripslashes($this->options['text_wp_promoter']) : ''; ?></textarea></td>
            					<td>HTML is Allowed</td>
            				</tr>
            				<tr>
            					<th>Bar Button Text</th>
            					<td><input type="text" name="link_text_wp_promoter" value="<?php echo (isset($this->options['link_text_wp_promoter']) && $this->options['link_text_wp_promoter'] != '') ? $this->options['link_text_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Bar Button Link</th>
            					<td><input type="text" name="link_wp_promoter" value="<?php echo (isset($this->options['link_wp_promoter']) && $this->options['link_wp_promoter'] != '') ? $this->options['link_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Popup Message</th>
            					<td><textarea cols="60" rows="6" name="text_wp_promoter_popup"><?php echo (isset($this->options['text_wp_promoter_popup']) && $this->options['text_wp_promoter_popup'] != '') ? stripslashes($this->options['text_wp_promoter_popup']) : ''; ?></textarea></td>
            					<td>HTML is Allowed</td>
            				</tr>
            				<tr>
            					<th>Popup Button Text</th>
            					<td><input type="text" name="link_text_wp_promoter_popup" value="<?php echo (isset($this->options['link_text_wp_promoter_popup']) && $this->options['link_text_wp_promoter_popup'] != '') ? $this->options['link_text_wp_promoter_popup'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Popup Button Link</th>
            					<td><input type="text" name="link_wp_promoter_popup" value="<?php echo (isset($this->options['link_wp_promoter_popup']) && $this->options['link_wp_promoter_popup'] != '') ? $this->options['link_wp_promoter_popup'] : ''; ?>" /></td>
            				</tr>           				
            			</table>
					</div>
					<h3>Color Settings</h3>
					<div>
						<table style="text-align: left;">
							<tr>
            					<th>Bar Background color</th>
            					<td><input class="colors" name="bg_color_wp_promoter" value="<?php echo (isset($this->options['bg_color_wp_promoter']) && $this->options['bg_color_wp_promoter'] != '') ? $this->options['bg_color_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            		
            				<tr>
            					<th>Bar Message Color</th>
            					<td><input class="colors" name="msg_color_wp_promoter" value="<?php echo (isset($this->options['msg_color_wp_promoter']) && $this->options['msg_color_wp_promoter'] != '') ? $this->options['msg_color_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Button Background Color</th>
            					<td><input class="colors" name="btn_bg_color_wp_promoter" value="<?php echo (isset($this->options['btn_bg_color_wp_promoter']) && $this->options['btn_bg_color_wp_promoter'] != '') ? $this->options['btn_bg_color_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            		
            				<tr>            		
            					<th>Button Text Color</th>
            					<td><input class="colors" name="btn_text_color_wp_promoter" value="<?php echo (isset($this->options['btn_text_color_wp_promoter']) && $this->options['btn_text_color_wp_promoter'] != '') ? $this->options['btn_text_color_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Button Border Color</th>
            					<td><input class="colors" name="btn_border_color_wp_promoter" value="<?php echo (isset($this->options['btn_border_color_wp_promoter']) && $this->options['btn_border_color_wp_promoter'] != '') ? $this->options['btn_border_color_wp_promoter'] : ''; ?>" /></td>
            				</tr>
            				<tr>
            					<th>Pop up Background Color</th>
            					<td><input class="colors" name=bg_color_wpp_popup value="<?php echo (isset($this->options['bg_color_wpp_popup']) && $this->options['bg_color_wpp_popup'] != '') ? $this->options['bg_color_wpp_popup'] : ''; ?>" /></td>
            				</tr>
            				
            				<tr>
            					<th>Pop up Message Color</th>
            					<td><input class="colors" name=msg_color_wpp_popup value="<?php echo (isset($this->options['msg_color_wpp_popup']) && $this->options['msg_color_wpp_popup'] != '') ? $this->options['msg_color_wpp_popup'] : ''; ?>" /></td>
            				</tr>
						</table>
					</div>
					<h3>Bar Position Settings</h3>
					<div>
						<table>
							<tr>
								<th>TOP</th>
								<td><input type="radio" name="position_wp_promoter" value="top" <?php echo (isset($this->options['position_wp_promoter']) && $this->options['position_wp_promoter'] == 'top') ? 'checked="checked"' : ''; ?>></td>
							</tr>
							<tr>
								<th>Bottom</th>
								<td><input type="radio" name="position_wp_promoter" value="bottom" <?php echo (isset($this->options['position_wp_promoter']) && $this->options['position_wp_promoter'] == 'bottom') ? 'checked="checked"' : ''; ?>></td>
							</tr>
							<tr>
								<th>Left</th>
								<td><input type="radio" name="position_wp_promoter" value="left" <?php echo (isset($this->options['position_wp_promoter']) && $this->options['position_wp_promoter'] == 'left') ? 'checked="checked"' : ''; ?>></td>
							</tr>
							<tr>
								<th>Right</th>
								<td><input type="radio" name="position_wp_promoter" value="right" <?php echo (isset($this->options['position_wp_promoter']) && $this->options['position_wp_promoter'] == 'right') ? 'checked="checked"' : ''; ?>></td>
							</tr>

							<tr>
								<th>Push Body</th>
								<td><input type="text" name="push_body" value="<?php echo (isset($this->options['push_body'])) ? $this->options['push_body'] : 0; ?>"/> Push body by mentioned pixels</td>
							</tr>
						</table>
					</div>
					<?php include_once(WPP_PLUGIN_DIR.'/admin/templates/stats.php'); ?>
				</div>
<br><br>
<input type="submit" class="button button-primary" name="update_wp_promoter" value="Save Changes">
            
            </form>
        </div>
        <?php
    }

  
}

if( is_admin() )
    new wp_promoterSettings();

?>
