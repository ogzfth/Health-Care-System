<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];    
    $mailAddress = $_POST['mailAddress'];
    $address = $_POST['address'];

    $query = "INSERT INTO patient (name, gender, dateOfBirth, phoneNumber, mailAddress, address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssss', $name, $gender, $dateOfBirth, $phoneNumber, $mailAddress, $address);
    if ($stmt->execute()) {
        header('Location: ../patients.php?success=1');
    } else {
        header('Location: ../patients.php?error=failed_to_add_patient');
    }
    $stmt->close();
}
?>
