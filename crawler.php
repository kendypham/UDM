<?php
// example of how to use basic selector to retrieve HTML contents
include('assets/libs/simple_html_dom.php');
include('common.php');
include('db_access.php');
set_time_limit(0);

$services=array("Motel (single room)(24h)","Motel (double room)(24h)","1-star Hotel","2-star Hotel","3-star Hotel","4-star Hotel","5-star Hotel","Room for rent by hour (single room)","Room for rent by hour (double room)","Room for rent by day(single room)","Room for rent by day(double room)","Room for rent by month (single room)","Room for rent by month (double room)","Home Stay by day","House/Villas for rent by day","House/Villas for rent by month");

date_default_timezone_set("Asia/Bangkok");
$today= date('Y-m-d');
$tomorrow= date("Y-m-d", strtotime("+1 day"));

$key= $_GET['key'];

//variable singleton
$arrProvinces;
$USD= ConvertUSDToVND();

//echo $USD;
Init($services,GetProvinceList());

switch($key){
    case 0:
        Crawler_Motel();
        Insert_Khach_San(GetProvinceList());
        Crawler_Room_By_Hour();
        Crawler_Room_By_Day();
        Crawler_Room_By_Month();
        Crawler_Home_Stay_By_Day();
        Crawler_House_Villas_for_rent_by_day();
        Crawler_House_Villas_for_rent_by_month();
        break;
    case 1:
        Crawler_Motel();
        break;
    case 2:
         Insert_Khach_San(GetProvinceList());
        break;   
    case 3:
        Crawler_Room_By_Hour();
        Crawler_Room_By_Day();
        Crawler_Room_By_Month();
        break;
    case 4:
        Crawler_Home_Stay_By_Day();
        break;
    case 5:
       Crawler_House_Villas_for_rent_by_day();
        Crawler_House_Villas_for_rent_by_month();
        break;
    default :
        break;
        
}

