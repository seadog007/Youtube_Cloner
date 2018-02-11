<?php
require 'config.php';
$page = explode("/", $_SERVER["PHP_SELF"])[1];
if (($page != 'login.php') and $_SESSION['id'] == ''){
	header('Location: /login.php?ref=' . $page);
	die();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?= $title.' │ Kexor'?></title>
<meta charset="utf-8">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="//fonts.googleapis.com/earlyaccess/notosanstc.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/styles/tocas.css">
<link rel="stylesheet" type="text/css" href="/styles/simplemde.min.css">
<script src="/js/simplemde.min.js"></script>
<script>
  (function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/zh_TW/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  window.fbAsyncInit = function() {
		FB.init({
		  appId      : <?= FB_API ?>,
		  cookie     : true,
		  xfbml      : true,
		  version    : 'v2.11'
		});
  }
</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'src/og.php'; ?>
<style>
html
{
	position: relative;
	margin: 0;
	padding-bottom: 6rem;
	min-height: 100%;
}
.container > .header,
.card .header
{
    color: #757575 !important;
}
.container > h3.header
{
    margin-top: 2em !important;
}
nav
{
    margin-bottom: 0 !important;
}
*
{
    text-decoration: none;
}
a.segment
{
    display: block;
}

time
{
    margin: 0.6em
}

.header .label
{
    vertical-align: middle;
    margin-bottom: 0.3em;
    margin-left: 0.3em;
}

.header .sub.header
{
    opacity: 0.6
}

.login.form
{
    max-width: 300px;
    margin: 5em auto 2em auto;
}

.nyan
{
	content: url("/images/nyan.gif");
	margin: 5em calc(50% - 250px);
}

body
{
    background-color: #FBFBFB
}

.dropdown:only-child
{
    margin: 0 !important;
}

.login.form .button + .button
{
    margin-top: .8em;
}

.segment .content
{
    font-size: 1.1rem;
    line-height: 2em;
    color: #676666;
}
.segment .header.dividing
{
    border-bottom: 0.2rem solid #79A8B9;
    margin-top: .5em !important;
    margin-bottom: 1em !important;
}
.segment .header.dividing .sub.header
{
    margin-top: 1em !important;
    margin-bottom: 1em !important;
}
.segment .content p
{
    margin-top: 2em;
    margin-bottom: 2em;
}

.segment .divider
{
    margin-top: 2em;
    border-color: #d9d9d9 !important
}

.button
{
    text-align: center;
}

.three.wide.right.aligned.column span
{
    margin-right: 2em
}
.back.link
{
    padding: 16px 0 8px 0;
    display: inline-block;
    color: #888
}

.back.link i
{
    margin-right: 8px
}


footer
{
    background-color: #616161;
    padding-top: 3em;
    padding-bottom: 3em;
	position: absolute;
	width: 100vw;
	bottom: 0px;
}

.jumbotron:not(.info) .header
{
    color: #FFFFFF !important;
}

.jumbotron
{
    background-size: cover !important;
    background-repeat: no-repeat !important;
    background-image: url(images/jumbotron.jpg) !important;

}

.close.item
{
    display: none !important;
}

th, td
{
	text-align: center !important;
}

.label
{
	width: 7em;
}
@media (max-width: 767px)
{
    .stackable.to.left .column
    {
        text-align: left !important;
    }
    .close.item
    {
        display: block !important;
    }
    #largeMainNav:not(.stackable)
    {
        display: none;
    }
	.jumbotron
	{
		background-position: center center !important;
	}
	.nyan
	{
		margin: 5em calc(50% - 37.5vw);
		width: 75vw;
	}
	.narrow{
		width: auto !important;
	}
}

</style>
</head>
<body>
	<div class="fb-customerchat" page_id="<?= FB_PAGE?>">
	</div>
    <nav id="largeMainNav" class="ts pure inverted borderless fluid large menu">
        <div class="ts narrow container">
            <a class="brand item" href="index.php">Kexor</a>

			<?php
				if ($_SESSION['logined'] == 1){
			?>
			<a class="item" href="query.php">Search Now!</a>
			<?php
				}
			?>

            <div class="right menu">
				<?php
					if ($_SESSION['logined'] == 1){
				?>
				<a class="item" href="profile.php">Profile</a>
				<a class="item" href="logout.php">Logout</a>
				<?php
					}else{
				?>
				<a class="item" href="login.php?ref=<?= $page ?>">Login</a>
				<?php
					}
				?>
                <a class="close item" onclick="collapseMenu()"><i class="close icon"></i>Close</a>
            </div>
        </div>
    </nav>

    <nav id="mobileMainNav" class="ts mobile only pure inverted borderless fluid large menu">
        <div class="ts narrow container">
            <a class="brand item" href="index.php">Kexor</a>
            <div class="right menu">
                <a class="item" style="padding-left: 1em; padding-right: 1em; margin-right: -0.88rem;" onclick="expandMenu()"><i style="margin: 0" class="content icon"></i></a>
            </div>
        </div>
    </nav>

    <script>
        function expandMenu()
        {
            $('#largeMainNav').addClass('stackable');
            $('#mobileMainNav').addClass('hidden');
        }

        function collapseMenu()
        {
            $('#largeMainNav').removeClass('stackable');
            $('#mobileMainNav').removeClass('hidden');
        }
    </script>
