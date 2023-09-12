<?php
require_once 'D:\Xampp\htdocs\HealthCareSystem\config/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Check if form is submitted

var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctorId = $_POST['doctorId'];
    $name = $_POST['name'];
    $specilization = $_POST['specilization'];    
    $phoneNumber = $_POST['phoneNumber'];    
    $mailAddress = $_POST['mailAddress'];

    $query = "UPDATE doctor SET name = ?, specilization = ?, phoneNumber = ?,  mailAddress = ? WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);    
    $stmt->bind_param('sssss', $name, $specilization, $phoneNumber, $mailAddress, $mailAddress);
    var_dump($doctorId);
    var_dump($_POST);

    if ($stmt->execute()) {
        header('Location: ../doctor_profile.php?message=Doctor Update Successful');
    } else {
        die("Error updating record: " . $stmt->error);
    }
}
?>
