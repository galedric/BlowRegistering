<?php

define("CALENDAR_ROOT", dirname(__FILE__));

define('ARRAS_FORCE_LAYOUT', "1c-fixed");
require CALENDAR_ROOT."/../www/wp-load.php";

$phpbbForum->foreground();

function is_blow_raider() {
	global $user;
	return in_array($user->data["group_id"], array(10, 9, 8, 11));
}

function is_blow_officier() {
	global $user;
	return $user->data["group_id"] == 8 || 
	       $user->data["user_id"] == 2  || 
	       $user->data["user_id"] == 54;
}

function is_user_authorized($owner) {
	global $user;
	return $user->data["user_id"] == $owner || is_blow_officier();
}

function blow_header() {
	$header_inject = array(
		'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>',
		'<script type="text/javascript" src="/static/showdown.js"></script>',
		'<script type="text/javascript" src="/static/btools.js"></script>',
		'<script type="text/javascript" src="/static/prefixfree.js"></script>',
		'<link rel="stylesheet" type="text/css" href="/static/fontello.css">',
		'<link rel="stylesheet" data-prefix="1" type="text/css" href="/static/btools.css">'
	);
	
	$google_watchdog = <<<JS_CODE
<script type="text/javascript">
	var google_watchdog = setTimeout(function() {
		location.reload();
	}, 2000);
</script>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700|Droid+Sans+Mono">
<script type="text/javascript">
	clearTimeout(google_watchdog);
</script>
JS_CODE;
	
	ob_start();
	get_header();
	$head = ob_get_contents();
	ob_end_clean();
	
	echo preg_replace("/(<body.*?>)/", "$1\n".implode("\n", $header_inject).$google_watchdog, $head);
}

function blow_footer() {
	/*ob_start();*/
	get_footer();
	/*$foot = ob_get_contents();
	ob_end_clean();
	
	$loader = '<div id="loader"><div class="circle"></div><div class="circle"></div><div class="circle"></div><div class="circle"></div><div class="circle"></div></div>';
	echo str_replace("</body>", $loader."\n</body>", $foot);*/
}