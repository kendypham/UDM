<?php
// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
include('db_conf.php');
include('common.php');
ini_set('max_execution_time', 0); 
$provinces= GetAllprovince(); 
#region
RemoveAllPrice();
Insert_Rao_Vat_Dat_Ban($provinces);
Insert_Rao_Vat_Nha_Ban($provinces);
Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces);
Insert_Rao_Vat_May_Quay_Phim($provinces);
Insert_Rao_Vat_Ban_O_To_Cu($provinces);
Insert_Rao_Vat_Ban_Xe_May_Cu($provinces);
Insert_Rao_Vat_Cay_Canh() ;
Insert_Rao_Vat_Cay_Giong();
// Hàm lấy dữ liệu 5 dịch vụ liên quan khách sạn
Insert_Khach_San($provinces);

#endregion

//Các hàm hỗ trợ
//--------------------------------------------------

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
	foreach ( $provinces as $key => $value ) {
		$html = file_get_html('https://muaban.net/ban-dat-'.$key.'-c31');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;
	// 	//DEBUG: 
	// echo '<br> '.$value .": ". $tmp ;
			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
		//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: Đất bán",$tmp) ;
	//sleep(1);
		unset($html);
	}
	echo "<br> ----------------Updated: \"Rao vặt: Đất bán\"------------------ ";
}
//INFO: Rao vặt: Điện thoại/Máy tính/Laptop
//key : name unsign, value :province name
function Insert_Rao_Vat_Dien_Thoai_May_Tinh($provinces) {

	foreach (  $provinces as $key => $value ) {

		//Lay gia trung binh dien thoai
		$html = file_get_html('https://muaban.net/dien-thoai-di-dong-'.$key.'-c62');
		$tmp= 0.0;
		$i=0;
		

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;

			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;

		//Lay gia trung binh laptop
		$html1 = file_get_html('https://muaban.net/may-vi-tinh-laptop-may-chu-'.$key.'-c63');
		$tmp1 = 0.0;
		$i1 =0;

		foreach($html1->find('span.mbn-price') as $element) {
			$text = $element->innertext;

			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp1 += (int) $text;
				$i1= $i1+1 ;
			}

			if( $i1>9 )
				break;
		}

		$result=0.0;

		if($i)
			$tmp=$tmp/$i;

		$result += $tmp;

		if($i1){
			$tmp1=$tmp1/$i1;
			//TInh trung binh giua gia dien thoai laptop 
			$result = 0.5* ($result +$tmp1);
		}


			//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: Điện thoại/Máy tính/Laptop",$result) ;
	//sleep(1);
		unset($html);
		unset($html1);
	}
	echo "<br> ----------------Updated: \"Rao vặt: Điện thoại/Máy tính/Laptop\"------------------ ";
}


//INFO: Rao vặt: Đất bán
//key : name unsign, value :province name
function Insert_Rao_Vat_May_Quay_Phim($provinces) {
	foreach ( $provinces as $key => $value ) {

		$html = file_get_html('https://muaban.net/may-anh-may-quay-'.$key.'-c64');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;
	// 	//DEBUG: 
	// echo '<br> '.$value .": ". $tmp ;
			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
		//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: máy quay phim, chụp hình",$tmp) ;
	//sleep(1);
		unset($html);
	}
		echo "<br> ----------------Updated: \"Rao vặt: máy quay phim, chụp hình\"------------------ ";
}

//INFO: Rao vặt: Nhà bán
//key : name unsign, value :province name
function Insert_Rao_Vat_Nha_Ban($provinces) {

	foreach (  $provinces as $key => $value ) {

		$html = file_get_html('https://muaban.net/ban-nha-can-ho-'.$key.'-c32');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;

			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
			//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: Nhà bán",$tmp) ;
	//sleep(1);
		unset($html);
	}
	echo "<br> ----------------Updated: \"Rao vặt: Nhà bán\"------------------ ";
}

//INFO: Rao vặt: xe hơi cũ
//key : name unsign, value :province name
function Insert_Rao_Vat_Ban_O_To_Cu($provinces) {

	foreach (  $provinces as $key => $value ) {

		$html = file_get_html('https://muaban.net/ban-o-to-'.$key.'-c41');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;

			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
			//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: xe hơi cũ",$tmp) ;
	//sleep(1);
		unset($html);
	}
	echo "<br> ----------------Updated: \"Rao vặt: xe hơi cũ\"------------------ ";
}

//INFO: Rao vặt: xe máy cũ
//key : name unsign, value :province name
function Insert_Rao_Vat_Ban_Xe_May_Cu($provinces) {

	foreach (  $provinces as $key => $value ) {

		$html = file_get_html('https://muaban.net/ban-o-to-'.$key.'-c51');
		$tmp= 0.0;
		$i=0;

		foreach($html->find('span.mbn-price') as $element) {
			$text = $element->innertext;

			if ((strpos($text, 'tỷ')) && !(strpos($text, 'triệu')) ) {
				$text = preg_replace("/ tỷ /", '000000000', $text);
			}
			else{
				$text = preg_replace("/ tỷ /", '', $text);
				$text = preg_replace("/ triệu/", '000000', $text);
				$text = str_replace(".", "", $text);
			}
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
			//echo '<br> '.$value .": ". $tmp ;

		InsertData($value,"Rao vặt: xe máy cũ",$tmp) ;
	//sleep(1);
		unset($html);
	
	}
		echo "<br> ----------------Updated: \"Rao vặt: xe máy cũ\"------------------ ";
}
//INFO: Cây cảnh
//key : name unsign, value :province name
function Insert_Rao_Vat_Cay_Canh() {
		$value ="Toàn Quốc";
		$url="http://cayvahoa.net/cay-canh";

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

		foreach($html->find('span.price') as $element) {
			$text = $element->innertext;

			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			//DEBUG:
			 // echo '<br> <br> <br> '.$value .": ". $tmp ;
		}
		if($i)
			$tmp=$tmp/$i;
		//echo '<br> '.$value .": ". $tmp ;
		InsertData($value,"Cây cảnh",$tmp) ;
	//sleep(1);
		unset($html);
	
	echo "<br> ----------------Updated: \"Cây cảnh\"------------------ ";
}

//INFO: Cây giống
//key : name unsign, value :province name
function Insert_Rao_Vat_Cay_Giong() {
		$value ="Toàn Quốc";
		$url="http://sieuthinhanong.vn/";

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

		foreach($html->find('div.price-box span.regular-price span.price') as $element) {
			$text = $element->innertext;

			$text = str_replace(".", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);
			// DEBUG:
			//echo '<br> <br> <br> '.": ". $text ;
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
			// DEBUG:
			  // echo '<br> <br> <br> '.$value .": ". $tmp ;
		}
		if($i)
			$tmp=$tmp/$i;
		//echo '<br> '.$value .": ". $tmp ;
		InsertData($value,"Cây giống",$tmp) ;
	//sleep(1);
		unset($html);
	
	echo "<br> ----------------Updated: \"Cây giống\"------------------ ";
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