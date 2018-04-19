<?php
// example of how to use basic selector to retrieve HTML contents
include('assets/libs/simple_html_dom.php');
include('db_conf.php');
include('common.php');
set_time_limit(0);

// if (!isset($_SESSION['username'])){
// 	echo "<script type='text/javascript'>alert('Login failed');</script>";
// 	echo ("<script>location.href='login.php'</script>");
// 	return;
//  }

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
if($tmp!=0)
		InsertData($value,"Rao vặt: Đất bán",$tmp) ;
	//sleep(1);
		unset($html);
	}
	LogHistory("Update ->Rao vặt: Đất bán") ;
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
if($result!=0)
		InsertData($value,"Rao vặt: Điện thoại/Máy tính/Laptop",$result) ;
	//sleep(1);
		unset($html);
		unset($html1);
	}
		LogHistory("Update ->Rao vặt: Điện thoại/Máy tính/Laptop") ;
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
		if($tmp!=0)
			InsertData($value,"Rao vặt: máy quay phim, chụp hình",$tmp) ;
	//sleep(1);
		unset($html);
	}
		LogHistory("Update ->Rao vặt: máy quay phim, chụp hình") ;
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
	if($tmp!=0)
		InsertData($value,"Rao vặt: Nhà bán",$tmp) ;
	//sleep(1);
		unset($html);
	}
	LogHistory("Update ->Rao vặt: Nhà bán") ;
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
	if($tmp!=0)
		InsertData($value,"Rao vặt: xe hơi cũ",$tmp) ;
	//sleep(1);
		unset($html);
	}
		LogHistory("Update ->Rao vặt: xe hơi cũ") ;
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
	if($tmp!=0)
		InsertData($value,"Rao vặt: xe máy cũ",$tmp) ;
	//sleep(1);
		unset($html);
	
	}
	LogHistory("Update ->Rao vặt: xe máy cũ") ;
}
//INFO: Cây cảnh
//key : name unsign, value :province name
function Insert_Cay_Canh() {
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
	if($tmp!=0)
		InsertData($value,"Cây cảnh",$tmp) ;
	//sleep(1);
		unset($html);
	
}

//INFO: Cây giống
//key : name unsign, value :province name
function Insert_Cay_Giong() {
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
	if($tmp!=0)
		InsertData($value,"Cây giống",$tmp) ;
	//sleep(1);
		unset($html);
		LogHistory("Update ->Cây giống") ;
}

function Insert_Thue_Xe_May($provinces) {
foreach ( $provinces as $key => $value ) {
	$html = file_get_html('https://muaban.net/cho-thue-xe-may-'.$key.'-c53');
	$tmp= 0.0;
	$i=0;
	//echo ('https://muaban.net/cho-thue-xe-may-'.$key.'-c53');
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
			echo "ssss".(int) $text;
		}

		if( $i>9 )
			break;
	}
	if($i)
		$tmp=$tmp/$i;
	//echo '<br> '.$value .": ". $tmp ."kdem: ".$i;
	if($tmp!=0)
	InsertData($value,"Xe máy",$tmp) ;
//sleep(1);
	unset($html);
}
LogHistory("Update ->Xe máy") ;
}