//return price 
function GetHotelPrices($ids,$type) {
    
$url = 'https://pay.ivivu.com/api/contracting/HotelsSearchPrice';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    if($type==1)
        curl_setopt($ch, CURLOPT_POSTFIELDS, "RoomNumber=1&StatusMethod=2&SearchType=1&HotelIdInternal=".$ids."&RoomsRequest[0][RoomIndex]=1&RoomsRequest[0][Adults][label]=1&RoomsRequest[0][Adults][value]=2&RoomsRequest[0][Child][label]=0&CheckInDate=".$GLOBALS['today']."&CheckOutDate=".$GLOBALS['tomorrow']);
    else
        curl_setopt($ch, CURLOPT_POSTFIELDS, "RoomNumber=1&StatusMethod=2&SearchType=2&HotelIds=".$ids."&RoomsRequest[0][RoomIndex]=1&RoomsRequest[0][Adults][label]=1&RoomsRequest[0][Adults][value]=2&RoomsRequest[0][Child][label]=0&CheckInDate=".$GLOBALS['today']."&CheckOutDate=".$GLOBALS['tomorrow']);
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
function ConvertUSDToVND(){
    $str = file_get_contents("https://www.xe.com/currencyconverter/convert/?Amount=1&From=USD&To=VND");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    
    $rs= $html->find('span.uccResultAmount')[0]->innertext;
    $rs= (int) str_replace(",", '', $rs);   
    return $rs;
};
//Crawler
function Insert_Khach_San($provinces) {
    
    $i=0;
    foreach($provinces as $province){
       echo "<br> ".$province. "______________________________________ <br> ";
        $i+=1;
//		#region Custom Province
        if(strcmp($province, "Đắk Lắk")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."daklak";
        else if(strcmp($province, "TP Hồ Chí Minh")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."ho-chi-minh";
        else if(strcmp($province, "Bình Thuận")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."lagi";
        else if(strcmp($province, "An Giang")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."chau-doc";
        else if(strcmp($province, "Bà Rịa - Vũng Tàu")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."vung-tau";
        else if(strcmp($province, "Toàn Quốc")==0) 
            $currentPath="https://www.ivivu.com/khach-san-"."viet-nam";
        else
            $currentPath="https://www.ivivu.com/khach-san-".convert_vi_to_en($province);
//         echo "$currentPath<br>";
        Crawl_Hotel($province,$currentPath,$GLOBALS['services'][6],"?s=50");
        Crawl_Hotel($province,$currentPath,$GLOBALS['services'][5],"?s=40");	
        Crawl_Hotel($province,$currentPath,$GLOBALS['services'][4],"?s=30");
        Crawl_Hotel($province,$currentPath,$GLOBALS['services'][3],"?s=20");
        Crawl_Hotel($province,$currentPath,$GLOBALS['services'][2],"?s=10");
//      return;
        #endregion
    }
}
//Hotel
function Crawl_Hotel($currentProvince,$currentPath,$TAG,$end_path){
    $url=$currentPath .$end_path;
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
                $hotelIdInternal="";
                foreach ($a as $key => $value) { 
                  //  echo $key."->".$value."<br>"; 
                    $hotelIds.=",".$key;
                    $hotelIdInternal.=",".$value;
                }
                $hotelIds=substr($hotelIds,1);
                $hotelIdInternal=substr($hotelIdInternal,1);
               // $prices=Get
                echo "hotelIds:" . $hotelIds."<br>";
                echo "hotelIdInternal:" . $hotelIdInternal."<br>";
                //Call API to get prices
                $price=GetHotelPrices($hotelIds,2);
                if($price==0)
                    $price=GetHotelPrices($hotelIdInternal,1);
                InsertToExcel($TAG,$currentProvince,$price);
                break;
            }
		}
}
//Motel
function Crawler_Motel(){
    $currentProvince="Toàn Quốc";
    $TAG1=$GLOBALS['services'][0];
    $TAG2=$GLOBALS['services'][1];
    $str = file_get_contents("http://nhanghikimdong1.com/gia-thue-nha-nghi-o-ha-noi");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;

     $tmp=$html->find('tr td p span');
     $price= (int) str_replace(".", '', $tmp[14]->innertext);
     InsertToExcel($TAG1,$currentProvince, $price);
     $price= (int) str_replace(".", '', $tmp[26]->innertext);
     InsertToExcel($TAG2,$currentProvince, $price);

}
//Room
function Crawler_Room_By_Hour(){
    $currentProvince="Toàn Quốc";
    $TAG1=$GLOBALS['services'][7];
    $TAG2=$GLOBALS['services'][8];
    $str = file_get_contents("http://nhanghikimdong1.com/gia-thue-nha-nghi-o-ha-noi");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    $tmp=$html->find('tr td p span');
    //single
    $price1= (int) str_replace(".", '', $tmp[3]->innertext);
    $price2= (int) str_replace(".", '', $tmp[10]->innertext);
    InsertToExcel($TAG1,$currentProvince,"first :".$price1." + ".$price2);
    
    //couple
    $price1= (int) str_replace(".", '', $tmp[21]->innertext);
    $price2= (int) str_replace(".", '', $tmp[28]->innertext);
    InsertToExcel($TAG2,$currentProvince,"first :".$price1." + ".$price2);   
}
function Crawler_Room_By_Day(){
    $currentProvince="Toàn Quốc";
    
    //Phong don
    $TAG1=$GLOBALS['services'][9];
    $str = file_get_contents("http://adamasapartment.com/index.php/room/phong-don-theo-ngay/");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    foreach($html->find('.gdlr-item .gdlr-column-shortcode p') as $element){
        if(strpos($element->innertext,"$/ ngày")){
            $price =(int)$element->innertext;

            $price *=$GLOBALS['USD'];
            InsertToExcel($TAG1,$currentProvince,$price);   
            break;
        }
        
    };
    
    //Phong doi
    $TAG1=$GLOBALS['services'][10];
    $str = file_get_contents("http://adamasapartment.com/index.php/room/phong-doi-theo-ngay/");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    foreach($html->find('.gdlr-item .gdlr-column-shortcode p') as $element){
        if(strpos($element->innertext,"$/ ngày")){
            $price =(int)$element->innertext;
            $price *=$GLOBALS['USD'];
            InsertToExcel($TAG1,$currentProvince,$price);   
            break;
        }
        
    };
  
}
function Crawler_Room_By_Month(){
    $currentProvince="Toàn Quốc";
    
    //Phong don
    $TAG1=$GLOBALS['services'][11];
    $str = file_get_contents("http://adamasapartment.com/index.php/room/phong-don-theo-thang/");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    foreach($html->find('.gdlr-item .gdlr-column-shortcode p') as $element){
        if(strpos($element->innertext,"$/tháng")){
            $price =(int)$element->innertext;

            $price *=$GLOBALS['USD'];
            InsertToExcel($TAG1,$currentProvince,$price);   
            break;
        }
        
    };
    
    //Phong doi
    $TAG1=$GLOBALS['services'][12];
    $str = file_get_contents("http://adamasapartment.com/index.php/room/phong-doi-theo-thang/");
    $html = new simple_html_dom();
    $html->load($str);
    //echo $html;
    foreach($html->find('.gdlr-item .gdlr-column-shortcode p') as $element){
        if(strpos($element->innertext,"$/tháng")){
            $price =(int)$element->innertext;
            $price *=$GLOBALS['USD'];
            InsertToExcel($TAG1,$currentProvince,$price);   
            break;
        }
        
    };
  
}
function Crawler_Home_Stay_By_Day(){
    $currentProvince="Toàn Quốc";
    
    //Phong don
    $TAG=$GLOBALS['services'][13];
    $str = file_get_contents("http://www.westay.org/vi/p-62-host-1-homestay");
    $html = new simple_html_dom();
    $html->load($str);

    foreach($html->find('td') as $element){
       
        if(strpos($element->innertext,"đ/ngày")){
            $price= (int) str_replace(",", '',$element->innertext);
            InsertToExcel($TAG,$currentProvince,$price);   
            break;
        }
        
    };
}
//House/Villas for rent by day
function Crawler_House_Villas_for_rent_by_day(){
    $currentProvince="Toàn Quốc";
    //Phong don
    $TAG=$GLOBALS['services'][14];
    $str = file_get_contents("http://sotaynhadat.vn/nha-dat-cho-thue/cho-thue-biet-thu");
    $html = new simple_html_dom();
    $html->load($str);
    $i=0;
    $tmp=0;
    foreach($html->find('span.price') as $element){   
        $str = $element->innertext;
            if(strpos($str," Triệu ")){
                  $tmp+=((int) $str * 1000000);
                  $i+=1;
                if($i>9) break;
            }
              
    };
    if($i>0)
        $tmp /=$i;
     InsertToExcel($TAG,$currentProvince,$tmp);   
}

//House/Villas for rent by month
function Crawler_House_Villas_for_rent_by_month(){
    Crawler_Villas_By_Province("Toàn Quốc","http://sotaynhadat.vn/nha-dat-cho-thue/cho-thue-biet-thu/");
    Crawler_Villas_By_Province("TP Hồ Chí Minh","http://sotaynhadat.vn/cho-thue-biet-thu/ho-chi-minh");
    Crawler_Villas_By_Province("Hà Nội","http://sotaynhadat.vn/cho-thue-biet-thu/ha-noi");
    Crawler_Villas_By_Province("Đà Nẵng","http://sotaynhadat.vn/cho-thue-biet-thu/da-nang");
    Crawler_Villas_By_Province("Bà Rịa - Vũng Tàu","http://sotaynhadat.vn/cho-thue-biet-thu/ba-ria-vung-tau");
}
function Crawler_Villas_By_Province($currentProvince,$url){
    //Phong don
    $TAG=$GLOBALS['services'][15];
    $str = file_get_contents($url);
    $html = new simple_html_dom();
    $html->load($str);
    $i=0;
    $tmp=0;
    foreach($html->find('span.price') as $element){
        
        $str = $element->innertext;
        if(strpos($str,"USD/tháng")){
            $tmp+=((int) $str * $GLOBALS['USD']);
            $i+=1;
            if($i>9) break;
        } else if(strpos($str,"Triệu/tháng")){
            if(((int) $str) >1000)
                $str =(int) $str/ 1000;
            $tmp+=((int) $str * 1000000);
            $i+=1;
            if($i>9) break;
        }
    };
    if($i>0)
    $tmp /=$i;
    InsertToExcel($TAG,$currentProvince,$tmp);
}

//endCrawl
function InsertToExcel($service,$currentProvince,$price){
    if(strpos($price,"+")==0)
        if($price==0) return;
    LoadFile();
    $arrProvinces= GetProvinceList();
    $posService=array_search($service, $GLOBALS['services']);
//     echo "<br> LOG : Dich vu". $service."".$posService."XX<br>";
  //  var_dump($GLOBALS['services']);
    if(strcmp($currentProvince,$arrProvinces[63])==0){
         $GLOBALS['excelReader']->setActiveSheetIndex(0)
            ->setCellValue('B'.($posService+2),$price);
     echo "LOG : Dv ".$service ."-".$currentProvince." pos:".'B'.($posService+2)." price:".$price."<br>";
    }
        
    else{
        $posProvince=array_search($currentProvince, $arrProvinces);
         $GLOBALS['excelReader']->setActiveSheetIndex(0)
            ->setCellValue(COLUMNS_NAME[$posProvince+2].($posService+2),$price);
        
  
        echo "LOG : Dv ".$service ."-".$currentProvince." pos:".COLUMNS_NAME[$posProvince+2].($posService+2)." price:".$price."<br>";
    }
     
    //Log  echo "2XXXx XXXXXXXXX".$currentProvince;
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