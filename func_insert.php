<?php
// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
include('db_conf.php');
include('common.php');

$countries= GetAllCountry(); 

// RemoveAllData();
// Insert_Rao_Vat_Dat_Ban($countries);
// Insert_Rao_Vat_Nha_Ban($countries);
// Insert_Rao_Vat_Dien_Thoai_May_Tinh($countries);
// Insert_Rao_Vat_May_Quay_Phim($countries);
	Insert_Rao_Vat_Ban_O_To_Cu($countries);
	Insert_Rao_Vat_Ban_Xe_May_Cu($countries);
#endregion

//Các hàm hỗ trợ
//--------------------------------------------------

function GetAllCountry() {
	$a = array();
	$query = "SELECT * FROM VUNG";
	$result = mysqli_query($GLOBALS['link'], $query) or die(mysqli_error($GLOBALS['link'])."[".$query."]");

	while($row = $result->fetch_assoc()){
		$country= $row["TENVUNG"];
		$id= $row["ID"];
		if($id > 23)
			$id= $id+1;
		$countryfix= convert_vi_to_en($country);
		if($id<10){
			$a[$countryfix.  "-l0".$id] = $country; 
		}
		else{
			$a[$countryfix.  "-l".$id] = $country; 
		}
	}	
	return $a;
}
//INFO: Rao vặt: Đất bán
//key : name unsign, value :country name
function Insert_Rao_Vat_Dat_Ban($countries) {
	foreach ( $countries as $key => $value ) {

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
//key : name unsign, value :country name
function Insert_Rao_Vat_Dien_Thoai_May_Tinh($countries) {

	foreach (  $countries as $key => $value ) {

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
//key : name unsign, value :country name
function Insert_Rao_Vat_May_Quay_Phim($countries) {
	foreach ( $countries as $key => $value ) {

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
//key : name unsign, value :country name
function Insert_Rao_Vat_Nha_Ban($countries) {

	foreach (  $countries as $key => $value ) {

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
//key : name unsign, value :country name
function Insert_Rao_Vat_Ban_O_To_Cu($countries) {

	foreach (  $countries as $key => $value ) {

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
//key : name unsign, value :country name
function Insert_Rao_Vat_Ban_Xe_May_Cu($countries) {

	foreach (  $countries as $key => $value ) {

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
?>