//INFO: Cửa hàng Điện tử văn phòng
//key : name unsign, value :province name
function Insert_Cua_Hang_Dien_Tu_Van_Phong($provinces) {
foreach ( $provinces as $key => $value ) {
	$html = file_get_html('https://muaban.net/ban-do-dung-van-phong-'.$key.'-c75');
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
if($tmp!=0)
	InsertData($value,"Cửa hàng Điện tử văn phòng",$tmp) ;
//sleep(1);
	unset($html);
}
LogHistory("Update ->Cửa hàng Điện tử văn phòng") ;
}
//INFO: Cửa hàng quần áo
//key : name unsign, value :province name
function Insert_Cua_Hang_Quan_Ao($provinces) {
foreach ( $provinces as $key => $value ) {
	$html = file_get_html('https://muaban.net/quan-ao-trang-phuc-'.$key.'-c21');
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
if($tmp!=0)
	InsertData($value,"Cửa hàng quần áo",$tmp) ;
//sleep(1);
	unset($html);
}
LogHistory("Update ->Cửa hàng quần áo") ;
}
//INFO: Cửa hàng giày dép
//key : name unsign, value :province name
function Insert_Cua_Hang_Giay_Dep($provinces) {
foreach ( $provinces as $key => $value ) {
	$html = file_get_html('https://muaban.net/giay-dep-tui-xach-'.$key.'-c22');
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
if($tmp!=0)
	InsertData($value,"Cửa hàng giày dép",$tmp) ;
//sleep(1);
	unset($html);
}
LogHistory("Update ->Cửa hàng giày dép") ;
}
//INFO: Phụ Kiện Thời Trang
//key : name unsign, value :province name
function Insert_Phu_Kien_Thoi_Trang($provinces) {
foreach ( $provinces as $key => $value ) {
	$html = file_get_html('https://muaban.net/trang-suc-phu-kien-'.$key.'-c24');
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
if($tmp!=0)
	InsertData($value,"Phụ Kiện Thời Trang",$tmp) ;
//sleep(1);
	unset($html);
}
LogHistory("Update ->Phụ Kiện Thời Trang") ;

}

