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
            case "create_pharmacy":
                echo json_encode(createPharmacy($dbConnect, $postData));
                break;
            case "get_pharmacy_by_id":
                echo json_encode(getPharmacyById($dbConnect, $getData));
                break;
            case "update_pharmacy":
                echo json_encode(updatePharmacy($dbConnect, $postData));
                break;
            case "delete_pharmacy":
                echo json_encode(deletePharmacyById($dbConnect, $getData));
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

    function createPharmacy($dbConnect, $postData)
    {
        try {
            $query = "INSERT INTO pharmacy (pharmacy_address, pharmacy_name, status) VALUES (:pharmacy_address,:pharmacy_name, :status)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':pharmacy_address'=>$postData['pharmacy_address'],
                    ':pharmacy_name'=>$postData['pharmacy_name'],
                    ':status'=>1
                )
            );
            $output['success']=true;
            $output['message']="Successfully created pharmacy";
            return $output;
        } catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }

    }

    function getPharmacyById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $query = "SELECT * FROM pharmacy WHERE id = $id";
            $statement = $dbConnect->prepare($query);
            $statement->execute();
            $found = $statement->rowCount();
            if ($found>0){
                $data = $statement->fetchAll();
                foreach ($data as $pharmacy){
                    $pharmacyObj['id'] = $pharmacy['id'];
                    $pharmacyObj['pharmacy_address'] = $pharmacy['pharmacy_address'];
                    $pharmacyObj['pharmacy_name'] = $pharmacy['pharmacy_name'];
                    $output['success']=true;
                    $output['message']="";
                    $output['data'] = $pharmacyObj;
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

    function updatePharmacy($dbConnect, $postData){
        try {
            $query = "UPDATE pharmacy SET pharmacy_address=:pharmacy_address, pharmacy_name=:pharmacy_name WHERE id = :id";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':pharmacy_address'=>$postData['pharmacy_address'],
                    ':pharmacy_name'=>$postData['pharmacy_name'],
                    ':id'=>$postData['id']
                )
            );
            $output['success']=true;
            $output['message']="Pharmacy updated successfully!";
            return $output;
        }
        catch (Exception $e){
            $output['success']=false;
            $output['message']=$e->getMessage();
            return $output;
        }
    }

    function deletePharmacyById($dbConnect, $getData){
        try {
            $id = $getData['id'];
            $queryCheckRecord = "SELECT * FROM pharmacy WHERE id=$id";
            $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
            $statementCheckRecord->execute();
            $found = $statementCheckRecord->rowCount();
            if ($found>0){
                $query = "DELETE FROM pharmacy WHERE id = $id";
                $statement = $dbConnect->prepare($query);
                $statement->execute();
                $output['success']=true;
                $output['message']="Pharmacy deleted successfully";
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