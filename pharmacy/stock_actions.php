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
        if (isset($postData['stock_action'])){
            $action = $postData['stock_action'];
        }
    }
    if (isset($getData['action'])){
        $action = $getData['action'];
    }
    switch ($action){
        case "create_stock":
            echo json_encode(createStock($dbConnect, $postData));
            break;
        case "get_stock_by_id":
            echo json_encode(getStockById($dbConnect, $getData));
            break;
        case "update_stock":
            echo json_encode(updateStock($dbConnect, $postData));
            break;
        case "delete_stock":
            echo json_encode(deleteStockById($dbConnect, $getData));
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

function createStock($dbConnect, $postData)
{
    try {
        $dbConnect->beginTransaction();
        for ($counter = 0; $counter < count($postData['drug_id']); $counter++) {
            $query = "INSERT INTO pharmacy_stock (drug_id, expiry_date, quantity, created_by, pharmacy_id) VALUES (:drug_id, :expiry_date, :quantity, :created_by, :pharmacy_id)";
            $statement = $dbConnect->prepare($query);
            $statement->execute(
                array(
                    ':drug_id' => $postData['drug_id'][$counter],
                    ':expiry_date' => $postData['expiry_date'][$counter],
                    ':quantity' => $postData['quantity'][$counter],
                    ':created_by' => $_SESSION['id'],
                    ':pharmacy_id' => $postData['stock_pharmacy_id'][$counter],
                )
            );
        }
        $dbConnect->commit();
        $output['success']=true;
        $output['message']="Successfully created stock";
        return $output;
    } catch (Exception $e){

        $output['success']=false;
        $output['message']=$e->getMessage();
        return $output;
    }

}

function getStockById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $query = "SELECT * FROM pharmacy_stock WHERE id = $id";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $found = $statement->rowCount();
        if ($found>0){
            $data = $statement->fetchAll();
            $stockObj['id'] = $id;
            foreach ($data as $stock){
                $stockObj['id'] = $stock['id'];
                $stockObj['expiry_date'] = $stock['expiry_date'];
                $stockObj['quantity'] = $stock['quantity'];
                $stockObj['pharmacy_id'] = $stock['pharmacy_id'];

            }
            $queryDrugs = "SELECT * FROM drugs WHERE blocked = 0 AND status = 1";
            $statementDrugs = $dbConnect->prepare($queryDrugs);
            $statementDrugs->execute();
            $result = $statementDrugs->fetchAll();
            $drugs = array();
            foreach ($result as $drug){
                $options = '<option value="'.$drug['id'].'">'.$drug['drug_name'].'</option>';
                $drugs[] = array('drug'=>$options);
            }
            $output['drugs'] = $drugs;
            $output['success']=true;
            $output['message']="";
            $output['data'] = $stockObj;
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

function updateStock($dbConnect, $postData){
    try {
        $dbConnect->beginTransaction();
        $closed = isset($postData['closed']) ? $postData['closed']: 0;
        $query = "UPDATE pharmacy_stock SET drug_id = :drug_id, expiry_date = :expiry_date, quantity = :quantity WHERE id = :id";
        $statement = $dbConnect->prepare($query);
        $statement->execute(
            array(
                ':id'=>$postData['stock_id'],
                ':drug_id'=>$postData['drug_id'],
                ':expiry_date'=>$postData['expiry_date'],
                ':quantity'=>$postData['quantity']
            )
        );
        $dbConnect->commit();
        $output['success']=true;
        $output['message']="Stock updated successfully!";
        return $output;
    }
    catch (Exception $e){
        $output['success']=false;
        $output['message']=$e->getMessage();
        return $output;
    }
}


function deleteStockById($dbConnect, $getData){
    try {
        $id = $getData['id'];
        $queryCheckRecord = "SELECT * FROM pharmacy_stock WHERE id=$id";
        $statementCheckRecord = $dbConnect->prepare($queryCheckRecord);
        $statementCheckRecord->execute();
        $found = $statementCheckRecord->rowCount();
        if ($found>0){
            $query = "UPDATE pharmacy_stock SET status = 0 WHERE id = $id";
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