<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specilization = $_POST['specilization'];
    $phoneNumber = $_POST['phoneNumber'];    
    $mailAddress = $_POST['mailAddress'];
    $query = "INSERT INTO doctor (name, specilization, phoneNumber, mailAddress) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $name, $specilization, $phoneNumber, $mailAddress);
    if ($stmt->execute()) {
        header('Location: ../doctors.php?success=1');
    } else {
        header('Location: ../doctors.php?error=failed_to_add_doctor');
    }
    $stmt->close();
}
?>
