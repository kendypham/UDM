<?php
session_start(); 
define('DB_HOST', 'localhost');
define('DB_NAME', 'UDM');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
// Hide error ^^
//set_error_handler("customError");
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

function FindIDProvince($province){

$query = "SELECT ID FROM VUNG WHERE TENVUNG LIKE '$province'";
$result_id_vung = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_id_vung->fetch_assoc();
return $row["ID"];
}

function FindIDService($service){

$query = "SELECT ID FROM DICHVU WHERE TENDICHVU LIKE '$service'";
$result_id_dichvu = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_id_dichvu->fetch_assoc();
return $row["ID"];
}

function findProvince($id_p){
$query = "SELECT TENVUNG FROM VUNG WHERE ID = $id_p";
$result_vung = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_vung->fetch_assoc();
return $row['TENVUNG'];
}

function findService($id_s){
$query = "SELECT TENDICHVU FROM DICHVU WHERE ID = $id_s";
$result_dichvu = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
$row = $result_dichvu->fetch_assoc();
return $row["TENDICHVU"];
}

//Thêm giá dịch vụ với tên vùng , dịch vụ, giá
function InsertData($province, $service,$price){

$query3= "ALTER TABLE BANGGIA AUTO_INCREMENT=1";
$result3 = mysqli_query($GLOBALS['link'], $query3) or die(mysqli_error($GLOBALS['link'])."[".$query3."]");

	//INSERT INTO `BANGGIA` (`ID`, `ID_DICHVU`, `ID_VUNG`, `GIA`) VALUES (NULL, '1', '9', '100');
$id_province = FindIDProvince($province);
$id_service = FindIDService($service);
$query = "INSERT INTO `BANGGIA` (`ID`, `ID_DICHVU`, `ID_VUNG`, `GIA`)  VALUES (NULL,'$id_service', '$id_province','$price')";
logErr($query);
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}

function RemoveAllPrice(){
$query = "DELETE FROM `BANGGIA` WHERE 1";
$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");

$query2= "ALTER TABLE BANGGIA AUTO_INCREMENT=1";
$result2 = mysqli_query($GLOBALS['link'], $query2) or die(mysqli_error($GLOBALS['link'])."[".$query2."]");
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

$query1= "ALTER TABLE DICHVU AUTO_INCREMENT=1";
$result1 = mysqli_query($GLOBALS['link'], $query1) or die(mysqli_error($GLOBALS['link'])."[".$query1."]");

}
function LoginAdministactor($username,$password){
	$password = hash('sha256', $password);
	$query1= "SELECT * FROM USERS WHERE (username LIKE '$username') AND (password LIKE '$password') AND (permission LIKE '1')";
	$users = mysqli_query($GLOBALS['link'], $query1) or die(mysqli_error($GLOBALS['link'])."[".$query1."]");

	if(mysqli_num_rows($users)!=1) return "Login failed";

	$row = $users->fetch_assoc();
	return "success";
}
function RemoveAllData(){
	//RemoveAllPrice();
	RemoveAllProvince();
	RemoveAllService();
	ResetAutoIncrement();
}
function logErr($data){
$todate= date('d-m-Y'); 
  $logPath ="logs/".$todate."_log.txt";
  $mode = (!file_exists($logPath)) ? 'w':'a';
  $logfile = fopen($logPath, $mode);
  fwrite($logfile, "\r\n". $data);
  fclose($logfile);
}
function RemovePriceByID_DichVu($arrServices){
	$query="";
	$first = 1;
	foreach ($arrServices as $id_services) {
		$id_services = mysqli_real_escape_string($GLOBALS['link'], $id_services);
		if($first){
			$query = "DELETE FROM `BANGGIA` WHERE `BANGGIA`.`ID_DICHVU` = '$id_services'";
			$first= -1;
		}
		else{
			$query=$query." or `BANGGIA`.`ID_DICHVU` = '$id_services' ";
		}
	}
	$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");
}
function customError($errno, $errstr, $errfile, $errline) {
  echo "Error!";
}
?>



















