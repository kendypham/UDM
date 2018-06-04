<?php
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
define('COLUMNS_NAME',array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ", "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM"));

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$tmpfname = "Database.xlsx";
$tmpfnamelog = "Log.xlsx";
$excelReader;
$excelReaderLog;
//var_dump(COLUMNS_NAME);
//Init();
//Show();
//--------------------------------------------------------
// Create new PHPExcel object
function Init($services,$arrProvinces){
    $nameFile="Database.xlsx";
    //Create file log
    if (!file_exists($GLOBALS['tmpfnamelog'])){
            $objPHPExcelLog= new PHPExcel();
            $objPHPExcelLog->setActiveSheetIndex(0)
                ->setCellValue("A1","Time" )
                ->setCellValue("B1","Service" )
                ->setCellValue("C1","Province" )
                ->setCellValue("D1","Price" );
            $objPHPExcelLog->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objWriterLog = PHPExcel_IOFactory::createWriter($objPHPExcelLog, 'Excel2007');
            $objWriterLog->save($GLOBALS['tmpfnamelog']);
}
    if(file_exists($nameFile)){
        // backup
        $nameFile=$nameFile.'.bak';
        copy("Database.xlsx", $nameFile);
        return;  
    }
    
    $objPHPExcel= new PHPExcel();
    //add provinces 
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B". '1',$arrProvinces[63] );
        $i=0;
    foreach(COLUMNS_NAME as $value){
        if($i<2) {
            $i+=1;
            continue;
        };
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($value. '1',$arrProvinces[$i-2] );
        $i+=1;
    }
    $i=2;
    foreach($services as $value){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'. $i, $value);
        $i+=1;
    }
  //  echo date('H:i:s') , " Rename worksheet" , EOL;
  //  echo date('H:i:s') , $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() ."xx".$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn() , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("Database.xlsx");
    
    

}
// Rename worksheet
function SaveFile(){
    //Save
    $objWriter = PHPExcel_IOFactory::createWriter($GLOBALS['excelReader'], 'Excel2007');
    $objWriter->save($GLOBALS['tmpfname']);
    $objWriter1 = PHPExcel_IOFactory::createWriter($GLOBALS['excelReaderLog'], 'Excel2007');
    $objWriter1->save($GLOBALS['tmpfnamelog']);
    //echo "<br> ________SAVED____________<br>";
}
function LoadFile(){
    $GLOBALS['excelReader'] = PHPExcel_IOFactory::createReaderForFile($GLOBALS['tmpfname']);
    $GLOBALS['excelReader'] = $GLOBALS['excelReader']->load($GLOBALS['tmpfname']);

    $GLOBALS['excelReaderLog'] = PHPExcel_IOFactory::createReaderForFile($GLOBALS['tmpfnamelog']);
    $GLOBALS['excelReaderLog'] = $GLOBALS['excelReaderLog']->load($GLOBALS['tmpfnamelog']);
}
function InserLog($service,$province,$price,$detail){
    $worksheet = $GLOBALS['excelReaderLog']->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $GLOBALS['excelReaderLog']->setActiveSheetIndex(0)
            ->setCellValue("A".( $lastRow+1),date('d-m-Y H:i:s') )
            ->setCellValue("B". ($lastRow+1),$service)
            ->setCellValue("C". ($lastRow+1),$province )
            ->setCellValue("D". ($lastRow+1),$price )
            ->setCellValue("E". ($lastRow+1),$detail );
}
function Show(){
    $tmpfname = "Log.xlsx";
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();

    echo "<table>";
    for ($row = 1; $row <= $lastRow; $row++) {
         echo "<tr><td>";
         echo $worksheet->getCell('A'.$row)->getValue();
         echo "</td><td>";
         echo $worksheet->getCell('B'.$row)->getValue();
         echo "</td><td>";
         echo $worksheet->getCell('C'.$row)->getValue();
         echo "</td><td>";
         echo $worksheet->getCell('D'.$row)->getValue();
         echo "</td><tr>";
    }
    echo "</table>";	
}

function GetPrices(){

    $tmpfname = "Database.xlsx";
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $provs = [];
    $ps = [];
    foreach($worksheet->getRowIterator(1) AS $prov){
        $cellIterator = $prov->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);
        $cells = [];
        foreach ($cellIterator as $cell) {
            $cells[] = $cell->getValue();
        }
        $provs[] = $cells;
    }

    for($i = 0; $i < 16; $i++){
        echo "<div class='' id='p".($i);
        echo "'><table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>";
        echo "Tỉnh";
        echo "</th>";
        echo "<th>";
        echo "Giá dịch vụ";
        echo "</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        for($k = 1; $k < 65; $k++) {
            if($provs[$i+1][$k] != ""){
                echo "<tr>";
                echo "<td>";
                echo $provs[0][$k];
                echo "</td>";
                echo "<td>";
                if(strpos($provs[$i+1][$k],"+"))
                    echo $provs[$i+1][$k] ." VND";
                else
                    echo number_format( (int) $provs[$i+1][$k], 0, '', ',')  ." VND";
                echo "</td>";
                echo "</tr>";
            }
            else {continue;}
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}
function GetServices(){
    $tmpfname = "Database.xlsx";
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();

    for($row = 2; $row <= $lastRow; $row++){
        echo "<a href='#' class='serv' id='".($row - 2)."'>";
        echo $worksheet->getCell('A'.$row)->getValue();
        echo "</a>\n";
    }
}
