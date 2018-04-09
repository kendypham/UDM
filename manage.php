<?php 
	include("db_conf.php");
	if (!isset($_SESSION['username'])){
    echo ("<script>location.href='login.php'</script>");
 }
 ?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Update database</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<style type="text/css">
		ul.content {
			max-height: 550px ;
			overflow: auto;
		}
	</style>
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
</head>
<body style="overflow: hidden;">
	<!--Live search version, uncomment to test-->
	<!--<div class="container-fluid">
		<div class="row">
			<nav class="nav navbar" role="navigation">
				<ul class="navbar-nav navbar-right">
					<li class="nav-item">
						<a href="logout.php" class="nav-link">Logout</a>
					</li>

				</ul>
			</nav>
		</div>
		<div class="row">
			<div class="col-md-9 mx-auto">
				<div class="">
					<div>
						<input type="text" name="priceUpdate">
						<input type="submit" value="Update"/>
					</div>
				</div>
				<div class="container-fluid position-relative" style="top: 10%;">
					<table class="table table-hover" id="priceToUpdate" style="overflow: scroll;">
						<thead class="thead-dark">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Dịch vụ</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>-->
	<input type="button" id="logout" value="Logout"/>
	<form method="POST" action="func_update.php">
		<div class="form-group" >
				<ul class="content">
				<?php
				  	$sql1 = "SELECT * FROM DICHVU";

				 	$a = mysqli_query($link, $sql1);

				 	while ($row = $a->fetch_assoc()) {
				  		//<li type="checkbox">  value='".$row['TENDICHVU']."'>".$row['TENDICHVU']." </li>
				  		echo "<li> <input type='checkbox' name='service[]' value='".$row['ID']."'> ".$row['ID']."-".$row['TENDICHVU']." <br></li>";
				}
				?>
		  		</ul>
		   <input type="submit" value="Update"/>

		</div>
	</form>
	<script type="text/javascript">
		$("#logout").click(function(event) {
	 		console.log("dsds");
			location.href="logout.php";
  		});
	</script>
	<!--Live search js-->
	<!--<script type="text/javascript">
		$(document).ready(function(){
			var $postURL = "func_update.php?q=";
			var $pURL = "func_update.php?q=";

			$("#priceResult").hide();

			$("[name='priceUpdate']").keyup(function(){
				var $q = $(this).val();
				var $l = $q.length;
				
				if($l == 0){
					$("#priceResult").hide();
					$("#priceResult tbody").html("");
				}

				else if($l > 0){
					$.get("func_livesearch.php?q=" + $q, function(data, status){
						if(status == "success" && data !== ""){
							$("#priceResult").show();
							$("#priceResult tbody").html(data);
						}
					});
				}
			});

			$(".clickable").click(function(){
				var $id = $(this).attr('id');

				$(this).addClass("bg-info");

				if($pURL == $postURL){
					$pURL = $pURL + $id;
				}
				else{
					$pURL = $pURL + "%26" +$id;
				}
			});

			$(":submit").click(function(){
				$.post($pURL, function(data, status){
					return;
				});
			});
		})
	</script>-->
</body>
</html>