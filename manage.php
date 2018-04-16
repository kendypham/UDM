<?php 
	include("db_conf.php");
	if (!isset($_SESSION['username'])){
		header('Location: login.php');
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
			list-style: none;
		}
	</style>

</head>
<body style="overflow: hidden; ">
  <div class="container ">
    <div class="row">
        <div class="col-md-9 m-auto">
		<hr/>
		<input type="checkbox" id="checkAll"> Check All
	<form method="POST" action="func_update.php">
		<div class="form-group" >
				<ul class="content">
				<?php
				  	$sql1 = "SELECT * FROM DICHVU";

				 	$a = mysqli_query($link, $sql1);

				 	while ($row = $a->fetch_assoc()) {
				  		echo "<li> <input type='checkbox' name='service[]' value='".$row['ID']."'> ".$row['ID']."-".$row['TENDICHVU']." <br></li>";
				}
				?>
		  		</ul>
		  	<hr/>
		  	<div class="row d-inline">
		   <input type="submit" value="Update"/>
		   <input class="float-right" type="button" id="logout" value="Logout"/>
		</div>
		</div>
	</form>
	</div>

</div>
</div>
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	 <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$("#logout").click(function(event) {
	 		//console.log("dsds");
			location.href="logout.php";
  		});
	  	$('#checkAll').click(function () {    
	   		$('input:checkbox').prop('checked', this.checked);    
	 });
	</script>
	
</body>
</html>