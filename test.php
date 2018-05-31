<?php
include('assets/libs/simple_html_dom.php');
include('common.php');
include('db_access.php');
set_time_limit(0);
//Crawl_Hotel();
$arrProvinces;
var_dump(GetIdForGoTrip(GetProvinceList()));

function Insert_Khach_San_Ver2($provinces) {
    $pathroot="http://gotrip.vn/";
    $i=0;
    foreach($provinces as $province){
      // echo "<br> ".$province. "______________________________________ <br> ";
        $i+=1;
//		#region Custom Province
        if(strcmp($province, "Quảng Nam")==0) 
            $currentPath=$pathroot."khach-san-hoi-an/";
        else if(strcmp($province, "Quảng Ninh")==0) 
            $currentPath=$pathroot."khach-san-ha-long/";
        else if(strcmp($province, "Thừa Thiên Huế")==0) 
            $currentPath=$pathroot."khach-san-hue/";
        else if(strcmp($province, "Bà Rịa - Vũng Tàu")==0) 
            $currentPath=$pathroot."khach-san-vung-tau/";
        else if(strcmp($province, "Kiên Giang")==0) 
            $currentPath=$pathroot."khach-san-phu-quoc/";
        else if(strcmp($province, "Hải Phòng")==0) 
            $currentPath=$pathroot."khach-san-tai-hai-phong";  
        else if(strcmp($province, "Đồng Nai")==0) 
            $currentPath=$pathroot."khach-san-nam-cat-tien";
         else if(strcmp($province, "An Giang")==0) 
            $currentPath=$pathroot."khach-san-long-xuyen";    
        else if(strcmp($province, "Bình Định")==0) 
            $currentPath=$pathroot."khach-san-quy-nhon";
        else if(strcmp($province, "Lâm Đồng")==0) 
            $currentPath=$pathroot."khach-san-da-lat";
        else if(strcmp($province, "TP Hồ Chí Minh")==0) 
            $currentPath=$pathroot."khach-san-sai-gon-tphcm";
        else if(strcmp($province, "Cà Mau")==0) 
            $currentPath=$pathroot."khach-san-tai-ca-mau";
        else
            $currentPath=$pathroot."khach-san-".convert_vi_to_en($province);
        
    $url = 'http://gotrip.vn/index.php?language=vi&nv=hotels&op=filter_hotels&catid=10';
    $ch=array();
    $mh = curl_multi_init();
    for($i=2;$i<6;$i++){
        $ch[$i] = curl_init($url);
        //uild the individual requests, but do not execute them
        curl_setopt($ch[$i], CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch[$i], CURLOPT_POSTFIELDS, "starcheck=".$i);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array('accept: */*',
                                    'accept-encoding: gzip, deflate',
                                    'accept-language: en-US,en;q=0.8',
                                    'content-type: application/x-www-form-urlencoded',
                                    'referer: '.$currentPath,
                                    'x-requested-with: XMLHttpRequest',
                                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'));
       // build the multi-curl handle, adding both $ch
        curl_multi_add_handle($mh, $ch[$i]);
        }
    
      // execute all queries simultaneously, and continue when all are complete
      $running = null;
      do {
        curl_multi_exec($mh, $running);
      } while ($running);

    //close the handles
    for($i=2;$i<6;$i++){
        curl_multi_remove_handle($mh, $ch[$i]);
    }
    curl_multi_close($mh);
        $response= array();
    for($i=2;$i<6;$i++){
        $response[$i] = curl_multi_getcontent($ch[$i]);
        echo "$response[$i]"."<br>_^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^_________________";
    }
        return;
//      return;
        #endregion
    }
}
    $listProvince;
function GetIdForGoTrip($provinces){
    if(isset($GLOBALS['$listProvince']))
        return $GLOBALS['$listProvince'];
    $GLOBALS['$listProvince']= array();
    $url="http://gotrip.vn/khach-san-long-xuyen/";
    $curl=curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0'));
		$str=curl_exec($curl);
		curl_close($curl);
		$html = new simple_html_dom();
        $html->load($str);
        //echo $html;
//       // return;

    
    foreach($html->find('#scatid option') as $element) {
        $text = $element->innertext;
        
        foreach($provinces as $province){
            if(strpos($text,$province)){
                $GLOBALS['$listProvince'][$province]=$element->value;
            }
        }
    }
    $GLOBALS['$listProvince']["Quảng Nam"]='10';
    $GLOBALS['$listProvince']["Quảng Ninh"]='11';
    $GLOBALS['$listProvince']["Thừa Thiên Huế"]='13';
    $GLOBALS['$listProvince']["Bà Rịa - Vũng Tàu"]='15';
    $GLOBALS['$listProvince']["Kiên Giang"]='16';
    $GLOBALS['$listProvince']["Hải Phòng"]='54';
    $GLOBALS['$listProvince']["Đồng Nai"]='68';
    $GLOBALS['$listProvince']["An Giang"]='70';
    $GLOBALS['$listProvince']["Bình Định"]='22';
    $GLOBALS['$listProvince']["Lâm Đồng"]='26';
    $GLOBALS['$listProvince']["TP Hồ Chí Minh"]='33';
    $GLOBALS['$listProvince']["Cà Mau"]='43';
    return $GLOBALS['$listProvince'];

}

function X1() {
    
$url = 'http://gotrip.vn/index.php?language=vi&nv=hotels&op=filter_hotels&catid=10';
    $ch=array();
    $mh = curl_multi_init();
    for($i=2;$i<6;$i++){
        $ch[$i] = curl_init($url);
        //uild the individual requests, but do not execute them
        curl_setopt($ch[$i], CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch[$i], CURLOPT_POSTFIELDS, "starcheck=".$i);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch[$i], CURLOPT_HTTPHEADER, array('accept: */*',
                                    'accept-encoding: gzip, deflate',
                                    'accept-language: en-US,en;q=0.8',
                                    'content-type: application/x-www-form-urlencoded',
                                    'referer: http://gotrip.vn/khach-san-hoi-an/',
                                    'x-requested-with: XMLHttpRequest',
                                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36'));
       // build the multi-curl handle, adding both $ch
        curl_multi_add_handle($mh, $ch[$i]);
}
// execute all queries simultaneously, and continue when all are complete
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while ($running);
    
//close the handles
for($i=2;$i<6;$i++){
    curl_multi_remove_handle($mh, $ch[$i]);
}
curl_multi_close($mh);
    $response= array();
for($i=2;$i<6;$i++){
    $response[$i] = curl_multi_getcontent($ch[$i]);
    echo "$response[$i]"."<br>_^^^^^^^^^^^^^_________________";
}
    return;
}

////base
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
