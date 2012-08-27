<?php
class CDebug{
	private $stream;
	public function __construct($var,$flag = false){
		if($flag){
			ob_start();	
		}
		if(is_array($var)){
			echo "<pre>";
			print_r($var);
			echo "</pre>";
		}else{
			echo "<pre>";
			var_dump($var);	
			echo "</pre>";
		}
		if($flag){
			$this -> stream = ob_get_contents();
			ob_end_clean();
		}
	}
	public function get(){
		return $this -> stream;
	}	
}