<?php
// example of how to use basic selector to retrieve HTML contents
include('assets/libs/simple_html_dom.php');
set_time_limit(0);
date_default_timezone_set("Asia/Bangkok");
//echo date("'d-m-Y H:i:s'");
$provinces= null; 
$arrProvinces;
// if (!isset($_SESSION['username'])){
// 	echo "<script type='text/javascript'>alert('Login failed');</script>";
// 	echo ("<script>location.href='login.php'</script>");
// 	return;
//  }
#region
// RemoveAllPrice();
// Insert_Rao_Vat_Dat_Ban($provinces);
// Insert_Rao_Vat_Nha_Ban($provinces);
// Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces);
// Insert_Rao_Vat_May_Quay_Phim($provinces);
// Insert_Rao_Vat_Ban_O_To_Cu($provinces);
// Insert_Rao_Vat_Ban_Xe_May_Cu($provinces);
// Insert_Rao_Vat_Cay_Canh() ;
// Insert_Rao_Vat_Cay_Giong();
// // Hàm lấy dữ liệu 5 dịch vụ liên quan khách sạn
// Delete_Khach_San();
// Insert_Khach_San($provinces);
#endregion
// Insert_Rao_Vat_Dat_Ban($provinces);
//Các hàm hỗ trợ
//--------------------------------------------------
//Insert_Cho_O() ;
//echo GetHotelPrices("11931,377108,41125,66150,11850,12313");
//Insert_Khach_San($provinces);
print_r(GetProvinceList());

function Insert_Cho_O() {
		$value ="Toàn Quốc";
		$url="http://www.minhphuongfruit.com/";
		$html = file_get_html($url);	
		$tmp= 0.0;
		$i=0;
		foreach($html->find(".v2-home-pr-item-price") as $element) {
			$text = $element->innertext;
			//echo '<br> raw'. $text ;
			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				//echo '<br> >>>>>>'. (int) $text;
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			//DEBUG:
			// echo '<br> <br> <br> '.$value .": ". $tmp ;
		}
		//echo "chia  ".$tmp ."cho" . $i;
		if($i)
			$tmp=$tmp/$i;
		//echo "KQQQ: ". $tmp;
		
}
//return json data
function GetHotelPrices($arrIds) {
$url = 'https://pay.ivivu.com/api/contracting/HotelsSearchPrice';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, "RoomNumber=1&StatusMethod=2&HotelIdInternal=".$arrIds."&RoomsRequest[0][RoomIndex]=1&RoomsRequest[0][Adults][label]=1&RoomsRequest[0][Adults][value]=2&RoomsRequest[0][Child][label]=0&CheckInDate=2018-05-10&CheckOutDate=2018-05-11");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type:application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
return $result;
}
function Insert_Khach_San($provinces) {
	//	foreach ( $provinces as $key => $value ) {
		$url="https://www.ivivu.com/khach-san-viet-nam";
		$curl=curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_REFERER, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		$str=curl_exec($curl);
		curl_close($curl);
		$html = new simple_html_dom();
		$html->load($str);
		//echo "<br> <br> ". $html->plaintext;
		// $tmp= 0.0;
		// $i=0;
		foreach($html->find('ul.left-region li a') as $element) {
			//$text = $element->innertext;
			$currentPath= "https:". $element->href;
			$currentProvince = null;
			// Tìm tên vùng ứng với link
			foreach($provinces as $tag){
				#region Custom Province
				if(strpos($element->href, "daklak")) {
					$currentProvince = "Đắk Lắk";
					break;
					}
				else if(strpos($element->href, "ho-chi-minh") ){
					$currentProvince="TP Hồ Chí Minh";
					break;
					}
				else if(strpos($element->href, "lagi") ){
					$currentProvince="Bình Thuận";
					break;
					}
				else if(strpos($element->href, "chau_doc") ){
					$currentProvince="An Giang";
					break;
				}
				else if(strpos($element->href, "vung-tau") ){
					$currentProvince="Bà Rịa - Vũng Tàu";
					break;
				}
				else if(strpos($element->href, convert_vi_to_en($tag))){
					$currentProvince =$tag;
					break;
				}
				#endregion 
			}
			// Try parse link html
            echo $currentProvince;
//			if(strlen($currentProvince)){
//				Insert_Khach_San_01_Sao($currentProvince,$currentPath);
//				Insert_Khach_San_02_Sao($currentProvince,$currentPath);
//				Insert_Khach_San_03_Sao($currentProvince,$currentPath);
//				Insert_Khach_San_04_Sao($currentProvince,$currentPath);
//				Insert_Khach_San_05_Sao($currentProvince,$currentPath);
//			}
		}
	}

