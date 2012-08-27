<?php
define("UXLL_VERSION", "1.61"); //µ±Ç°¿ò¼Ü°æ±¾2012/8/25 9:35:51
define("UXLL_DEBUG_FLAG",true); 
error_reporting(E_ALL);
if(UXLL_DEBUG_FLAG)ob_start();//for debug
if(!defined("ROOT"))define("ROOT",dirname(str_replace("\\","/",dirname(__FILE__)))."/");
if(!defined("UXLL_ROOT"))define("UXLL_ROOT",ROOT."lib/uxll/");
if(!defined("HOME"))define("HOME","/");
if(!defined("MODEL"))define("MODEL",ROOT."model/");
if(!defined("WEB"))define("WEB","http://".$_SERVER["HTTP_HOST"]."/");
if($_SERVER["HTTP_HOST"] !== "www.upl.com"){	
	file_put_contents(ROOT."config/const.php",str_replace('{{$ver}}',UXLL_VERSION,file_get_contents(ROOT.'config/bakup/const.txt')));
}