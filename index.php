<?php
require('config/const.php');
require('lib/uxll/uxll.lib.php');
R('CONTROL') -> route(new CMessage(R('HTTP') -> getMessage()));