function GetProvinceList(){
    if(isset($GLOBALS['arrProvinces']))
        return $GLOBALS['arrProvinces'];
    $GLOBALS['arrProvinces']= array();
ThemVung( "An Giang","3536.7");
ThemVung( "Bà Rịa - Vũng Tàu","1989.5");
ThemVung( "Bắc Giang","3844");
ThemVung( "Bắc Kạn","4859.4");
ThemVung( "Bạc Liêu","2468.7");
ThemVung( "Bắc Ninh","822.7");
ThemVung( "Bến Tre","2360.6");
ThemVung( "Bình Định","6050.6");
ThemVung( "Bình Dương","2694.4");
ThemVung( "Bình Phước","6871.5");
ThemVung( "Bình Thuận","7812.9");
ThemVung( "Cà Mau","5294.9");
ThemVung( "Cần Thơ","1409");
ThemVung( "Cao Bằng","6707.9");
ThemVung( "Đà Nẵng","1285.4");
ThemVung( "Đắk Lắk","13125.4");
ThemVung( "Đắk Nông","6515.6");
ThemVung( "Điện Biên","9562.9");
ThemVung( "Đồng Nai","5907.2");
ThemVung( "Đồng Tháp","3377");
ThemVung( "Gia Lai","15536.9");
ThemVung( "Hà Giang","7914.9");
ThemVung( "Hà Nam","860.5");
ThemVung( "Hà Nội","3328.9");
ThemVung( "Hà Tĩnh","5997.2");
ThemVung( "Hải Dương","1656");
ThemVung( "Hải Phòng","1523.4");
ThemVung( "Hậu Giang","1602.5");
ThemVung( "Hoà Bình","4608.7");
ThemVung( "Hưng Yên","926");
ThemVung( "Khánh Hoà","5217.7");
ThemVung( "Kiên Giang","6348.5");
ThemVung( "Kon Tum","9689.6");
ThemVung( "Lai Châu","9068.8");
ThemVung( "Lâm Đồng","9773.5");
ThemVung( "Lạng Sơn","8320.8");
ThemVung( "Lào Cai","6383.9");
ThemVung( "Long An","4492.4");
ThemVung( "Nam Định","1651.4");
ThemVung( "Nghệ An","16493.7");
ThemVung( "Ninh Bình","1390.3");
ThemVung( "Ninh Thuận","3358.3");
ThemVung( "Phú Thọ","3533.4");
ThemVung( "Phú Yên","5060.6");
ThemVung( "Quảng Bình","8065.3");
ThemVung( "Quảng Nam","10438.4");
ThemVung( "Quảng Ngãi","5153");
ThemVung( "Quảng Ninh","6102.4");
ThemVung( "Quảng Trị","4739.8");
ThemVung( "Sóc Trăng","3311.6");
ThemVung( "Sơn La","14174.4");
ThemVung( "Tây Ninh","4039.7");
ThemVung( "Thái Bình","1570");
ThemVung( "Thái Nguyên","3531.7");
ThemVung( "Thanh Hoá","11131.9");
ThemVung( "Thừa Thiên Huế","5033.2");
ThemVung( "Tiền Giang","2508.3");
ThemVung( "TP Hồ Chí Minh","2095.6");
ThemVung( "Trà Vinh","2341.2");
ThemVung( "Tuyên Quang","5867.3");
ThemVung( "Vĩnh Long","1496.8");
ThemVung( "Vĩnh Phúc","1236.5");
ThemVung( "Yên Bái","6886.3");
ThemVung( "Toàn Quốc","331210");
return $GLOBALS['arrProvinces'];
// echo "Hoàn tất cập nhật danh sách vùng";
}
function ThemVung($ten, $dt) {
	array_push($GLOBALS['arrProvinces'], $ten);   
 }
?>