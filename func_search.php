<?php 
include 'db_conf.php';

$province =  $_REQUEST['province'];
$service =  $_REQUEST['service'];
echo $province;
echo $service;
if(strlen($province)<1 ||strlen($service)<1) return;
// Database
$id_vung= FindIDprovince($province);
$id_dichvu= FindIDService($service);

$query = "SELECT * FROM BANGGIA WHERE ( ID_DICHVU LIKE '$id_dichvu' ) AND ( ID_VUNG LIKE '$id_vung')";
echo "truy van :" . $query .'<br>';
$results = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

while ($row = $results->fetch_assoc()) {
echo $province. '- '.$service .':'.$row["GIA"] ."<br>" ;
}
 mysqli_close($link);
?>