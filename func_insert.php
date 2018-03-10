<?php
// DATABASE
define('DB_HOST', 'localhost');
define('DB_NAME', 'UDM');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD);
if(!$link){
	die('Could not connect: ' .mysqlI_error($link));
}

$db_selected = mysqli_select_db($link,DB_NAME);

if(!$db_selected) {
	die ('Can\'t use' .DB_NAME . ':' . mysqli_error($link));
}  
ThemVung($link,"Nghệ An","16493.7" );
ThemVung($link,"Gia Lai","15536.9" );
ThemVung($link,"Sơn La","14174.4" );
ThemVung($link,"Đắk Lắk","13125.4" );
ThemVung($link,"Thanh Hoá","11131.9" );
ThemVung($link,"Quảng Nam","10438.4" );
ThemVung($link,"Lâm Đồng","9773.5" );
ThemVung($link,"Kon Tum","9689.6" );
ThemVung($link,"Điện Biên","9562.9" );
ThemVung($link,"Lai Châu","9068.8" );
ThemVung($link,"Lạng Sơn","8320.8" );
ThemVung($link,"Quảng Bình","8065.3" );
ThemVung($link,"Hà Giang","7914.9" );
ThemVung($link,"Bình Thuận","7812.9" );
ThemVung($link,"Yên Bái","6886.3" );
ThemVung($link,"Bình Phước","6871.5" );
ThemVung($link,"Cao Bằng","6707.9" );
ThemVung($link,"Đắk Nông","6515.6" );
ThemVung($link,"Lào Cai","6383.9" );
ThemVung($link,"Kiên Giang","6348.5" );
ThemVung($link,"Quảng Ninh","6102.4" );
ThemVung($link,"Bình Định","6050.6" );
ThemVung($link,"Hà Tĩnh","5997.2" );
ThemVung($link,"Đồng Nai","5907.2" );
ThemVung($link,"Tuyên Quang","5867.3" );
ThemVung($link,"Cà Mau","5294.9" );
ThemVung($link,"Khánh Hoà","5217.7" );
ThemVung($link,"Quảng Ngãi","5153" );
ThemVung($link,"Phú Yên","5060.6" );
ThemVung($link,"Thừa Thiên Huế","5033.2" );
ThemVung($link,"Bắc Kạn","4859.4" );
ThemVung($link,"Quảng Trị","4739.8" );
ThemVung($link,"Hoà Bình","4608.7" );
ThemVung($link,"Long An","4492.4" );
ThemVung($link,"Tây Ninh","4039.7" );
ThemVung($link,"Bắc Giang","3844" );
ThemVung($link,"An Giang","3536.7" );
ThemVung($link,"Phú Thọ","3533.4" );
ThemVung($link,"Thái Nguyên","3531.7" );
ThemVung($link,"Đồng Tháp","3377" );
ThemVung($link,"Ninh Thuận","3358.3" );
ThemVung($link,"Hà Nội","3328.9" );
ThemVung($link,"Sóc Trăng","3311.6" );
ThemVung($link,"Bình Dương","2694.4" );
ThemVung($link,"Tiền Giang","2508.3" );
ThemVung($link,"Bạc Liêu","2468.7" );
ThemVung($link,"Bến Tre","2360.6" );
ThemVung($link,"Trà Vinh","2341.2" );
ThemVung($link,"TPHồ Chí Minh","2095.6" );
ThemVung($link,"Bà Rịa - Vũng Tàu","1989.5" );
ThemVung($link,"Hải Dương","1656" );
ThemVung($link,"Nam Định","1651.4" );
ThemVung($link,"Hậu Giang","1602.5" );
ThemVung($link,"Thái Bình","1570" );
ThemVung($link,"Hải Phòng","1523.4" );
ThemVung($link,"Vĩnh Long","1496.8" );
ThemVung($link,"Cần Thơ","1409" );
ThemVung($link,"Ninh Bình","1390.3" );
ThemVung($link,"Đà Nẵng","1285.4" );
ThemVung($link,"Vĩnh Phúc","1236.5" );
ThemVung($link,"Hưng Yên","926" );
ThemVung($link,"Hà Nam","860.5" );
ThemVung($link,"Bắc Ninh","822.7" );

// $sql1 = "SELECT * FROM `VUNG` ";

// $a = mysqli_query($link, $sql1);


// while ($row = $a->fetch_assoc()) {
//     echo $row["TENVUNG"].$row["DIENTICH"] ."<br>" ;
// }
 mysqli_close($link);
// function
function ThemVung($link, $ten, $dt) {

	$sql = "INSERT INTO VUNG (TENVUNG, DIENTICH) VALUES ('$ten','$dt')";

	if(!mysqli_query($link, $sql)){
		die ('ERROR: ' . mysqli_error($link));
 }
}
?>
