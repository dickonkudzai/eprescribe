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
        }else{
            if (isset($postData['map_action'])){
                $action = $postData['map_action'];
            }
        }
        if (isset($getData['action'])){
            $action = $getData['action'];
        }
        switch ($action){
            case "create_user":
                echo json_encode(createUser($dbConnect, $postData));
                break;
            case "get_user_by_id":
                echo json_encode(getUserById($dbConnect, $getData));
                break;
            case "update_user":
                echo json_encode(updateUser($dbConnect, $postData));
                break;
            case "delete_user":
                echo json_encode(deleteUserById($dbConnect, $getData));
                break;
            case "map_hospitals_to_doctor":
                echo json_encode(mapHospitalToDoctors($dbConnect, $postData));
                break;
            case "get_mapped_hospitals":
                echo json_encode(getMappedHospitals($dbConnect, $getData));
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

    function mapHospitalToDoctors($dbConnect, $postData){
        $doctorId = $postData['map_doctor_id'];
        try {
            $queryDeleteCurrentMappings = "DELETE FROM doctor_hospitals WHERE doctor_id = $doctorId";
            $statementDeleteCurrentMappings = $dbConnect->prepare($queryDeleteCurrentMappings);
            $statementDeleteCurrentMappings->execute();
            if (isset($postData['hospitals'])){
                for ($count = 0; $count < count($postData['hospitals']); $count++){
                    $query = "INSERT INTO doctor_hospitals (doctor_id, hospital_id) VALUES (:doctor_id, :hospital_id)";
                    $statement = $dbConnect->prepare($query);
                    $statement->execute(
                        array(
                            ':doctor_id'=>$doctorId,
                            ':hospital_id'=>$postData['hospitals'][$count]
                        )
                    );
                }
            }
            $output['success']=true;
            $output['message']="Successfully mapped hospitals to doctor";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function getMappedHospitals($dbConnect, $getData){
        $doctorId = $getData['doctor_id'];
        $query = "SELECT id, doctor_id, hospital_id FROM doctor_hospitals WHERE doctor_id = $doctorId";
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
    function createUser($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO user (first_name, last_name, national_id, mobile_number, username, email, password, status, role_id) VALUES (:first_name, :last_name, :national_id, :mobile_number,:username, :email, :password, :status, :role_id)";
            $statement = $dbConnect->prepare($query);
            $defaultPassword = "p@55w0rd";
            $statement->execute(
                array(
                    ':first_name'=>$postData['first_name'],
                    ':last_name'=>$postData['last_name'],
                    ':national_id'=>$postData['national_id'],
                    ':mobile_number'=>$postData['mobile_number'],
                    ':username'=>$postData['username'],
                    ':email'=>$postData['email'],
                    ':password'=>password_hash($defaultPassword, PASSWORD_BCRYPT),
                    ':status'=>1,
                    ':role_id'=>$postData['role_id']
                )
            );
            $output['success']=true;
            $output['message']="Successfully created user";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }

    }

    function getUserById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT u.*, r.role_name 
                FROM user u
                INNER JOIN role r on u.role_id = r.role_id
                WHERE u.id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $user){
                    $userObj['id'] = $user['id'];
                    $userObj['email'] = $user['email'];
                    $userObj['username'] = $user['username'];
                    $userObj['first_name'] = $user['first_name'];
                    $userObj['last_name'] = $user['last_name'];
                    $userObj['national_id'] = $user['national_id'];
                    $userObj['mobile_number'] = $user['mobile_number'];
                    $roleObj['role_id'] = $user['role_id'];
                    $roleObj['role_name'] = $user['role_name'];
                    $userObj['role'] = $roleObj;
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $userObj;
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

    function updateUser($dbConnect, $postData){
        try {
            $query = "UPDATE user SET first_name = :first_name, last_name = :last_name, national_id = :national_id, mobile_number = :mobile_number, username = :username, email = :email WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':first_name'=>$postData['first_name'],
                    ':last_name'=>$postData['last_name'],
                    ':national_id'=>$postData['national_id'],
                    ':mobile_number'=>$postData['mobile_number'],
                    ':username'=>$postData['username'],
                    ':email'=>$postData['email'],
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="User updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function deleteUserById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM user WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "UPDATE user SET status = 0 WHERE id = $id";
                $statement = $dbConnect->prepare($query);
                $statement->execute();
                $output['success']=true;
                $output['message']="User deleted successfully";
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