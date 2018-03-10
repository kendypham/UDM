<?php 
include 'db_conf.php';
$key =  $_REQUEST['search'];

$query = "SELECT * FROM VUNG WHERE TENVUNG LIKE '%$key%'";


$a = mysqli_query($link, $query) or die(mysqli_error($link)."[".$query."]");;
while ($row = $a->fetch_assoc()) {
    echo $row["TENVUNG"]. '-'.$row["DIENTICH"] ."<br>" ;
}
?>