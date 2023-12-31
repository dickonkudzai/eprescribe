<?php
    require_once '..\config\Config.php';
    use \config\Config;
    $config = new Config();
    $postData = $_POST;
    $dbConnect = $config->databaseConnection();

    if (isset($postData)){
        $action = $postData['action'];
        switch ($action){
            case "login":
                echo json_encode(login($dbConnect, $postData));
                break;
            default:
                break;
        }
    }

    function login($connect, $postData){
        $email = $postData['email'];
        $query = "SELECT u.*, r.role_name 
            FROM user u
            INNER JOIN role r on u.role_id = r.role_id
            WHERE u.email = '$email'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $found = $statement->rowCount();
        if ($found<1 || $found>1){
            $output['success'] = false;
            $output['message'] = "Account not found";
            return $output;
        }
        else{
            $data = $statement->fetchAll();
            foreach ($data as $user){
                if (password_verify($postData['password'], $user['password'])){
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role_name'];
                    $_SESSION['id'] = $user['id'];
                    $output['success']=true;
                    $output['message']="Log in successful";
                    }
                else{
                    $output['success'] = false;
                    $output['message'] = "Failed to log in, check your email or password";
                }
                return $output;
            }

        }
    }