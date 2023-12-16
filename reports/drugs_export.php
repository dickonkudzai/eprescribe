<?php
require '../resources/vendor/autoload.php';
include "../config/utilities.php";
require_once '..\config\Config.php';
use \config\Config;
$config = new Config();
$postData = $_POST;
$getData = $_GET;
$dbConnect = $config->databaseConnection();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Create a new worksheet
$sheet = $spreadsheet->getActiveSheet();
$blocked = $_POST['blocked'] == 'all' ? '' : ($_POST['blocked'] == 'WHERE blocked = 1' ? '1' : 'WHERE blocked = 0');

// Add data to the worksheet
$sheet->setCellValue('A1', 'Blocked Drugs Report');

$query = "SELECT * FROM drugs $blocked";
$statement = $dbConnect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$i = 2;

// Add your report data here
$sheet->setCellValue('A'.$i, 'Drug Name');
$sheet->setCellValue('B'.$i, 'Blocked');
$sheet->setCellValue('C'.$i, 'Controlled');

foreach ($result as $drugs) {
    $i++;
    $sheet->setCellValue('A'.$i, $drugs['drug_name']);
    $sheet->setCellValue('B'.$i, $drugs['blocked']==1 ? "Yes" : "No");
    $sheet->setCellValue('C'.$i, $drugs['controlled']==1 ? "Yes" : "No");
}
// ... Add more columns and data as needed

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$filename = 'reports_' . date('YmdHis') . '.xlsx';
$writer->save($filename);

// Set the appropriate headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Send the file to the browser
$writer->save('php://output');