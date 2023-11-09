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
            case "create_patient":
                echo json_encode(createPatient($dbConnect, $postData));
                break;
            case "get_patient_by_id":
                echo json_encode(getPatientById($dbConnect, $getData));
                break;
            case "update_patient":
                echo json_encode(updatePatient($dbConnect, $postData));
                break;
            case "delete_patient":
                echo json_encode(deletePatientById($dbConnect, $getData));
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
    function defaultResponse(){
        $output['success']=false;
        $output['message']="Action Not Found";
        return $output;
    }

    function createPatient($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO patient (first_name, last_name, national_id, mobile_number, address, email, status) VALUES (:first_name, :last_name, :national_id, :mobile_number, :address, :email, :status)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':first_name'=>$postData['first_name'],
                    ':last_name'=>$postData['last_name'],
                    ':national_id'=>$postData['national_id'],
                    ':mobile_number'=>$postData['mobile_number'],
                    ':address'=>$postData['address'],
                    ':email'=>$postData['email'],
                    ':status'=>1
                )
            );
            $output['success']=true;
            $output['message']="Successfully created patient";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }

    }

    function getPatientById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT * FROM patient WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $hospital){
                    $patientObj['id'] = $hospital['id'];
                    $patientObj['first_name'] = $hospital['first_name'];
                    $patientObj['last_name'] = $hospital['last_name'];
                    $patientObj['national_id'] = $hospital['national_id'];
                    $patientObj['mobile_number'] = $hospital['mobile_number'];
                    $patientObj['address'] = $hospital['address'];
                    $patientObj['email'] = $hospital['email'];
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $patientObj;
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

    function updatePatient($dbConnect, $postData){
        try {
            $query = "UPDATE patient SET first_name=:first_name, last_name=:last_name, national_id=:national_id, mobile_number=:mobile_number, address = :address, email = :email WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':first_name'=>$postData['first_name'],
                    ':last_name'=>$postData['last_name'],
                    ':national_id'=>$postData['national_id'],
                    ':mobile_number'=>$postData['mobile_number'],
                    ':address'=>$postData['address'],
                    ':email'=>$postData['email'],
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="Patient updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function deletePatientById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM patient WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "DELETE FROM patient WHERE id = $id";
                $statement = $dbConnect->prepare($query);
                $statement->execute();
                $output['success']=true;
                $output['message']="Patient deleted successfully";
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