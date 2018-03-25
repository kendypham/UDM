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
	<title>button ADMIN</title>
	<style type="text/css">
		ul.content {
			max-height: 550px ;
			overflow: auto;
		}
	</style>

</head>
<body>
	<input type="button" id="logout" value="Logout"/>
	<form method="POST" action="func_update.php">
		<div class="form-group" >
				<ul class="content">
				<?php
				  	$sql1 = "SELECT * FROM DICHVU WHERE 1";

				 	$a = mysqli_query($link, $sql1);

				 	while ($row = $a->fetch_assoc()) {
				  		//<li type="checkbox">  value='".$row['TENDICHVU']."'>".$row['TENDICHVU']." </li>
				  		echo "<li> <input type='checkbox' name='service[]' value='".$row['ID']."'> ".$row['ID']."-".$row['TENDICHVU']." <br></li>";
				}
				?>
		  		</ul>
		   <input type="submit" value="Update"/>

		</div> <!-- hết form-group -->
	</form>
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
	 $("#logout").click(function(event) {
	 	console.log("dsds");
		location.href="logout.php";
  });
	</script>
</body>
</html>