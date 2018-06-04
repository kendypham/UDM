<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include_once 'db_access.php';
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/search.css">
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="assets/js/xlsx.full.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.session.js"></script>
    <title>Database</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
			<!--Side bar-->
			<div class="sidenav">
				<?php
					GetServices();
				?>
			</div>	
			</div>
			<div class="col-md-6 container" id="content">
				<div class="row">
					<div id="prices">
						<?php
							GetPrices();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#prices").children().hide();
			$(".serv").click(function(){
				var s = $(this).attr("id");
				$("#p"+(s)).show();
				$(this).addClass('linkactive');
				$(this).siblings().removeClass('linkactive');
				$("#p"+(s)).siblings().hide();
			});
		})
	</script>
</body>
</html>