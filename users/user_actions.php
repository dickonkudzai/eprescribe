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
            default:
                break;
        }
    }
    else{
        $output['success']=false;
        $output['message']="Bad Request";
    }
    function createUser($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO user (first_name, last_name, national_id, mobile_number, username, email, password, status, role_id) VALUES (:first_name, :last_name, :national_id, :mobile_number,:username, :email, :password, :status, :role_id)";
            $statement = $dbConnect->prepare($query);
            $defaultPassword = "p@55w0rd";
            $statement->execute(
                array(
                    ':first_name'=>$postData['firstName'],
                    ':last_name'=>$postData['lastName'],
                    ':national_id'=>$postData['nationalId'],
                    ':mobile_number'=>$postData['mobileNumber'],
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
                    $userObj['role'] = $user['role_name'];
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
            $query = "UPDATE user SET first_name = :first_name, last_name = :last_name, national_id = :national_id, mobile_number = :mobile_name, username = :username, email = :email WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':first_name'=>$postData['firstName'],
                    ':last_name'=>$postData['lastName'],
                    ':national_id'=>$postData['nationalId'],
                    ':mobile_number'=>$postData['mobileNumber'],
                    ':username'=>$postData['username'],
                    ':email'=>$postData['email'],
                    ':role'=>$postData['role_id'],
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
                $query = "DELETE FROM user WHERE id = $id";
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