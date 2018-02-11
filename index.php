<?php include 'src/config.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Kexor</title>
<meta charset="utf-8">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="//fonts.googleapis.com/earlyaccess/notosanstc.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/tocas.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'src/og.php'; ?>
<style>
html, body
{
    height: 100%;
    width: 100%;
}
p
{
	font-size: 1.5em !important;
}
.mobile p
{
	font-size: 1em !important;
}
h1
{
	font-size: 3em !important;
	letter-spacing: 1px;
}
.mobile h1
{
	font-size: 2em !important;
}

</style>
</head>
<body style="background-image: url('images/main<?= rand(1,2) ?>.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center">
    <div style="position: absolute; width: 100%; height: 100%; background: radial-gradient(ellipse at center, rgba(0,0,0,0.50) 0%,rgba(0,0,0,0.65) 100%); display: flex;    align-items: center;
    justify-content: center;flex-direction: column;text-align: center;">

        <div class="large device only">
            <h1 class="ts center aligned inverted header">
                Kexor
                <div class="sub header">
					<p>Searching for removed videos from Youtube?</p>
                </div>
            </h1>

            <br>
			<?php
				if ($_SESSION['logined'] == 1){
			?>
			<a href="profile.php" class="ts inverted medium basic button">My Profile</a>
			<?php
				}else{
			?>
			<a href="login.php" class="ts inverted medium basic button">Start now</a>
			<?php
				}
			?>
        </div>

        <div class="mobile only">
            <h1 class="ts center aligned inverted header mobile">
                Kexor
                <div class="sub header">
					<p class="mobile">Searching for removed videos from Youtube?</p>
                </div>
            </h3>
            <a href="login.php" class="ts inverted small basic button">Login</a>
        </div>

    </div>
</body>
</html>
