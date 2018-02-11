    <?php $title = 'Search Result';
    require 'src/header.php';
	require 'src/common.php';
	$rid = (int)$_GET['rid'];
	$res = json_decode(user_result($rid, $_SESSION['id']), true);
	if ($res['status'] != 'success'){
		die();
	}
	$res = $res['result'];
	?>

    <header class="ts borderless extra padded massive center aligned fluid jumbotron">
        <h1 class="ts header">Result</h1>
    </header>


    <section class="ts narrow container">
	  <h3 class="ts left aligned header">Youtube Video Info</h3>
	  <div class="ts very padded segment">
<?php
		$status = $res['status'] ? 'On Youtube' : '<b style="color: red;">Removed from Youtube</b>';
		echo '<p>Video ID: ' . $res['vid'] . '</p>';
		echo '<p>Video Status: ' . $status . '</p>';
		echo '<p>Video Import Time: ' . $res['import_time'] . '</p>';
		echo '<p>Video Backup Folder: <a href="https://drive.google.com/drive/folders/' . $res['fid'] . '">' .  $res['fid'] . '</a></p>';
		if (!$res['status']){
			echo '<p>Original Video Name: ' . htmlspecialchars($res['video_name']) . '</p>';
			echo '<p>Video Disappear Since: ' . $res['disappear_time'] . '</p>';
		}else{
			echo '<p>Last check that still on Youtube: ' . $res['last_check'] . '</p>';
		}
?>
      </div>
    </section>

    <?php require 'src/footer.php'; ?>
