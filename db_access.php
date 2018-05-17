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
function InserLog($service,$province,$price){
    $worksheet = $GLOBALS['excelReaderLog']->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $GLOBALS['excelReaderLog']->setActiveSheetIndex(0)
            ->setCellValue("A".( $lastRow+1),date('d-m-Y H:i:s') )
            ->setCellValue("B". ($lastRow+1),$service)
            ->setCellValue("C". ($lastRow+1),$province )
            ->setCellValue("D". ($lastRow+1),$price );
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
