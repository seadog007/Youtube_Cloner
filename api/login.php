<?php
if ($_GET['token'] == ''){
	die('No Token');
}

require_once '../src/Facebook/autoload.php';
require_once '../src/common.php';

$fb = new \Facebook\Facebook([
	'app_id' => FB_API,
	'app_secret' => FB_SECRET,
	'default_graph_version' => 'v2.11',
]);

try {
	$response = $fb->get('/me', $_GET['token']);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
	header('Location: /login.php');
	if ($e->getMessage() === 'Malformed access token'){
		die('Go away');
	}
	die('Graph returned an error: ' . $e->getMessage());
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
	header('Location: /login.php');
	die('Facebook SDK returned an error: ' . $e->getMessage());
}

$me = $response->getGraphUser();
$regstat = register($me->getId(), $me->getName());
if ($regstat == -1){
	die("Unknown Error");
}
$_SESSION['logined'] = 1;
$_SESSION['id'] = $me->getId();
$_SESSION['name'] = $me->getName();
$_SESSION['token'] = $_GET['token'];
$path = explode('/', $_GET['ref']);
if (count($path) == 1 and $path[0] != ''){
	header('Location: /' . $_GET['ref']);
}else{
	header('Location: /profile.php');
}