//INFO: Xẻ tải
//provinces :province name
function Insert_Xe_Tai() {
	$value ="Toàn Quốc";
	$url="http://xetaitoancau.net/san-pham/xe-tai-14542";

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

	foreach($html->find('span.price-new') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Xe tải",$tmp) ;
//sleep(1);
	unset($html);
LogHistory("Update ->Xe tải") ;

}

//INFO: Xe ba bánh
//provinces :provinces name
function Insert_Xe_Ba_Banh() {
	$value ="Toàn Quốc";
	$url="http://xebabanhchohang.vn/";

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

	foreach($html->find('.price') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Xe ba bánh",$tmp) ;
//sleep(1);
	unset($html);
	LogHistory("Update ->Xe ba bánh") ;
}

//INFO: Chăm sóc sức khỏe tại nhà
//provinces: province name
function Insert_Cham_Soc_Suc_Khoe_Tai_Nha() {
	$value ="Toàn Quốc";
	$url="https://ytetainhasaigon.com/services-2//";

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

	foreach($html->find('.av-catalogue-price') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Chăm sóc sức khỏe tại nhà",$tmp) ;
//sleep(1);
	unset($html);
		LogHistory("Update ->Chăm sóc sức khỏe tại nhà") ;
}

//INFO: Khu giải trí cho trẻ em
//provinces :provinces name
function Insert_Khu_Giai_Tri_Tre_Em() {
	$value ="Toàn Quốc";
	$url="http://vforum.vn/diendan/showthread.php?91206-Gia-ve-vao-cong-Dam-Sen-nuoc-va-Dam-Sen-kho-tron-goi-moi-nhat-2017";

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

	foreach($html->find('.cms_table_td') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Khu giải trí cho trẻ em",$tmp) ;
//sleep(1);
	unset($html);
	LogHistory("Update ->Khu giải trí cho trẻ em") ;

}

//INFO: Mẹ và bé
//provinces :provinces name
function Insert_Me_Va_Be() {
	$value ="Toàn Quốc";
	$url="https://concung.com/";

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

	foreach($html->find('.span-item-price') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Mẹ và bé",$tmp);
//sleep(1);
	unset($html);
	LogHistory("Update ->Mẹ và bé") ;

}

//INFO: Bảng điện tử led
//provinces: province name
function Insert_Bang_Dien_Tu_Led() {
	$value ="Toàn Quốc";
	$url="http://manhinhledquangcao.vn/san-pham/79-bang-dien-tu-led.html";

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

	foreach($html->find('.price-old') as $element) {
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
	if($tmp!=0)
	InsertData($value,"Bảng điện tử led",$tmp) ;
//sleep(1);
	unset($html);
	LogHistory("Update ->Bảng điện tử led") ;
}

function Insert_Cua_Hang_Dong_Ho() {
		$value ="Toàn Quốc";
		$url="http://www.dangquangwatch.vn/sp/t-1/Dong-ho-nam.html";

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

		foreach($html->find('span.new') as $element) {
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
		if($tmp!=0)
			InsertData($value,"Cửa hàng đồng hồ",$tmp) ;
	//sleep(1);
		unset($html);
	
	LogHistory("Update ->Cửa hàng đồng hồ") ;
}
// INFO : cửa hàng phụ tùng xe máy
// provinces: province name

function Insert_Cua_Hang_Phu_Tung_Xe_May($provinces) {
	foreach ( $provinces as $key => $value ) {
		$html = file_get_html('https://muaban.net/phu-tung-xe-may-'.$key.'-c55');
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
		if($tmp!=0)
			InsertData($value,"Cửa hàng phụ kiện xe máy",$tmp) ;
	//sleep(1);
		unset($html);
	}
	LogHistory("Update ->Cửa hàng phụ kiện xe máy") ;
}

// INFO: Cửa hàng mỹ phẩm
// PROVINCES :PROVINCE NAME
function Insert_Cua_Hang_My_Pham($provinces) {
	foreach ( $provinces as $key => $value ) {
		$html = file_get_html('https://muaban.net/my-pham-nuoc-hoa-'.$key.'-c23');
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
		if($tmp!=0)
			InsertData($value,"Cửa hàng mỹ phẩm",$tmp) ;
	//sleep(1);
		unset($html);
	}
	LogHistory("Update ->Cửa hàng mỹ phẩm") ;
}

// INFO: cửa hàng bán đồ thể thao
// provinces :province name
function Insert_Cua_Hang_Ban_Do_The_Thao() {
		$value ="Toàn Quốc";
		$url="https://yousport.vn/";

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

		foreach($html->find('span.new') as $element) {
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
		if($tmp!=0)
			InsertData($value,"Cửa hàng bán đồ thể thao",$tmp) ;
	//sleep(1);
		unset($html);
	
	LogHistory("Update ->Cửa hàng bán đồ thể thao") ;
}
// INFO: cua hang thuc pham thu cung
// provinces: province name
function Insert_Cua_Hang_Thuc_Pham_Thu_Cung() {
		$value ="Toàn Quốc";
		$url="http://www.petcity.vn/thuc-an/c10.html";

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

		foreach($html->find('.p-price') as $element) {
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
		if($tmp!=0)
			InsertData($value,"Cửa hàng thực phẩm thú cưng",$tmp) ;
	//sleep(1);
		unset($html);
	
		LogHistory("Update ->Cửa hàng thực phẩm thú cưng") ;
	}
function Insert_Dien_Thoai_May_Tinh() {
		$value ="Toàn Quốc";
		$url="https://www.dienmayxanh.com/dien-thoai";

		$html = file_get_html($url);	
		$tmp= 0.0;
		$i=0;

		foreach($html->find(".bginfo strong") as $element) {
			$text = $element->innertext;
			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);
			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}
			if( $i>9 )
				break;

		}
		if($i)
			$tmp=$tmp/$i;

		//Laptop
		$url="https://www.dienmayxanh.com/laptop";
		$html = file_get_html($url);	
		$tmp1= 0.0;
		$i=0;
		foreach($html->find(".bginfo strong") as $element) {
			$text = $element->innertext;
			//echo '<br> raw'. $text ;
			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp1 += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp1=$tmp1/$i;
		unset($html);
		unset($html1);
		$tmp=0.5*($tmp+$tmp1);
		if($tmp>0)
			InsertData($value,"Điện thoại/Máy tính/Laptop",$tmp) ;
		LogHistory("Update ->Điện thoại/Máy tính/Laptop") ;		
	}
	function Insert_Trai_Cay() {
		$value ="Toàn Quốc";
		$url="http://www.minhphuongfruit.com/";
		$html = file_get_html($url);	
		$tmp= 0.0;
		$i=0;
		foreach($html->find(".v2-home-pr-item-price") as $element) {
			$text = $element->innertext;
			$text = str_replace(",", "", $text);
			$text = preg_replace('/[^0-9]/', '',$text);

			if(((int) $text) > 0 ){
				$tmp += (int) $text;
				$i= $i+1 ;
			}

			if( $i>9 )
				break;
		}
		if($i)
			$tmp=$tmp/$i;
		if($tmp>0)
			InsertData($value,"Trái cây",$tmp) ;
		LogHistory("Update ->Trái cây") ;	
		
}
?>