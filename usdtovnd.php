<?php
class USDToVND extends Thread {
    public $data;
    public function __construct() {
    }

    public function run() {
    $str = file_get_contents("https://www.xe.com/currencyconverter/convert/?Amount=1&From=USD&To=VND");
    $html = new simple_html_dom();
    $html->load($str);
        
    //echo $html;
    
    $rs= $html->find('span.uccResultAmount')[0]->innertext;
    $rs= (int) str_replace(",", '', $rs);   
        
    $data= $rs;
        echo "XXXxxxxxXXXXXXXXXXXXXXXXX<br>";
    }
}
?>