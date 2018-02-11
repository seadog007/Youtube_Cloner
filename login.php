    <?php $title="Login"; ?>
    <?php require 'src/header.php'; ?>

	<script>
	  window.fbAsyncInit = function() {
		FB.init({
		  appId      : <?= FB_API ?>,
		  cookie     : true,
		  xfbml      : true,
		  version    : 'v2.11'
		});

		FB.AppEvents.logPageView();
		FB.getLoginStatus(function(response) {
		  console.log(response);
		  if (response.status == 'connected'){
			window.location = '/api/login.php?token=' + response.authResponse.accessToken + (window.location.href.split('?')[1] ? ('&' + window.location.href.split('?')[1]) : '');
		  }else{
			$('#login').show();
			$('#loading').hide();
		  }
		});

	  };

	  function login(){
	 	FB.login(function(response){
			console.log(response);
		  if(response.authResponse){
			window.location = '/api/login.php?token=' + response.authResponse.accessToken + (window.location.href.split('?')[1] ? ('&' + window.location.href.split('?')[1]) : '');
	      }else{
		    console.log('User cancelled login or did not fully authorize.');
	      }
		}, {scope: ['user_about_me', 'email']});
	  }
	</script>

    <header class="ts borderless extra padded massive center aligned fluid jumbotron">
        <h1 class="ts header">Login</h1>
    </header>

	<span class="nyan" id="loading"></span>
    <section class="login form">
        <button class="ts primary fluid button" onclick="login()" style="display: none" id="login">Login with Facebook</button>
    </section>

    <?php require 'src/footer.php'; ?>
