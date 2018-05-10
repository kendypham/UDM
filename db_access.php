<?php
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
$objPHPExcel=Init();
AddData($objPHPExcel);
Save($objPHPExcel);
Show();
//--------------------------------------------------------
// Create new PHPExcel object
function Init(){
   echo date('H:i:s') , " Create new PHPExcel object" , EOL;
    return new PHPExcel();
}
function AddData($objPHPExcel){
   echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
}
// Rename worksheet
function Save($objPHPExcel){
    echo date('H:i:s') , " Rename worksheet" , EOL;
    echo date('H:i:s') , $objPHPExcel->setActiveSheetIndex(0)->getHighestRow() ."xx".$objPHPExcel->setActiveSheetIndex(0)->getHighestColumn() , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

}

function Show(){
    $tmpfname = str_replace('.php', '.xlsx', __FILE__);
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
			 echo "</td><tr>";
		}
		echo "</table>";	
}
