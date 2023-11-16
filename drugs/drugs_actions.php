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
            case "create_drug":
                echo json_encode(createDrug($dbConnect, $postData));
                break;
            case "get_drug_by_id":
                echo json_encode(getDrugById($dbConnect, $getData));
                break;
            case "update_drug":
                echo json_encode(updateDrug($dbConnect, $postData));
                break;
            case "delete_drug":
                echo json_encode(deleteDrugById($dbConnect, $getData));
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

    function deleteDrugById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM drugs WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "UPDATE drugs SET status = 0 WHERE id = $id";
                $statement = $dbConnect->prepare($query);
                $statement->execute();
                $output['success']=true;
                $output['message']="Drug deleted successfully";
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

    function updateDrug($dbConnect, $postData){
        $blocked = isset($postData['blocked'])?$postData['blocked']:0;
        $controlled = isset($postData['controlled'])?$postData['controlled']:0;
        try {
            $query = "UPDATE drugs SET drug_name = :drug_name, blocked = :blocked, controlled = :controlled WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':drug_name'=>$postData['drug_name'],
                    ':blocked'=>$blocked,
                    ':controlled'=>$controlled,
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="Drug updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function getDrugById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT * FROM drugs WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $drug){
                    $drugObj['id'] = $drug['id'];
                    $drugObj['drug_name'] = $drug['drug_name'];
                    $drugObj['blocked'] = $drug['blocked'];
                    $drugObj['controlled'] = $drug['controlled'];
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $drugObj;
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

    function createDrug($dbConnect, $postData){
        try {
            $blocked = isset($postData['blocked'])?$postData['blocked']:0;
            $controlled = isset($postData['controlled'])?$postData['controlled']:0;
            $query = "INSERT INTO drugs (drug_name, blocked, controlled, status) VALUES (:drug_name, :blocked, :controlled, :status)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':drug_name'=>$postData['drug_name'],
                    ':blocked'=>$blocked,
                    ':controlled'=>$controlled,
                    ':status'=>1
                )
            );
            $output['success']=true;
            $output['message']="Successfully created drug";
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