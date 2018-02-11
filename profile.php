    <?php $title = 'Profile';
	require 'src/header.php';
	require 'src/common.php';
	$query_stat = query_count($_SESSION['id']);
	$addr = ethaddr($_SESSION['id']);
	$system_bal = eth_system_balance($addr, $_SESSION['id']); ?>


    <header class="ts borderless extra padded massive center aligned fluid jumbotron">
        <h1 class="ts header">Your Profile</h1>
    </header>

	<section class="ts narrow container">
		<h3 class="ts left aligned header">Personal Information</h3>
        <div class="ts very padded segment">
            <form class="ts form">
                <div class="two fields">
                    <div class="field">
                        <label>Name</label>
						<label><?= $_SESSION['name']?></label>
                    </div>
                    <div class="field">
                        <label>User ID</label>
						<label><?= $_SESSION['id']?></label>
                    </div>
                </div>
                <div class="three fields">
                    <div class="field">
                        <label>Total Query Capacity</label>
						<label><?= $query_stat['query_capability'] ?></label>
                    </div>
                    <div class="field">
                        <label>Query Used</label>
						<label><?= $query_stat['query_count'] ?></label>
                    </div>
                    <div class="field">
                        <label>Query Left</label>
						<label><?= $query_stat['query_capability'] - $query_stat['query_count'] ?></label>
                    </div>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Your Charge ETH Address</label>
						<label><a href="https://ethplorer.io/address/<?= $addr ?>"><?= $addr ?></a></label>
                    </div>
                    <div class="field">
                        <label>Balance</label>
						<label><?php printf('%.8f', $system_bal) ?> ETH</label>
                    </div>
                </div>
                <!--<button class="ts primary button">Recharge</button>-->
            </form>
        </div>
    </section>

	<section class="ts narrow container">
		<h3 class="ts left aligned header">Exchange</h3>
		<div class="ts negative message" id="exchange_error" style="display: none;">
			<div class="header" id="exchange_error_title">Not enough ETH balance to exchange</div>
			<p id="exchange_error_detail">Recharge by transfering ETH to your recharge address.</p>
		</div>
        <div class="ts very padded segment">
			<table class="ts celled table selectable">
				<thead>
					<tr>
						<th>ETH Cost</th>
						<th>Query Capability</th>
						<th>Exchange</th>
					</tr>
				</thead>
				<tbody>
				<?php
	foreach (exchange_rate() as $i){
		echo '<tr>';
		echo '<td>' . $i['ethcost'] . '</td>';
		echo '<td>' . $i['amount'] . '</td>';
		echo '<td><button class="ts primary button exchange" onclick="exchange(\'' . $i['ethcost'] . '\')">Exchange</button></td>';
		echo '</tr>';
	}
				?>
				</tbody>
			</table>
        </div>
	<script>
		function disableall(){
			elements = $('.exchange');
			for (i=0; i < elements.length; i++){
				elements[i].setAttribute('disabled', true);
			}
		}
		function enableall(){
			elements = $('.exchange');
			for (i=0; i < elements.length; i++){
				elements[i].removeAttribute('disabled');
			}
		}
		function exchange(amount){
			disableall();
			$.getJSON('/api/exchange.php?cost=' + amount, function(res){
				console.log(res);
				enableall();
				if (res.status == 'success'){
					location.reload();
				}else if (res.status == 'failed'){
					$('#exchange_error_title').text(res.error);
					$('#exchange_error_detail').text(res.error_detail);
					$('#exchange_error').show();
				}
			});
		}
	</script>
    </section>

	<section class="ts narrow container">
		<h3 class="ts left aligned header">Redeem</h3>
		<div class="ts positive message" id="redeem_success" style="display: none;">
			<div class="header">Redeemed Success!</div>
			<p id="redeem_success_detail"></p>
		</div>
		<div class="ts negative message" id="redeem_error" style="display: none;">
			<div class="header" id="redeem_error_title"></div>
			<p id="redeem_error_detail"></p>
		</div>
        <div class="ts very padded segment">
            <form class="ts form" action="javascript:redeem(this)">
                <div class="one fields">
                    <div class="field">
                        <label>Promo Code</label>
						<input id="code" placeholder="Try to type 'WELCOME', and click the button above"></input>
                    </div>
                </div>
                <button class="ts primary button" id="redeem">Redeem</button>
            </form>
        </div>
		<script>
			function redeem(form){
				$('#redeem').attr('disabled', true);
				$.getJSON('/api/redeem.php?code=' + form.code.value, function(res){
					console.log(res);
					if (res.status == 'success'){
						$('#redeem_success_detail').text('Used code "' + res.code + '" for ' + res.query_cap_added + ' query capability');
						$('#redeem_error').hide();
						$('#redeem_success').show();
					}else if (res.status == 'failed'){
						$('#redeem_error_title').text(res.error);
						$('#redeem_error_detail').text(res.error_detail);
						$('#redeem_error').show();
						$('#redeem_success').hide();
					}
					$('#redeem').attr('disabled', false);
				});
				return false;
			}
		</script>
    </section>

    <?php require 'src/footer.php'; ?>
