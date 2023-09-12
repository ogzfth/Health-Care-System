<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $doctorId = $_POST['doctorId'];
    $name = $_POST['name'];
    $specilization = $_POST['specilization'];
    $phoneNumber = $_POST['phoneNumber'];    
    $mailAddress = $_POST['mailAddress'];

    $query = "UPDATE doctor SET name=?, specilization=?, phoneNumber=?, mailAddress=? WHERE id=?";    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $name, $specilization, $phoneNumber, $mailAddress, $doctorId);
    if ($stmt->execute()) {        
        header('Location: ../doctors.php?success=2');
    } else {        
        header('Location: ../doctors.php?error=failed_to_update_doctor');
    }
    $stmt->close();
}

