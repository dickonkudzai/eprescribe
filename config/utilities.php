<?php
    function checkDrugQuantity($dbConnect, $drugId, $quantity){
        $query = "SELECT quantity FROM pharmacy_stock WHERE drug_id = $drugId";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return $result['quantity'];

    }
    function getDrugsSelect($dbConnect){
        $query = "SELECT * FROM drugs WHERE status = 1 AND blocked = 0";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $drug){
            $output .= "<option value=".$drug['id'].">".$drug['drug_name']."</option>";
        }
        return $output;
    }

    function getPharmacyStock($dbConnect, $pharmacyId){
        $query = "SELECT p.*, d.drug_name, d.blocked drug_blocked, d.controlled drug_controlled,CONCAT(u.first_name, ' ', u.last_name) staff
                FROM pharmacy_stock p 
                INNER JOIN drugs d on p.drug_id = d.id
                INNER JOIN user u ON p.created_by = u.id
                WHERE p.status = 1 AND p.pharmacy_id = $pharmacyId";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $prescription){
            $output .= "<tr>";
            $output .= "<td>".$prescription['id']."</td>";
            $output .= "<td>".$prescription['drug_name']."</td>";
            $output .= "<td>".date("d F Y", strtotime($prescription['expiry_date']))."</td>";
            $output .= "<td>".$prescription["quantity"]."</td>";
            $output .= "<td>".$prescription['staff']."</td>";
            $output .= "<td>";
            $output .="<button class='btn btn-sm btn-warning edit_prescription' id=".$prescription['id']."><i class='fas fa-pen'></i></button>&nbsp";
            $output .="<button class='btn btn-sm btn-danger delete_prescription' id=".$prescription['id']."><i class='fas fa-trash'></i></button>&nbsp";
            $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
    function getPrescriptions($dbConnect){
        $query = "SELECT p.*,CONCAT(p2.first_name, ' ', p2.last_name) patient, CONCAT(U.first_name, ' ', U.last_name) attender
                FROM prescriptions p 
                INNER JOIN user u on p.added_by = u.id
                INNER JOIN patient p2 on p.patient_id = p2.id
                WHERE p.status = 1 ";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $prescription){
            $output .= "<tr>";
            $output .= "<td>".$prescription['id']."</td>";
            $output .= "<td>".date("d F Y", strtotime($prescription['date_of_prescription']))."</td>";
            $output .= "<td>".$prescription["patient"]."</td>";
            $output .= "<td>".$prescription['attender']."</td>";
            $output .= "</tr>";
        }
        return $output;
    }
    function getPatientPrescriptions($dbConnect, $patientId){
        $query = "SELECT p.*,CONCAT(p2.first_name, ' ', p2.last_name) patient, CONCAT(U.first_name, ' ', U.last_name) attender
                FROM prescriptions p 
                INNER JOIN user u on p.added_by = u.id
                INNER JOIN patient p2 on p.patient_id = p2.id
                WHERE p.status = 1 AND p.patient_id = $patientId";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $prescription){
            $output .= "<tr>";
            $output .= "<td>".$prescription['id']."</td>";
            $output .= "<td>".date("d F Y", strtotime($prescription['date_of_prescription']))."</td>";
            $output .= "<td>".$prescription["patient"]."</td>";
            $output .= "<td>".$prescription['attender']."</td>";
            $output .= "<td>";
            $output .="<button class='btn btn-sm btn-warning edit_prescription' id=".$prescription['id']."><i class='fas fa-pen'></i></button>&nbsp";
            $output .="<button class='btn btn-sm btn-danger delete_prescription' id=".$prescription['id']."><i class='fas fa-trash'></i></button>&nbsp";
            $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
    function getPatientConsultations($dbConnect, $patientId){
        $query = "SELECT c.*, CONCAT(U.first_name, ' ', U.last_name) attender
            FROM consultation c 
            INNER JOIN user u on c.attended_by = u.id
            WHERE c.status = 1 AND c.patient_id = $patientId";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $consultation){
            $output .= "<tr>";
                $output .= "<td>".$consultation['id']."</td>";
                $output .= "<td>".date("d F Y", strtotime($consultation['consultation_date']))."</td>";
                $output .= "<td>".$consultation["attender"]."</td>";
                $output .= "<td>".$consultation['weight']."</td>";
                $output .= "<td>".$consultation['temperature']."</td>";
                $output .= "<td>";
                    $output .="<button class='btn btn-sm btn-warning edit_consultation' id=".$consultation['id']."><i class='fas fa-pen'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-danger delete_consultation' id=".$consultation['id']."><i class='fas fa-trash'></i></button>&nbsp";
                $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }

function getPharmacies($dbConnect){
    $query = "SELECT * FROM pharmacy WHERE status = 1";
    $statement = $dbConnect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = "";
    foreach ($result as $pharmacy){
        $output .= "<tr>";
        $output .= "<td>".$pharmacy['id']."</td>";
        $output .= "<td>".$pharmacy['pharmacy_name']."</td>";
        $output .= "<td>".$pharmacy['pharmacy_address']."</td>";
        $output .= "<td>";
        $output .="<button class='btn btn-sm btn-warning edit_pharmacy' id=".$pharmacy['id']."><i class='fas fa-pen'></i></button>&nbsp";
        $output .="<button class='btn btn-sm btn-danger delete_pharmacy' id=".$pharmacy['id']."><i class='fas fa-trash'></i></button>&nbsp";
        $output .="<button class='btn btn-sm btn-info' id=".$pharmacy['id']."><a href='../pharmacy/profile?id=".$pharmacy['id']."'><i class='fas fa-id-badge'></i></a></button>";
        $output .= "</td>";
        $output .= "</tr>";
    }
    return $output;
}
{

}
    function getPatients($dbConnect){
        $query = "SELECT * FROM patient WHERE status = 1";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $patient){
            $output .= "<tr>";
                $output .= "<td>".$patient['id']."</td>";
                $output .= "<td>".$patient['first_name']." ".$patient['last_name']."</td>";
                $output .= "<td>".$patient['address']."</td>";
                $output .= "<td>".$patient['mobile_number']."</td>";
                $output .= "<td>".$patient['email']."</td>";
                $output .= "<td>";
                    $output .="<button class='btn btn-sm btn-warning edit_patient' id=".$patient['id']."><i class='fas fa-pen'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-danger delete_patient' id=".$patient['id']."><i class='fas fa-trash'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-info' id=".$patient['id']."><a href='../patient/profile?id=".$patient['id']."'><i class='fas fa-id-badge'></i></a></button>";
                $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
    function getHospitalsSelect($dbConnect){
        $query = "SELECT * FROM hospital WHERE status = 1";
        $statement =$dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $hospital){
            $output .= "<option value=".$hospital['id'].">".$hospital['hospital_name']."</option>";
        }
        return $output;
    }
    function getDoctorsSelect($dbConnect){
        $query = "SELECT * FROM user WHERE role_id = 4";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $doctor){
            $output .= "<option value=".$doctor['id'].">".$doctor['first_name']." ".$doctor['last_name']."</option>";
        }
        return $output;
    }
    function getDrugs($dbConnect){
        $query = "SELECT * FROM drugs WHERE status = 1";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $drug){
            $blocked = $drug['blocked']==0?'<span class="badge badge-success">Unblocked</span>':'<span class="badge badge-danger">Blocked</span>';
            $controlled = $drug['controlled']==0?'<span class="badge badge-info">Open</span>':'<span class="badge badge-dark">Controlled</span>';
            $output .= "<tr>";
            $output .= "<td>".$drug['id']."</td>";
            $output .= "<td>".$drug['drug_name']."</td>";
            $output .= "<td>".$blocked."</td>";
            $output .= "<td>".$controlled."</td>";
            $output .= "<td>";
            $output .="<button class='btn btn-sm btn-warning edit_drug' id=".$drug['id']."><i class='fas fa-pen'></i></button>&nbsp";
            $output .="<button class='btn btn-sm btn-danger delete_drug' id=".$drug['id']."><i class='fas fa-trash'></i></button>&nbsp";
            $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
    function getHospitals($dbConnect){
        $query = "SELECT * FROM hospital WHERE status = 1";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output = "";
        foreach ($result as $hospital){
            $output .= "<tr>";
                $output .= "<td>".$hospital['id']."</td>";
                $output .= "<td>".$hospital['hospital_name']."</td>";
                $output .= "<td>".$hospital['address']."</td>";
                $output .= "<td>".$hospital['mobile_number']."</td>";
                $output .= "<td>".$hospital['email']."</td>";
                $output .= "<td>";
                    $output .="<button class='btn btn-sm btn-warning edit_hospital' id=".$hospital['id']."><i class='fas fa-pen'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-danger delete_hospital' id=".$hospital['id']."><i class='fas fa-trash'></i></button>&nbsp";
                    $output .="<button class='btn btn-sm btn-info link_doctor_to_hospital' id=".$hospital['id']."><i class='fas fa-link'></i></button>";
                $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
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

    function getTotalPrescriptions($dbConnect){
        $query = "SELECT * FROM prescriptions WHERE status = 1";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    function getTotalDoctors($dbConnect){
        $query = "SELECT * FROM user WHERE role_id = 4";
        $statement = $dbConnect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

    function getTotalPharmacies($dbConnect){
        $query = "SELECT * FROM pharmacy WHERE status = 1";
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
                        $output .="<button class='btn btn-sm btn-info link_hospital_to_doctor' id=".$user['id']."><i class='fas fa-link'></i></button>";
                $output .= "</td>";
            $output .= "</tr>";
        }
        return $output;
    }
