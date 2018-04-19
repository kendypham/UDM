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
Insert_Cho_O() ;

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

?>