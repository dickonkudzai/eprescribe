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
            if (isset($postData['map_action'])){
                $action = $postData['map_action'];
            }
        }
        if (isset($getData['action'])){
            $action = $getData['action'];
        }
        switch ($action){
            case "create_consultation":
                echo json_encode(createConsultation($dbConnect, $postData));
                break;
            case "get_consultation_by_id":
                echo json_encode(getConsultationById($dbConnect, $getData));
                break;
            case "update_consultation":
                echo json_encode(updateConsultation($dbConnect, $postData));
                break;
            case "delete_consultation":
                echo json_encode(deleteConsultationById($dbConnect, $getData));
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

    function createConsultation($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO consultation (patient_id, consultation_date, weight, bp, temperature, status, attended_by) VALUES (:patient_id, :consultation_date, :weight, :bp, :temperature, :status, :attended_by)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':patient_id'=>$postData['patient_id'],
                    ':consultation_date'=>date('y-m-d'),
                    ':weight'=>$postData['weight'],
                    ':bp'=>$postData['bp'],
                    ':temperature'=>$postData['temperature'],
                    ':status'=>1,
                    ':attended_by'=>$_SESSION['id']
                )
            );
            $output['success']=true;
            $output['message']="Successfully created consultation";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }

    }

    function getConsultationById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT * FROM consultation WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $consultation){
                    $consultationObj['id'] = $consultation['id'];
                    $consultationObj['consultation_date'] = $consultation['consultation_date'];
                    $consultationObj['weight'] = $consultation['weight'];
                    $consultationObj['bp'] = $consultation['bp'];
                    $consultationObj['temperature'] = $consultation['temperature'];
                    $consultationObj['condition_description'] = $consultation['condition_description'];
                    $consultationObj['condition_diagnosis'] = $consultation['condition_diagnosis'];
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $consultationObj;
                }
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

    function updateConsultation($dbConnect, $postData){
        try {
            $query = "UPDATE consultation SET weight = :weight, bp = :bp, temperature = :temperature, condition_description = :condition_description, condition_diagnosis = :condition_diagnosis WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':weight'=>$postData['weight'],
                    ':bp'=>$postData['bp'],
                    ':temperature'=>$postData['temperature'],
                    ':condition_description'=>$postData['condition_description'],
                    ':condition_diagnosis'=>$postData['condition_diagnosis'],
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="Consultation updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function deleteConsultationById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM consultation WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "UPDATE consultation SET status = 0 WHERE id = $id";
                $statement = $dbConnect->prepare($query);
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
    function defaultResponse(){
    $output['success']=false;
    $output['message']="Action Not Found";
    return $output;
}