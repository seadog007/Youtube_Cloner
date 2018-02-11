<?php
require_once '../src/common.php';
if ($_SESSION['id']==''){
	header('Location: /login.php');
	exit();
}

$res = [];

function check_eth_left($addr, $cost){
	if (eth_system_balance($addr, $_SESSION['id']) >= (float)$cost){
		return True;
	}
	$res['status'] = 'failed';
  $res['error'] = 'Not enough ETH balance to exchange';
  $res['error_detail'] = 'Recharge by transfering ETH to your recharge address.';
	die(json_encode($res));
}

$rate_exist = False;
$amount_get = 0;
$ethcost = (float) $_GET['cost'];
foreach (exchange_rate() as $i){
	if ($i['ethcost'] == $ethcost){
		$rate_exist = True;
		$amount_get = $i['amount'];
	}
}

if (!$rate_exist){
	$res['status'] = 'failed';
	$res['error'] = 'No such exchange rate';
  $res['error_detail'] = 'Don\'t try to hack me.';
	die(json_encode($res));
}

check_eth_left(ethaddr($_SESSION['id']), $ethcost);

global $db;
$stmt = $db->prepare("INSERT INTO `exchanged` (`user_id`, `eth`, `amount`) VALUES (:user_id, :ethcost, :amount); UPDATE `users` SET `query_capability`=:queryadded WHERE `user_id`=:user_id");
$stmt->execute([
	'user_id' => $_SESSION['id'],
	'ethcost' => $ethcost,
	'amount' => $amount_get,
	'queryadded' => query_count($_SESSION['id'])['query_capability'] + $amount_get
]);
$res['status'] = 'success';
$res['cost'] = $ethcost;
$res['for'] = $amount_get;

echo json_encode($res);
