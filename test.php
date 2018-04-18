<?php
// example of how to use basic selector to retrieve HTML contents
include('assets/libs/simple_html_dom.php');
include('db_conf.php');
include('common.php');
set_time_limit(0);
date_default_timezone_set("Asia/Bangkok");
echo date("'d-m-Y H:i:s'");
//$provinces= GetAllprovince(); 
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

function GetAllProvince() {
	$a = array();
	$query = "SELECT * FROM VUNG";
	$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");

	while($row = $result->fetch_assoc()){

		$province= $row["TENVUNG"];
		if($province ==='Toàn Quốc')
			break;
		$id= $row["ID"];
		if($id > 23)
			$id= $id+1;
		$provincefix= convert_vi_to_en($province);
		if($id<10){
			$a[$provincefix.  "-l0".$id] = $province; 
		}
		else{
			$a[$provincefix.  "-l".$id] = $province; 
		}
	}	
	return $a;
}

//INFO: Rao vặt: Đất bán
//key : name unsign, value :province name
function Insert_Rao_Vat_Dat_Ban($provinces) {
	
		//$html = file_get_html('https://muaban.net/ban-dat-'.$key.'-c31');
		$html = file_get_html('https://muaban.net/phu-tung-o-to-toan-quoc-l0-c45');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;
	// 	//DEBUG: 
	 		
			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				echo '<br> >>>>>>'. (int) $text;
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}

		if($i)
			$tmp=$tmp/$i;
		//echo '<br> '.$value .": ". $tmp ;

		//InsertData($value,"Rao vặt: Đất bán",$tmp) ;
	//sleep(1);
		unset($html);
	logErr("---------------Updated: \"Rao vặt: Đất bán\"------------------ ");
}
function Insert_Cho_O() {
		$value ="Toàn Quốc";
		$url="http://xome.vn/tim-kiem";

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
		//echo $html->innertext;	
		$tmp= 0.0;
		$i=0;

		foreach($html->find(".product-price") as $element) {
			$text = $element->innertext;
			echo '<br> raw'. $text ;
			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				echo '<br> >>>>>>'. (int) $text;
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			//DEBUG:
			 // echo '<br> <br> <br> '.$value .": ". $tmp ;
		}
		echo "chia  ".$tmp ."cho" . $i;
		if($i)
			$tmp=$tmp/$i;
		echo "tong ket: ".$tmp;
		//echo '<br> '.$value .": ". $tmp ;
		//InsertData($value,"Chỗ ở",$tmp) ;
	//sleep(1);
		unset($html);
	
	echo "<br> ----------------Updated: \" Chỗ ở\"------------------ ";
}

?>