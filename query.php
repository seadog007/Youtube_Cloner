    <?php $title = 'Search Form';
	require 'src/header.php';
	require 'src/common.php';
	$query_stat = query_count($_SESSION['id']); ?>


    <header class="ts borderless extra padded massive center aligned fluid jumbotron">
        <h1 class="ts header">Search Video</h1>
    </header>

	<section class="ts narrow container">
		<h3 class="ts left aligned header">Search Video
			<p style="line-height: 2.5em; float: right; font-size: 0.6em; color: #a7a7a7;">
			Query Capacity Left: <span id="cap_left"><?= $query_stat['query_capability'] - $query_stat['query_count'] ?></span>
			</p>
		</h3>
		<div class="ts negative message" id="missingkeyword" style="display: none;">
			<div class="header">Missing field</div>
			<p>Dudu, key in something.</p>
		</div>
        <div class="ts very padded segment">
            <form class="ts form" action="javascript:dosearch(this)">
                <div class="one fields">
                    <div class="field">
                        <label>Youtube ID (11 characters)</label>
						<input id="key" maxlength="11"></input>
                    </div>
                </div>
				<button class="ts primary button" type="submit" id="search">Search</button>
            </form>
        </div>
		<script>
			function dosearch(form){
				if (form.key.value == ''){
					$('#missingkeyword').show();
					return 0;
				}else{
					$('#missingkeyword').hide();
					$('#search').attr('disabled', true);
					$.getJSON('/api/search.php?vid=' + form.key.value, function(res){
						$('#search').attr('disabled', false);
						if (res.status == 'success'){
							$('#cap_left').text(res.cap_left);
							if (typeof(res.result_id) == "undefined"){
								alert('No result');
							}else{
								window.location = '/result.php?rid=' + res.result_id;
							}
						}
						console.log(res)
					})
				}
			}
		</script>
    </section>

    <?php require 'src/footer.php'; ?>
