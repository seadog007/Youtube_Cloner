<?php
require_once '../src/common.php';
if ($_SESSION['id']==''){
	header('Location: /login.php');
	exit();
}

$res = [];

global $db;

$stmt = $db->prepare("SELECT `id` FROM `redeem` WHERE `code`=:code AND `user_id`=:user_id");
$stmt->execute([
	'user_id' => $_SESSION['id'],
	'code' => $_GET['code']
]);
$already_redeem = (bool)$stmt->fetch(PDO::FETCH_ASSOC)['id'];

if ($already_redeem){
	$res['status'] = 'failed';
  $res['error'] = 'Used promo code';
	$res['error_detail'] = 'You already redeem this promo code';
	die(json_encode($res));
}

$stmt = $db->prepare("SELECT `amount`, `limit` FROM `promo_code` WHERE `code`=:code ORDER BY `limit` DESC");
$stmt->execute([
	'code' => $_GET['code']
]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data['limit'] === 0){
	$res['status'] = 'failed';
  $res['error'] = 'This promo code has expired.';
	$res['error_detail'] = 'Be fast next time :P';
	die(json_encode($res));
}

$amount = $data['amount'];
if ($amount == 0){
	$res['status'] = 'failed';
	$res['error'] = 'No such promo code';
	$res['error_detail'] = 'Please check your promo code.';
	die(json_encode($res));
}

global $db;
$stmt = $db->prepare("INSERT INTO `redeem` (`user_id`, `code`) VALUES (:user_id, :code); UPDATE `users` SET `query_capability`=:queryadded WHERE `user_id`=:user_id; UPDATE `promo_code` SET `limit`=:left WHERE `code`=:code ORDER BY `limit` DESC LIMIT 1");
$stmt->execute([
	'user_id' => $_SESSION['id'],
	'code' => $_GET['code'],
	'queryadded' => query_count($_SESSION['id'])['query_capability'] + $amount,
	'left' => $data['limit'] - 1
]);
$res['status'] = 'success';
$res['code'] = $_GET['code'];
$res['query_cap_added'] = $amount;

echo json_encode($res);
