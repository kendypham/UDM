<?php 
	include("db_conf.php");
 ?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>button ADMIN</title>
	<style type="text/css">
		ol.content {
			height: 550px ;
			overflow: auto;
		}
	</style>
</head>
<body>
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
</body>
</html>