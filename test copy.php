<?php
// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
include('db_conf.php');
include('common.php');

$provinces= GetAllprovince(); 
Insert_Khach_San($provinces);
// RemoveAllPrice();
// Insert_Rao_Vat_Cay_Giong(null);
#endregion

//Các hàm hỗ trợ
//--------------------------------------------------

function GetAllProvince() {
	$a = array();
	$query = "SELECT * FROM VUNG";
	$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");

	while($row = $result->fetch_assoc()){
		$province= $row["TENVUNG"];
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
//INFO: Khách sạn chung
//provinces :province name
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
			if(strlen($currentProvince)){
				//echo "<br>". $currentPath;
				//echo "-------". $currentProvince;
				Insert_Khach_San_Khong_Danh_Sao($currentProvince,$currentPath);
			//	echo "<br> DEBUG:".$currentProvince ."::".$currentPath; 
				Insert_Khach_San_01_Sao($currentProvince,$currentPath);
				Insert_Khach_San_02_Sao($currentProvince,$currentPath);
				Insert_Khach_San_03_Sao($currentProvince,$currentPath);
				Insert_Khach_San_04_Sao($currentProvince,$currentPath);
				Insert_Khach_San_05_Sao($currentProvince,$currentPath);
			}
		}
	}

//INFO: Khách sạn không đánh sao
//provinces :province name
function Insert_Khach_San_Khong_Danh_Sao($currentProvince,$currentPath){
		
		$url=$currentPath;

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Insert_Khach_San_Khong_Danh_Sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn không đánh sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn không đánh sao\"------------------ ";
}

//INFO: Khách sạn 01 sao
//provinces :province name
function Insert_Khach_San_01_Sao($currentProvince,$currentPath){
		
		$url=$currentPath ."?s=10";

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Khách sạn 01 sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn 01 sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn 01 sao\"------------------ ";
}

//INFO: Khách sạn 02 sao
//provinces :province name
function Insert_Khach_San_02_Sao($currentProvince,$currentPath){
		
		$url=$currentPath ."?s=20";

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Khách sạn 02 sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn 02 sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn 02 sao\"------------------ ";
}
//INFO: Khách sạn 03 sao
//provinces :province name
function Insert_Khach_San_03_Sao($currentProvince,$currentPath){
		
		$url=$currentPath ."?s=30";

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Khách sạn 03 sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn 03 sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn 03 sao\"------------------ ";
}
//INFO: Khách sạn 04 sao
//provinces :province name
function Insert_Khach_San_04_Sao($currentProvince,$currentPath){
		
		$url=$currentPath ."?s=40";

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Khách sạn 04 sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn 04 sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn 04 sao\"------------------ ";
}
//INFO: Khách sạn 05 sao
//provinces :province name
function Insert_Khach_San_05_Sao($currentProvince,$currentPath){
		
		$url=$currentPath ."?s=50";

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

		 $tmp= 0.0;
		 $i=0;
		foreach($html->find('.price-num') as $element) {
			$text = $element->innertext;
			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			 
		}
		if($i)
			$tmp=$tmp/$i;
		echo '<br> Khách sạn 05 sao'.$currentProvince .": ". $tmp ;
		InsertData($currentProvince,"Khách sạn 05 sao",$tmp) ;
	//sleep(1);
		unset($html);
	echo "<br> ----------------Updated: \"Khách sạn 05 sao\"------------------ ";
}

?>