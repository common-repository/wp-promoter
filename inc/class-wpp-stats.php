<?php
if(!defined('ABSPATH')) { exit; }

if(!class_exists('WPP_stat')) :

class WPP_stat {
	
	private $wpp_bar = array();
	private $wpp_popup = array();
	
	public function __construct() {
		$this->wpp_bar = get_option("wpp_bar");
		$this->wpp_popup = get_option("wpp_popup");
	}
	
	public function getImpression($type) {
		switch ($type) {
			case 'wpp_bar':
				return (isset($this->wpp_bar['impression'])) ? $this->wpp_bar['impression'] : 0;
			break;
			case 'wpp_popup':
				return (isset($this->wpp_popup['impression'])) ? $this->wpp_popup['impression'] : 0;
			break;
		}
	}
	
	public function getCloseClicks($type) {
		switch ($type) {
			case 'wpp_bar':
				return (isset($this->wpp_bar['close'])) ? $this->wpp_bar['close'] : 0;
				break;
			case 'wpp_popup':
				return isset($this->wpp_popup['close']) ? $this->wpp_popup['close'] : 0;
				break;
		}
	}
	
	public function getClicks($type) {
		switch ($type) {
			case 'wpp_bar':
				return (isset($this->wpp_bar['click'])) ? $this->wpp_bar['click'] : 0;
				break;
			case 'wpp_popup':
				return (isset($this->wpp_popup['click'])) ? $this->wpp_popup['click'] : 0;
				break;
		}
	}
	
	public function addImpression($type) {

		switch ($type) {
			case 'wpp_bar':
				if(!$this->wpp_bar) {	
					add_option("wpp_bar" , array('impression' => 1));
				}else{
					$this->wpp_bar["impression"] = $this->wpp_bar["impression"]+1;
					update_option("wpp_bar", $this->wpp_bar);
				}
			break;
			case 'wpp_popup':
				if(!$this->wpp_popup) {
					add_option("wpp_popup" , array('impression' => 1));
				}else{
					$this->wpp_popup["impression"] = $this->wpp_popup["impression"]+1;
					update_option("wpp_popup", $this->wpp_popup);
				}
			break;
		}
	}
	
	public function addCloseClick($type) {
		
		switch ($type) {
			case 'wpp_bar':
				if(!$this->wpp_bar){
					add_option("wpp_bar" ,array('close' => 1));
				}else {
					$this->wpp_bar["close"] = $this->wpp_bar["close"]+1;
					update_option("wpp_bar", $this->wpp_bar);
				}
			break;
			case 'wpp_popup':
				if(!$this->wpp_popup) {
					add_option("wpp_popup" , array('impression' => 1) , true);
				}else{
					$this->wpp_popup["close"] = $this->wpp_popup["close"]+1;
					update_option("wpp_popup", $this->wpp_popup);
				}
			break;
		}
		
	}
	
	public function addBtnClick($type) {
		switch ($type) {
			case 'wpp_bar':
				if(!$this->wpp_bar){
					add_option("wpp_bar" ,array('click' => 1));
				}else {
					$this->wpp_bar["click"] = $this->wpp_bar["click"]+1;
					update_option("wpp_bar", $this->wpp_bar);
				}
			break;
			case 'wpp_popup':
				if(!$this->wpp_popup) {
					add_option("wpp_popup" , array('impression' => 1) , true);
				}else{
					$this->wpp_popup["click"] = $this->wpp_popup["click"]+1;
					update_option("wpp_popup", $this->wpp_popup);
				}
			break;
		}
		
	}
	
	
}

endif;