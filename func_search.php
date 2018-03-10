<?php 
include 'db_conf.php';

$country =  $_REQUEST['country'];
$service =  $_REQUEST['service'];

if(strlen($country)<1 ||strlen($service)<1) return;


$query = "SELECT ID FROM VUNG WHERE TENVUNG LIKE '%$country%'";

$result_id_vung = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

$row = $result_id_vung->fetch_assoc();
$id_vung= $row["ID"];


$query = "SELECT ID FROM DICHVU WHERE TENDICHVU LIKE '%$service%'";

$result_id_dichvu = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

$row = $result_id_dichvu->fetch_assoc();
$id_dichvu= $row["ID"];
 

$query = "SELECT * FROM BANGGIA WHERE ( ID_DICHVU LIKE '$id_dichvu' ) AND ( ID_VUNG LIKE '$id_vung')";
echo "truy van :" . $query .'<br>';
$results = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");

while ($row = $results->fetch_assoc()) {
echo $country. '- '.$service .':'.$row["GIA"] ."<br>" ;
}


?>