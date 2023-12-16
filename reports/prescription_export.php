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

    $sdt = date("Y-m-d", strtotime($_POST['from_date']));
    $edt = date("Y-m-d", strtotime($_POST['to_date']));

    // Add data to the worksheet
    $sheet->setCellValue('A1', 'Prescriptions Report');

    $query = "SELECT p.reference_id, p.date_of_prescription, p.closed, CONCAT(p2.last_name, ' ', p2.first_name) patient, CONCAT(u.first_name, ' ', u.last_name) added_by 
        FROM prescriptions p 
        INNER JOIN patient p2 on p.patient_id = p2.id
        INNER JOIN user u on p.added_by = u.id
        WHERE p.date_of_prescription BETWEEN '$sdt' AND '$edt'";
    $statement = $dbConnect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $i = 2;

    // Add your report data here
    $sheet->setCellValue('A'.$i, 'Reference ID');
    $sheet->setCellValue('B'.$i, 'Date');
    $sheet->setCellValue('C'.$i, 'Patient');
    $sheet->setCellValue('D'.$i, 'Added By');
    $sheet->setCellValue('E'.$i, 'Closed');

    foreach ($result as $prescription) {
        $i++;
        $sheet->setCellValue('A'.$i, $prescription['reference_id']);
        $sheet->setCellValue('B'.$i, date("d F Y", strtotime($prescription['date_of_prescription'])));
        $sheet->setCellValue('C'.$i, $prescription['patient']);
        $sheet->setCellValue('D'.$i, $prescription['added_by']);
        $sheet->setCellValue('E'.$i, $prescription['closed']==1 ? "Yes" : "No");
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