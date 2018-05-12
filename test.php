<?php
// example of how to use basic selector to retrieve HTML contents
include('assets/libs/simple_html_dom.php');
include('common.php');
include('db_access.php');
set_time_limit(0);

$services=array("Motel","1-star Hotel","2-star Hotel","3-star Hotel","4-star Hotel","5-star Hotel","Room for rent by hour","Room for rent by day","Room for rent by month","Home Stay by day","House/Villas for rent by day","House/Villas for rent by month");

date_default_timezone_set("Asia/Bangkok");
$today= date('Y-m-d');
$tomorrow= date("Y-m-d", strtotime("+1 day"));

//variable singleton
$arrProvinces;
Init($services,GetProvinceList());


//---------START-------
//echo GetHotelPrices("11931,377108,41125,66150,11850,12313");
//Insert_Khach_San($provinces);

Insert_Khach_San(GetProvinceList());
//Insert_Khach_San_05_Sao("Toàn Quốc","https://www.ivivu.com/khach-san-"."viet-nam");


//return price 
function GetHotelPrices($hotelIds) {
$url = 'https://pay.ivivu.com/api/contracting/HotelsSearchPrice';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, "RoomNumber=1&StatusMethod=2&SearchType=2&HotelIds=".$hotelIds."&RoomsRequest[0][RoomIndex]=1&RoomsRequest[0][Adults][label]=1&RoomsRequest[0][Adults][value]=2&RoomsRequest[0][Child][label]=0&CheckInDate=".$GLOBALS['today']."&CheckOutDate=".$GLOBALS['tomorrow']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type:application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
$jsonData = json_decode($result, true);

 $hotelSummary =$jsonData["HotelListResponse"]["HotelList"]["HotelSummary"];
 $count=0;
 $sum=0;
//    var_dump($hotelSummary);
//    return;
    if(!isset($hotelSummary)) return 0;
 foreach ($hotelSummary as $key) {
     $count+=1;
     $sum+=$key["lowRateOta"];
    
     echo $key["name"] ."XXX".$key["lowRateOta"] ."<br>";
      if($count>9) break;
    }

if($count)
    $sum=$sum/$count;
return (int)$sum;
}	
//Crawler
function Insert_Khach_San($provinces) {
    
    $i=0;
    foreach($provinces as $tag){
       echo "<br> ".$tag. "______________________________________ <br> ";
        $i+=1;
//				#region Custom Province
        if(strcmp($tag, "Đắk Lắk")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."daklak";
        else if(strcmp($tag, "TP Hồ Chí Minh")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."ho-chi-minh";
        else if(strcmp($tag, "Bình Thuận")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."lagi";
        else if(strcmp($tag, "An Giang")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."chau-doc";
        else if(strcmp($tag, "Bà Rịa - Vũng Tàu")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."vung-tau";
        else if(strcmp($tag, "Toàn Quốc")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."viet-nam";
        else
            $currentPath="https://www.ivivu.com/khach-san-".convert_vi_to_en($tag);
//         echo "$currentPath<br>";
 
        Insert_Khach_San_01_Sao($tag,$currentPath);
        Insert_Khach_San_02_Sao($tag,$currentPath);
        Insert_Khach_San_03_Sao($tag,$currentPath);
        Insert_Khach_San_04_Sao($tag,$currentPath);
        Insert_Khach_San_05_Sao($tag,$currentPath);

//        return;
        #endregion
    }
}
function Insert_Khach_San_05_Sao($currentProvince,$currentPath){
    $TAG="5-star Hotel";
		$url=$currentPath;
//    	$url=$currentPath ."?s=50";
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
    
//       $str =preg_replace('%<script\b(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|[^>"]++)*>(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|//.*?\n|/\*(?:[^\*]++|\*)*?\*/|[^<"/]++|/|(?R)|<)*?</\s*script>%si', '', $str);
		$html->load($str);
		foreach($html->find('script') as $element) {
			$text = $element->innertext;
            if(strpos($text,"hotelIdsLoadFirst"))
            {
                //Get id inner script tag
                $tmp=$text;
                $pos1=strpos($tmp,"{");
                $pos2=strpos($tmp,"}");
                $tmp=substr($tmp,$pos1,$pos2-$pos1+1);
                $a =json_decode($tmp);
                $hotelIds="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                }
                $hotelIds=substr($hotelIds,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds);
               InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
function Insert_Khach_San_04_Sao($currentProvince,$currentPath){
    $TAG="4-star Hotel";
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
    
//       $str =preg_replace('%<script\b(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|[^>"]++)*>(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|//.*?\n|/\*(?:[^\*]++|\*)*?\*/|[^<"/]++|/|(?R)|<)*?</\s*script>%si', '', $str);
		$html->load($str);
		foreach($html->find('script') as $element) {
			$text = $element->innertext;
            if(strpos($text,"hotelIdsLoadFirst"))
            {
                //Get id inner script tag
                $tmp=$text;
                $pos1=strpos($tmp,"{");
                $pos2=strpos($tmp,"}");
                $tmp=substr($tmp,$pos1,$pos2-$pos1+1);
                $a =json_decode($tmp);
                $hotelIds="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                }
                $hotelIds=substr($hotelIds,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds);
                
                InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
function Insert_Khach_San_03_Sao($currentProvince,$currentPath){
    $TAG="3-star Hotel";
		$url=$currentPath."?s=30";
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
    
//       $str =preg_replace('%<script\b(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|[^>"]++)*>(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|//.*?\n|/\*(?:[^\*]++|\*)*?\*/|[^<"/]++|/|(?R)|<)*?</\s*script>%si', '', $str);
		$html->load($str);
		foreach($html->find('script') as $element) {
			$text = $element->innertext;
            if(strpos($text,"hotelIdsLoadFirst"))
            {
                //Get id inner script tag
                $tmp=$text;
                $pos1=strpos($tmp,"{");
                $pos2=strpos($tmp,"}");
                $tmp=substr($tmp,$pos1,$pos2-$pos1+1);
                $a =json_decode($tmp);
                $hotelIds="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                }
                $hotelIds=substr($hotelIds,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds);
                InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
function Insert_Khach_San_02_Sao($currentProvince,$currentPath){
    $TAG="2-star Hotel";
		$url=$currentPath."?s=20" ;
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
    
//       $str =preg_replace('%<script\b(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|[^>"]++)*>(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|//.*?\n|/\*(?:[^\*]++|\*)*?\*/|[^<"/]++|/|(?R)|<)*?</\s*script>%si', '', $str);
		$html->load($str);
		foreach($html->find('script') as $element) {
			$text = $element->innertext;
            if(strpos($text,"hotelIdsLoadFirst"))
            {
                //Get id inner script tag
                $tmp=$text;
                $pos1=strpos($tmp,"{");
                $pos2=strpos($tmp,"}");
                $tmp=substr($tmp,$pos1,$pos2-$pos1+1);
                $a =json_decode($tmp);
                $hotelIds="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                }
                $hotelIds=substr($hotelIds,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds);
                InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
function Insert_Khach_San_01_Sao($currentProvince,$currentPath){
    $TAG="1-star Hotel";
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
    
//       $str =preg_replace('%<script\b(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|[^>"]++)*>(?:"(?:[^"\\\\\\\\]++|\\\\\\\\.)*+"|\'(?:[^\\\\\\\\]++|\\\\\\\\.)*+\'|//.*?\n|/\*(?:[^\*]++|\*)*?\*/|[^<"/]++|/|(?R)|<)*?</\s*script>%si', '', $str);
		$html->load($str);
		foreach($html->find('script') as $element) {
			$text = $element->innertext;
            if(strpos($text,"hotelIdsLoadFirst"))
            {
                //Get id inner script tag
                $tmp=$text;
                $pos1=strpos($tmp,"{");
                $pos2=strpos($tmp,"}");
                $tmp=substr($tmp,$pos1,$pos2-$pos1+1);
                $a =json_decode($tmp);
                $hotelIds="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                }
                $hotelIds=substr($hotelIds,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds);
                InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
function InsertToExcel($service,$currentProvince,$price){
    LoadFile();
    
    $arrProvinces= GetProvinceList();
    $posService=array_search($service, $GLOBALS['services']);
//     echo "<br> LOG : Dich vu". $service."".$posService."XX<br>";
  //  var_dump($GLOBALS['services']);
    if(strcmp($currentProvince,$arrProvinces[63])==0){
         $GLOBALS['excelReader']->setActiveSheetIndex(0)
            ->setCellValue('B'.($posService+2),$price);
     echo "LOG : Dv".$service ."-".$currentProvince." pos:".'B'.($posService+2)." price:".$price."<br>";
    }
        
    else{
        $posProvince=array_search($currentProvince, $arrProvinces);
         $GLOBALS['excelReader']->setActiveSheetIndex(0)
            ->setCellValue(COLUMNS_NAME[$posProvince+2].($posService+2),$price);
        
  
        echo "LOG : Dv".$service ."-".$currentProvince." pos:".COLUMNS_NAME[$posProvince+2].($posService+2)." price:".$price."<br>";
    }
     
    //Log
    InserLog($service,$currentProvince,$price);
    SaveFile();
};
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