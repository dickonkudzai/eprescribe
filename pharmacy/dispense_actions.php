<?php
require_once '..\config\Config.php';
use \config\Config;
$config = new Config();
$postData = $_POST;
$getData = $_GET;
$dbConnect = $config->databaseConnection();

if (isset($postData)||isset($getData)){
    $action="";
    if (isset($postData['action'])){
        $action = $postData['action'];
    }
    else{
        if (isset($postData['prescription_action'])){
            $action = $postData['prescription_action'];
        }
    }
    if (isset($getData['action'])){
        $action = $getData['action'];
    }
    switch ($action){
        case "get_prescription_by_id":
            echo json_encode(getPrescriptionById($dbConnect, $getData));
            break;
        default:
            echo json_encode(defaultResponse());
            break;
    }
}
else{
    $output['success']=false;
    $output['message']="Bad Request";
}
function getPrescriptionById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $query = "SELECT * FROM prescriptions WHERE reference_id = '$id'";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $found = $statement->rowCount();
        if ($found>0){
            $data = $statement->fetchAll();
            $prescriptionObj['id'] = $id;
            foreach ($data as $prescription){
                $query_lines = "SELECT * FROM prescription_lines WHERE prescription_id = ".$prescription['id'];
                $statement_lines = $dbConnect->prepare($query_lines);
                $statement_lines->execute();
                $found_lines = $statement_lines->rowCount();
                if ($found_lines>0){
                    $lines = $statement_lines->fetchAll();
                    $prescriptionLines = array();
                    foreach ($lines as $line){
                        $prescriptionLine['id'] = $line['id'];
                        $prescriptionLine['drug_id'] = $line['drug_id'];
                        $prescriptionLine['dose'] = $line['dose'];
                        $prescriptionLine['collected'] = $line['collected'];
                        $prescriptionLine['prescription_id'] = $line['prescription_id'];
                        $prescriptionLines[] = $prescriptionLine;
                    }
                    $prescriptionObj['prescription_lines'] = $prescriptionLines;
                }
                $prescriptionObj['id'] = $prescription['id'];
                $prescriptionObj['date_of_prescription'] = $prescription['date_of_prescription'];
                $prescriptionObj['patient_id'] = $prescription['patient_id'];
                $prescriptionObj['bp'] = $prescription['closed'];

            }
            $queryDrugs = "SELECT * FROM drugs WHERE blocked = 0 AND status = 1";
            $statementDrugs = $dbConnect->prepare($queryDrugs);
            $statementDrugs->execute();
            $result = $statementDrugs->fetchAll();
            $drugs = array();
            foreach ($result as $drug){
                $options = '<option value="'.$drug['id'].'">'.$drug['drug_name'].'</option>';
                $drugs[] = array('drug'=>$options);
            }
            $output['drugs'] = $drugs;
            $output['success']=true;
            $output['message']="";
            $output['data'] = $prescriptionObj;
        }
        else{
            $output['success']=false;
            $output['message']="Record not found";
        }
        return $output;
    }
    catch (Exception $e){
        $output['success']=false;
        $output['message']=$e->getMessage();
        return $output;
    }
}