<?php
// DATABASE
include("db_conf.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tìm kiếm</title>
</head>
<body>
	 <!-- <div class="wrapform"
		 <form action="1_submit" method="get" action="process.php" accept-charset="utf-8" class="form">
			<select name="dropdown" >
				<option value="TpHCM">TP Hồ Chí Minh</option>
				<option value="HN">Hà Nội</option>				
			</select>
			<input type="submit" name="search" value="Search">
		</form>  Hết form  -->

<div class="wrapform">
<form method="post" action="func_search.php">
	<div class="form-group">
        <label for="province">Nhập địa điểm</label>
  <select name="province">
	<?php
	  	$sql1 = "SELECT * FROM VUNG WHERE 1";

	 	$a = mysqli_query($link, $sql1);

	 	while ($row = $a->fetch_assoc()) {
	  		echo "<option value='".$row['TENVUNG']."'>".$row['TENVUNG']."</option>";
	}
	?>
  </select>
 <select name="service">
<?php
  	$sql1 = "SELECT * FROM DICHVU WHERE 1";

 	$a = mysqli_query($link, $sql1);

 	while ($row = $a->fetch_assoc()) {
  		echo "<option value='".$row['TENDICHVU']."'>".$row['TENDICHVU']."</option>";
}
?>
  </select>
   <input type="submit" value="Search"/>
</div> <!-- hết form-group -->

<div class="form-group">
	
</div><!-- hết form-group -->
<div class="form-group">
	<label for="Tính giá">Tính giá</label>
	

</div><!-- hết form-group -->

</form>
 	</div> <!-- Hết wrapform -->
</body>
</html>


	<!-- echo " <input type='checkbox' name='vehicle' value='Bike'> ".$row['TENDICHVU']."<br>"; -->s
