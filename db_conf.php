<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'UDM');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
// swiTmmiizcXJ
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD);
if(!$link){
	die('Could not connect: ' .mysqli_error($link));
}
$db_selected = mysqli_select_db($link,DB_NAME);

if(!$db_selected) {
	die ('Can\'t use' .DB_NAME . ':' . mysqli_error($link));
}  
//Khắc phục Lỗi font tiếng Việt
mysqli_query($link, "SET NAMES 'utf8'");

//Insert gia dich vu

function FindIDProvince($province){

$query = "SELECT ID FROM VUNG WHERE TENVUNG LIKE '%$province%'";
$result_id_vung = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_id_vung->fetch_assoc();
return $row["ID"];
}

function FindIDService($service){

$query = "SELECT ID FROM DICHVU WHERE TENDICHVU LIKE '%$service%'";
$result_id_dichvu = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_id_dichvu->fetch_assoc();
return $row["ID"];
}

//Thêm giá dịch vụ với tên vùng , dịch vụ, giá
function InsertData($province, $service,$price){
	//INSERT INTO `BANGGIA` (`ID`, `ID_DICHVU`, `ID_VUNG`, `GIA`) VALUES (NULL, '1', '9', '100');
$id_province = FindIDProvince($province);
$id_service = FindIDService($service);
$query = "INSERT INTO `BANGGIA` (`ID`, `ID_DICHVU`, `ID_VUNG`, `GIA`)  VALUES (NULL,'$id_service', '$id_province','$price')";
echo "<br> ::::". $query;
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}

function RemoveAllPrice(){
$query = "DELETE FROM `BANGGIA` WHERE 1";
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}

function RemoveAllProvince(){
$query = "DELETE FROM `VUNG` WHERE 1";
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}

function RemoveAllService(){
$query = "DELETE FROM `DICHVU` WHERE 1";
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}
function ResetAutoIncrement(){
$query = "ALTER TABLE VUNG AUTO_INCREMENT=1";
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}

function RemoveAllData(){
	ResetAutoIncrement();
	RemoveAllPrice();
	RemoveAllProvince();
	RemoveAllService();
}

?>



















