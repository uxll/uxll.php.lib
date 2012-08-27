<?php
require_once(UXLL_ROOT.'extends/smarty/Smarty.class.php');
class CTemplate{
	private $engine;
//	private $
	public function __construct(){
		$this -> engine = new Smarty();
		$this -> engine -> compile_dir = $GLOBALS['UXLL_CONFIG']['dir']['compile_dir'];
		$this -> engine -> template_dir = $GLOBALS['UXLL_CONFIG']['dir']['template_dir'];
		$this -> engine -> left_delimiter = '{{';
		$this -> engine -> right_delimiter = '}}';
		//$this -> engine -> caching = true;
		//$this -> engine -> cache_lifetime = Smarty::CACHING_LIFETIME_CURRENT;
	}
	public function __call($name,$arguments){
		$ret = call_user_func_array(array($this -> engine,$name),$arguments);
		return get_class($ret) === get_class($this -> engine) ? $this : $ret;
	}	
}