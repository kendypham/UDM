<?php
include "db_conf.php";
$q = $_REQUEST['q'];
$ids = preg_split("/&/", $q);
$id_p = $ids[0];
$id_s = $ids[1];
mysqli_select_db($link,"BANGGIA");
$query = "SELECT * FROM BANGGIA WHERE ID_DICHVU = $id_s ORDER BY ID_VUNG DESC LIMIT 1";
$results = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

$row = $results->fetch_assoc();
if(isset($row['ID_VUNG'])){
	if($row['ID_VUNG']==64){
		echo "<tr>\n<td>Toàn Quốc</td>\n<td>".findService($id_s)."</td>\n<td>".$row['GIA']." VND</td>\n</tr>\n";
	}
	else{
		$query = "SELECT * FROM BANGGIA WHERE ID_DICHVU = $id_s AND ID_VUNG = $id_p";
		 echo "<script>console.log( 'Debug Objects: " . $query . "' );</script>";
		$results = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");
		
		$row = $results->fetch_assoc();
			echo "<tr>\n<td>".findProvince($id_p)."</td>\n<td>".findService($id_s)."</td>\n<td>".$row['GIA']." VND</td>\n</tr>\n";
	}
}else
echo "<tr>\n<td>Toàn Quốc</td>\n<td>".findService($id_s)."</td>\n<td> Null</td>\n</tr>\n";
	
mysqli_close($link);
?>