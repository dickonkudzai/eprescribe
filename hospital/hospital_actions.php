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
        if (isset($getData['action'])){
            $action = $getData['action'];
        }
        switch ($action){
            case "create_hospital":
                echo json_encode(createHospital($dbConnect, $postData));
                break;
            case "get_hospital_by_id":
                echo json_encode(getHospitalById($dbConnect, $getData));
                break;
            case "update_hospital":
                echo json_encode(updateHospital($dbConnect, $postData));
                break;
            case "delete_hospital":
                echo json_encode(deleteHospitalById($dbConnect, $getData));
                break;
            default:
                break;
        }
    }
    else{
        $output['success']=false;
        $output['message']="Bad Request";
    }

    function createHospital($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO hospital (hospital_name) VALUES (:hospital_name)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':hospital_name'=>$postData['hospital_name']
                )
            );
            $output['success']=true;
            $output['message']="Successfully created hospital";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }

    }

    function getHospitalById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT * FROM hospital WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $hospital){
                    $hospitalObj['id'] = $hospital['id'];
                    $hospitalObj['hospital_name'] = $hospital['hospital_name'];
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $hospitalObj;
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

    function updateHospital($dbConnect, $postData){
        try {
            $query = "UPDATE hospital SET hospital_name = :hospital_name WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':hospital_name'=>$postData['hospital_name'],
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="Hospital updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function deleteHospitalById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM hospital WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "DELETE FROM hospital WHERE id = $id";
                $statement = $dbConnect->prepare($query);
                $statement->execute();
                $output['success']=true;
                $output['message']="Hospital deleted successfully";
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