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
            $query = "INSERT INTO user (username, email, password, status) VALUES (:username, :email, :password, :status)";
            $statement = $dbConnect->prepare($query);
            $defaultPassword = "p@55w0rd";
            $statement->execute(
                array(
                    ':username'=>$postData['username'],
                    ':email'=>$postData['email'],
                    ':password'=>password_hash($defaultPassword, PASSWORD_BCRYPT),
                    ':status'=>1
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
            $query = "SELECT * FROM user WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $user){
                    $userObj['id'] = $user['id'];
                    $userObj['email'] = $user['email'];
                    $userObj['username'] = $user['username'];
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
            $query = "UPDATE user SET username = :username, email = :email WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
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