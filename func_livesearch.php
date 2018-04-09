<?php
	include 'db_conf.php';
	$q = $_REQUEST['q'];

	$query = "SELECT * FROM DICHVU WHERE TENDICHVU LIKE '%".$q."' ORDER BY ID ASC";
	$result = mysqli_query($link, $query) or die("$link->error");

	while ($row=$result->fetch_assoc()){
		echo "<tr class=\"clickable\" id=\"".$row['ID']."\">\n<td>".$row['ID']."</td>\n<td>".$row['TENDICHVU']."</td>\n</tr>";
	}
?>