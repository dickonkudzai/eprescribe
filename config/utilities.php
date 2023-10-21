<?php
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
                $output .= "<td></td>";
            $output .= "</tr>";
        }
        return $output;
    }
