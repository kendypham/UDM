<?php
include "db_conf.php";
$q = $_REQUEST['q'];
$ids = preg_split("/:/", $q);
$id_p = $ids[0];
$id_s = $ids[1];
mysqli_select_db($link,"BANGGIA");
$query = "SELECT * FROM BANGGIA WHERE ( ID_DICHVU = $id_s ) AND ( ID_VUNG = $id_p)";
$results = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

while ($row = $results->fetch_assoc()) {
	echo "<tr>\n<td>".findProvince($id_p)."</td>\n<td>".findService($id_s)."</td>\n<td>".$row['GIA']."VND</td>\n</tr>\n";
}

mysqli_close($link);
?>