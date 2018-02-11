<?php
require_once 'config.php';

function get_ip(){
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?: $_SERVER['REMOTE_ADDR'];
}

function is_account_exist($id){
    global $db;
    $stmt = $db->prepare("SELECT `id` FROM `users` WHERE user_id=:user_id");
	$stmt->execute([
		'user_id' => $id
	]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    if ($res == ""){
        return 0;
    }else{
		$stmt = $db->prepare("UPDATE `users` SET `last_ip`=:ip WHERE `user_id`=:user_id");
		$stmt->execute([
			'user_id' => $id,
			'ip' => get_ip()
		]);
        return 1;
    }
}

function register($id, $name){
    global $db;
	$eth_info = ewg();
	$account_stat = is_account_exist($id);
	if (!$account_stat and strlen($eth_info[0]) == 64 and strlen($eth_info[1]) == 128){
		$stmt = $db->prepare('INSERT INTO `users` (`user_id`, `name`, `reg_ip`, `last_ip`, `query_capability`, `priv`, `pub`, `addr`) VALUES (:user_id, :name, :ip, :ip, 3, :priv, :pub, :addr)');
		$stmt->execute([
			'user_id' => $id,
			'name' => $name,
			'ip' => get_ip(),
			'priv' => $eth_info[0],
			'pub' => $eth_info[1],
			'addr' => $eth_info[2]
		]);
		return 1;
	}else if($account_stat){
		return 0;
	}else{
		return -1;
	}
}

function query_count($id){
	global $db;
	$stmt = $db->prepare("SELECT `query_count`, `query_capability` FROM `users` WHERE user_id=:user_id");
	$stmt->execute([
		'user_id' => $id
	]);
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function cap_left($id){
	$query_stat = query_count($id);
	return $query_stat['query_capability'] - $query_stat['query_count'];
}

function ewg(){
	chdir(dirname(__FILE__) . '/ewg');
	exec('bash ewg.sh', $res, $ret);
	return $res;
}

function ethaddr($id){
	global $db;
	$stmt = $db->prepare("SELECT `addr` FROM `users` WHERE user_id=:user_id");
	$stmt->execute([
		'user_id' => $id
	]);
	return $stmt->fetch(PDO::FETCH_ASSOC)['addr'];
}

function eth_network_info($addr){
	$url = 'https://api.ethplorer.io/getAddressInfo/' . $addr . '?apiKey=freekey';
	$res = json_decode(file_get_contents($url), True);
	if ($res === NULL){
		die('error');
	}
	return $res;
}

function eth_system_balance($addr, $user_id){
	global $db;
	$stmt = $db->prepare("SELECT `eth` FROM `exchanged` WHERE user_id=:user_id");
	$stmt->execute([
		'user_id' => $user_id
	]);
	$total_spent = 0;
	foreach ($stmt->fetchall(PDO::FETCH_ASSOC) as $i){
		$total_spent += (float)$i['eth'];
	}
	return eth_network_info($addr)['ETH']['totalIn'] - $total_spent;
}

function exchange_rate(){
	global $db;
	$stmt = $db->prepare("SELECT `ethcost`, `amount` FROM `rate` WHERE `disable`=0");
	$stmt->execute();
	return $stmt->fetchall(PDO::FETCH_ASSOC);
}

function user_result($rid, $user_id){
	global $db;
	$stmt = $db->prepare("SELECT `result` FROM `result` WHERE `id`=:rid AND `user_id`=:user_id");
	$stmt->execute([
		'rid' => $rid,
		'user_id' => $user_id
	]);
	return $stmt->fetch(PDO::FETCH_ASSOC)['result'];
}
?>
