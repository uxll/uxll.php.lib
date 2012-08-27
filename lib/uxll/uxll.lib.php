<?php

$GLOBALS['UXLL_CONFIG'] = require_once(UXLL_ROOT."uxll.conf.php");
$GLOBALS['UXLL_CONFIG']['language'] = require_once(UXLL_ROOT.'language/'.$GLOBALS['UXLL_CONFIG']['language'].".php");
foreach(array(
	"Register",
	"HttpRequest",
	"HttpMessage",
	"Message",
	"IdentityToken",
	"View",
	"Model",
	"functions",
	"FrontControl"
) as $key => $val){
	require_once(UXLL_ROOT.'core/'.$val.".php");
}//for each
function class_autoload($clsname){
	$filename = UXLL_ROOT.'library/'.substr($clsname,1).'.php';
	if(file_exists($filename)){
		require_once($filename);
		return true;
	}
	$filename = UXLL_ROOT.'library/'.preg_replace("/^C[A-Z]\w*([A-Z][a-z]+)$/","$1",$clsname).'.php';
	if(file_exists($filename)){
		require_once($filename);
		return true;
	}
	return false;		
}
spl_autoload_register('class_autoload');

R('HTTP',new CHttpMessage());
R('CONTROL',new CFrontControl());
