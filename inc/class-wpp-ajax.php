<?php

if(!defined('ABSPATH')) {exit;}

if(!class_exists('WPP_Ajax')) :
include_once(WPP_PLUGIN_DIR.'/inc/class-wpp-stats.php');
class WPP_Ajax {
	
	
	public function __construct() {
		$events = array(
				'bar_close_click' => true,
				'bar_btn_click'	=> true ,
				'popup_close_click'	=> true ,
				'popup_btn_click'	=> true ,
				'reset_stats'		=> true ,
				'add_bar_impression'	=> true ,
				'add_popup_impression'	=> true ,
			);
		foreach ($events as $event => $nopriv) {
			add_action('wp_ajax_wpp-'.$event, array($this, $event));
			if($nopriv) {
				add_action('wp_ajax_nopriv_wpp-'.$event, array($this, $event));
			}
		}
	}
	
	public function reset_stats() {
		delete_option('wpp_bar');
		delete_option('wpp_popup');
	}
	
	public function add_bar_impression() {
		$stat = new WPP_stat();
		$stat->addImpression("wpp_bar");
		die();
	}
	
	public function add_popup_impression() {
		$stat = new WPP_stat();
		$stat->addImpression("wpp_popup");
		die();
	}
	
	public function bar_btn_click() {
		$stat = new WPP_stat();
		$stat->addBtnClick("wpp_bar");
		die();
	}
	
	public function bar_close_click() {
		$stat = new WPP_stat(); 
		$stat->addCloseClick("wpp_bar");
		die();
	}
	
	public function popup_close_click() {
		$stat = new WPP_stat();
		$stat->addCloseClick("wpp_popup");
		die();
	}
	
	public function popup_btn_click() {
		$stat = new WPP_stat();
		$stat->addBtnClick("wpp_popup");
		die();
	}
}

endif;
new WPP_Ajax();
?>