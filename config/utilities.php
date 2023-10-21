<?php
    function getRoles($dbConnect){
        $query = "SELECT * FROM role";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output="";
        foreach ($result as $role){
            $output .= "<option value=".$role['role_id'].">".$role['role_name']."</option>";
        }
        return $output;
    }
    function getGender(){
        $output = "<option value='1'>Female</option>";
        $output .= "<option value='2'>Male</option>";
        return $output;
    }
    function getTotalHospital($dbConnect){
        $query = "SELECT * FROM hospital";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    function getUsers($dbConnect){
        $query = "";
        if ($_SESSION['role']==='ROLE_ADMIN'){
            $query = "SELECT u.*, r.role_name
                        FROM user u
                        INNER JOIN role r on u.role_id = r.role_id
                        WHERE status = 1";
        }
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $user){
            $output .= "<tr>";
                $output .= "<td>".$user['id']."</td>";
                $output .= "<td>".$user['first_name']." ".$user['last_name']."</td>";
                $output .= "<td>".$user['role_name']."</td>";
                $output .= "<td>".$user['mobile_number']."</td>";
                $output .= "<td>".$user['national_id']."</td>";
                $output .= "<td>".$user['email']."</td>";
                $output .= "<td style='text-align: center'>";
                    $output .="<button class='btn btn-sm btn-warning edit_user' id=".$user['id']."><i class='fas fa-pen'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-danger delete_user' id=".$user['id']."><i class='fas fa-trash'></i></button>&nbsp";
                    if ($user['role_name']==='ROLE_DOCTOR')
                        $output .="<button class='btn btn-sm btn-info link_doctor_to_hospital' id=".$user['id']."><i class='fas fa-link'></i></button>";
                $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
