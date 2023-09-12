<?php
require_once 'D:\Xampp\htdocs\HealthCareSystem\config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userMail = $_SESSION['email'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $mailAddress = $_POST['mailAddress'];

    $query = "UPDATE patient SET name = ?, gender = ?, dateOfBirth = ?, phoneNumber = ?, address = ?, mailAddress = ? WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $name, $gender, $dateOfBirth, $phoneNumber, $address, $mailAddress, $userMail);
    if ($stmt->execute()) {
        header('Location: ../patient_profile.php?message=Patient Update Successful');
    } else {
        die("Error updating record: " . $stmt->error);
    }
}
?>
