<?php
return array(
	'language' => 'cn',
	'action_not_found' => 'uxllautocall',
	'request' => array(
		'URL_MODE' => 'miscellaneous',
		'URL_GET_CONTROLLER_NAME' => 'uxllcontrol',
		'URL_GET_ACTION_NAME' => 'uxllaction',
		'URL_DEFAULT_PAGE_NAME' => 'index.php',
		'DEFAULT_CONTROLLER_NAME' => 'main',
		'DEFAULT_ACTION_NAME' => 'welcome'
	),
	'dir' => array(
		'compile_dir' => ROOT.'dc/runtime/',
		'template_dir' => ROOT.'templates/'
	),
	'auth' => array(
		'id' => 'authorization_user_id'// for session
	),
	'msg_rewrite' => ROOT.'config/msgRewrite.php'
);
