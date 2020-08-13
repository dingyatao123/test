<?php
define('IN_ECS',true);

require_once '/data/config.php';
require_once '/data/cls_mysql.php';
date_default_timezone_set("Asia/Shanghai");
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel-1.8/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties();


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '排名')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '手机号')
            ->setCellValue('D1', '得分');

$sql = "select * from records order by scores desc";
$arr=$db->getAll($sql);

$column = 2;
$objActSheet = $objPHPExcel->getActiveSheet();
foreach($arr as $k => $rows){ //行写入
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$column, 'NO.'.($column-1))
            ->setCellValue('B'.$column, $rows["username"])
            ->setCellValue('C'.$column, $rows["telnumber"])
            ->setCellValue('D'.$column, $rows["scores"]."分");
    $column++;
}

// Rename worksheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="新天药业'.date('YmdHis').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
