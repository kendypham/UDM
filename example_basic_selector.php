<?php
// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
include('db_conf.php');
include('common.php');


//INFO: Rao vat ban nha
$countries= GetAllCountry(); 
//key : name unsign, value :country name
foreach ( $countries as $key => $value ) {

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
		$tmp += (int) $text;
		$i= $i+1 ;

		if( $i>9 )
			break;
	}
	if($i )
		$tmp=$tmp/$i;
	echo '<br> '.$value .": ". $tmp ;

	InsertData($value,"Rao vặt: Nhà bán",$tmp);
	//sleep(1);
}

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

 ?>