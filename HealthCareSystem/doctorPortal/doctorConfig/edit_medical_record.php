<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {   
    $recordId = $_POST['recordId'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];

    $query = "UPDATE medical_record SET diagnosis=?, treatment=? WHERE id=?";    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $diagnosis, $treatment, $recordId);
    
    if ($stmt->execute()) {
        header('Location: ../patient_detail.php');
    } else {        
        header('Location: ../patient_detail.php?error=failed_to_update_record');
    }
    
    $stmt->close();
}
?>
