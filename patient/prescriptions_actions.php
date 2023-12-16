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
        case "create_prescription":
            echo json_encode(createPrescription($dbConnect, $postData, $config));
            break;
        case "get_prescription_by_id":
            echo json_encode(getPrescriptionById($dbConnect, $getData));
            break;
        case "update_prescription":
            echo json_encode(updatePrescription($dbConnect, $postData));
            break;
        case "delete_prescription":
            echo json_encode(deletePrescriptionById($dbConnect, $getData));
            break;
        case "delete_prescription_line_by_id":
            echo json_encode(deletePrescriptionLineById($dbConnect, $getData));
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

function createPrescription($dbConnect, $postData, $config)
{
    try {
        $dbConnect->beginTransaction();
        $uuid = $config->generateUUID();
        $query = "INSERT INTO prescriptions (patient_id, added_by, date_of_prescription, closed, status, reference_id) VALUES (:patient_id, :added_by, :date_of_prescription, :closed, :status, :reference_id)";
        $statement = $dbConnect->prepare($query);
        $statement->execute(
            array(
                ':patient_id'=>$postData['prescription_patient_id'],
                ':added_by'=>$_SESSION['id'],
                ':date_of_prescription'=>date('y-m-d'),
                ':closed'=>0,
                ':status'=>1,
                ':reference_id'=>$uuid
            )
        );

        $last_id = $dbConnect->lastInsertId();
        addOrUpdatePrescription($dbConnect, $postData, $last_id);
        $dbConnect->commit();

        $queryNumber = "SELECT mobile_number FROM patient WHERE id = :id";
        $statementNumber = $dbConnect->prepare($queryNumber);
        $statementNumber->execute(
            array(
                ':id'=>$postData['prescription_patient_id']
            )
        );
        $patientNumber = $statementNumber->fetchColumn();
        $message = "Successfully created prescription with id: $uuid";
        $mobileNumber = "263".$patientNumber;
        $config->sendSMS($mobileNumber, $message);

        $output['success']=true;
        $output['message']="Successfully created prescription";
        return $output;
    } catch (Exception $e){

        $output['success']=false;
        $output['message']= $config->generateUUID();//$e->getMessage();
        return $output;
    }

}

function getPrescriptionById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $query = "SELECT * FROM prescriptions WHERE id = $id";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $found = $statement->rowCount();
        if ($found>0){
            $data = $statement->fetchAll();
            $prescriptionObj['id'] = $id;
            foreach ($data as $prescription){
                $query_lines = "SELECT * FROM prescription_lines WHERE prescription_id = $id";
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

function updatePrescription($dbConnect, $postData){
    try {
        $dbConnect->beginTransaction();
        $closed = isset($postData['closed']) ? $postData['closed']: 0;
        $query = "UPDATE prescriptions SET closed = :closed WHERE id = :id";
        $statement = $dbConnect->prepare($query);
        $statement->execute(
            array(
                ':id'=>$postData['prescription_id'],
                ':closed'=>$closed
            )
        );
        $prescriptionId = $postData['prescription_id'];
        addOrUpdatePrescription($dbConnect, $postData, $prescriptionId);
        $dbConnect->commit();
        $output['success']=true;
        $output['message']="Prescription updated successfully!";
        return $output;
    }
    catch (Exception $e){
        $output['success']=false;
        $output['message']=$e->getMessage();
        return $output;
    }
}

function addOrUpdatePrescription($dbConnect, $postData, $prescriptionId){
    for ($counter = 0; $counter < count($postData['drug_id']); $counter++) {
        $collected = isset($postData['collected'][$counter]) ? $postData['collected'][$counter] : 0;
        if (!empty($postData['prescription_line_id'][$counter])) {
            $query = "UPDATE prescription_lines SET drug_id = :drug_id, dose = :dose, collected = :collected WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':id' => $postData['prescription_line_id'][$counter],
                    ':drug_id' => $postData['drug_id'][$counter],
                    ':dose' => $postData['dose'][$counter],
                    ':collected' => $collected
                )
            );

        } else {
            $query = "INSERT INTO prescription_lines (prescription_id, drug_id, dose, status, collected) VALUES (:prescription_id,:drug_id, :dose, :status, :collected)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':prescription_id' => $prescriptionId,
                    ':drug_id' => $postData['drug_id'][$counter],
                    ':dose' => $postData['dose'][$counter],
                    ':status' => 1,
                    ':collected' => $collected
                )
            );
        }
    }

}

function deletePrescriptionById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $queryCheckRecord = "SELECT * FROM prescriptions WHERE id=$id";
        $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
        $statementCheckRecord->execute();
        $found = $statementCheckRecord->rowCount();
        if ($found>0){
            $query = "UPDATE prescriptions SET status = 0 WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();

            $queryLines = "UPDATE prescription_lines SET status = 0 WHERE prescription_id = $id";
            $statement = $dbConnect->prepare($queryLines);
            $statement->execute();

            $output['success']=true;
            $output['message']="Consultation deleted successfully";
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

function deletePrescriptionLineById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $queryCheckRecord = "SELECT * FROM prescription_lines WHERE id=$id";
        $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
        $statementCheckRecord->execute();
        $found = $statementCheckRecord->rowCount();
        if ($found>0){
            $query = "DELETE FROM prescription_lines WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $output['success']=true;
            $output['message']="Prescription line deleted successfully";
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
function defaultResponse(){
    $output['success']=false;
    $output['message']="Action Not Found";
    return $output;
}