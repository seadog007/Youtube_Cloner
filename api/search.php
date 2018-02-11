<?php
require_once '../src/common.php';
if ($_SESSION['id']==''){
	header('Location: /login.php');
	exit();
}else if(cap_left($_SESSION['id']) == 0){
	header('Location: /profile.php');
	exit();
}

$res = [];

function check_cap($cost){
	if (cap_left($_SESSION['id']) >= $cost){
		return True;
	}
	$res['status'] = 'failed';
	$res['error'] = 'not enough balance';
	die(json_encode($res));
}

$cap_cost = 1;
check_cap($cap_cost);

global $db;
$stmt = $db->prepare("SELECT `vid`, `fid`, `import_time`, `status`, `video_name`, `disappear_time` FROM `videos` WHERE `vid`=:vid LIMIT 1");
$stmt->execute([
	'vid' => $_GET['vid']
]);

$res['status'] = 'success';
$res['result'] = $stmt->fetch(PDO::FETCH_ASSOC);

if ($res['result']){
	$stmt = $db->prepare("SELECT `id` FROM `paid` WHERE `user_id`=:user_id AND `query`=:query");
	$stmt->execute([
		'user_id' => $_SESSION['id'],
		'query' => $_SERVER['QUERY_STRING'],
	]);
	if($stmt->fetch(PDO::FETCH_ASSOC)){
		$cap_cost = 0;
	}else{
		$stmt = $db->prepare("UPDATE `users` SET query_count=:value WHERE `user_id`=:user_id");
		$stmt->execute([
			'user_id' => $_SESSION['id'],
			'value' => query_count($_SESSION['id'])['query_count'] + $cap_cost
		]);
		$stmt = $db->prepare("INSERT INTO `paid` (`user_id`, `query`, `cost`) VALUES (:user_id, :query, :cost)");
		$stmt->execute([
			'user_id' => $_SESSION['id'],
			'query' => $_SERVER['QUERY_STRING'],
			'cost' => $cap_cost
		]);
	}

	$stmt = $db->prepare("INSERT INTO `result` (`user_id`, `result`) VALUES (:user_id, :result)");
	$stmt->execute([
		'user_id' => $_SESSION['id'],
		'result' => json_encode($res)
	]);

	$res['result_id'] = $db->lastInsertId();
}else{
	$cap_cost = 0;
}
$res['cap_cost'] = $cap_cost;
$res['cap_left'] = cap_left($_SESSION['id']);

echo json_encode($res);
