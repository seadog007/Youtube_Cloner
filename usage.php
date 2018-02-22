    <?php $title = 'Search Result';
		require 'src/header.php';
		require 'src/common.php';
	?>

	<header class="ts borderless extra padded massive center aligned fluid jumbotron">
		<h1 class="ts header">Usage</h1>
	</header>


	<section class="ts narrow container">
	  <h3 class="ts left aligned header">Usage of video that the video ID start with</h3>
	  <div class="ts very padded segment">
	<p>Row is the first character, col as the second.</p>
	<p>System Total Cost: <?php system('tail -n1 src/log | awk \'{print $1" "$2}\'') ?></p>
	<div style="display:block; max-width:100%; max-height: 80vh; overflow: scroll;">
	<table class="ts striped celled table">
<?php
		$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
		$chars = str_split($charset);

		$lay1 = [];
		$res = shell_exec('grep \'Youtube\/.$\' src/log | awk \'{print substr($3,length($3),1)","$1" "$2}\'');
		$res = explode("\n", $res);
		array_pop($res);
		foreach($res as $item){
			$tmp = explode(',', $item);
			$lay1[$tmp[0]] = $tmp[1];
		}

		$lay2 = [];
		$res = shell_exec('grep \'\/.\/.$\' src/log | awk \'{print substr($3,length($3)-2,1)","substr($3,length($3),1)","$1" "$2}\'');
		$res = explode("\n", $res);
		array_pop($res);
		foreach($res as $item){
			$tmp = explode(',', $item);
			$lay2[$tmp[0]][$tmp[1]] = $tmp[2];
		}

		echo '<tr><td></td>';
		foreach($chars as $char){
			echo '<td>' . $char . '</td>';
		}
		echo '<td>Total</td></tr>';


		echo '';
		foreach($chars as $char1){
			echo '<tr><td>' . $char1 . '</td>';
			foreach($chars as $char2){
				echo '<td>' . $lay2[$char1][$char2] . '</td>';
			}
			echo '<td>' . $lay1[$char1] . '</td>';
			echo '</tr>';
		}
?>
</table>
</div>
      </div>
    </section>

    <?php require 'src/footer.php'; ?>
