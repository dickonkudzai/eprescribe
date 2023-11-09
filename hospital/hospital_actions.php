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
            case "map_doctors_to_hospital":
                echo json_encode(mapHospitalToDoctors($dbConnect, $postData));
                break;
            case "get_mapped_doctors":
                echo json_encode(getMappedDoctors($dbConnect, $getData));
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

    function getMappedDoctors($dbConnect, $getData){
        $hospitalId = $getData['hospital_id'];
        $query = "SELECT id, doctor_id, hospital_id FROM doctor_hospitals WHERE hospital_id = $hospitalId";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output['success']=true;
        $output['message']=null;
        $doctorHospitalList = array();
        foreach ($result as $doctorHospital){
            $doctorHospitalList[] = array(
              'id' => $doctorHospital['id'],
              'doctor_id'=>$doctorHospital['doctor_id'],
              'hospital_id'=>$doctorHospital['hospital_id']
            );
        }
        $output['data'] = $doctorHospitalList;
        return $output;
    }

    function defaultResponse(){
        $output['success']=false;
        $output['message']="Action Not Found";
        return $output;
    }
    function mapHospitalToDoctors($dbConnect, $postData){
        $hospitalId = $postData['map_hospital_id'];
        try {
            $queryDeleteCurrentMappings = "DELETE FROM doctor_hospitals WHERE hospital_id = $hospitalId";
            $statementDeleteCurrentMappings = $dbConnect->prepare($queryDeleteCurrentMappings);
            $statementDeleteCurrentMappings->execute();
            if (isset($postData['doctors'])){
                for ($count = 0; $count < count($postData['doctors']); $count++){
                    $query = "INSERT INTO doctor_hospitals (doctor_id, hospital_id) VALUES (:doctor_id, :hospital_id)";
                    $statement = $dbConnect->prepare($query);
                    $statement->execute(
                        array(
                            ':doctor_id'=>$postData['doctors'][$count],
                            ':hospital_id'=>$hospitalId
                        )
                    );
                }
            }
            $output['success']=true;
            $output['message']="Successfully mapped doctors to hospital";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function createHospital($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO hospital (hospital_name, address, email, mobile_number, status) VALUES (:hospital_name, :address, :email, :mobile_number, :status)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':hospital_name'=>$postData['hospital_name'],
                    ':address'=>$postData['address'],
                    ':email'=>$postData['email'],
                    ':mobile_number'=>$postData['mobile_number'],
                    ':status'=>1
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
                    $hospitalObj['address'] = $hospital['address'];
                    $hospitalObj['email'] = $hospital['email'];
                    $hospitalObj['mobile_number'] = $hospital['mobile_number'];
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
            $query = "UPDATE hospital SET hospital_name = :hospital_name, address = :address, email = :email, mobile_number = :mobile_number WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':hospital_name'=>$postData['hospital_name'],
                    ':address'=>$postData['address'],
                    ':email'=>$postData['email'],
                    ':mobile_number'=>$postData['mobile_number'],
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
                $query = "UPDATE hospital SET status = 0 WHERE id = $id";
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