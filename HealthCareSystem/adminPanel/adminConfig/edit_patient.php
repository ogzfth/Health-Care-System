<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST['patientId'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];    
    $address = $_POST['address'];
    $mailAddress = $_POST['mailAddress'];

    $query = "UPDATE patient SET name=?, gender=?, dateOfBirth=?, phoneNumber=?, mailAddress=?, address=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $name, $gender, $dateOfBirth, $phoneNumber, $mailAddress, $address, $patientId);
    if ($stmt->execute()) {        
        header('Location: ../patients.php?success=1');
    } else {        
        header('Location: ../patients.php?error=failed_to_update_patient');
    }
    $stmt->close();
}

