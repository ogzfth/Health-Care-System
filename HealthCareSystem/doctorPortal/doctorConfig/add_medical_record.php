<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['doctorId']) && isset($_POST['patientId']) && isset($_POST['recordDate']) && isset($_POST['diagnosis']) && isset($_POST['treatment'])) {

    $doctorId = $_POST['doctorId'];
    $patientId = $_POST['patientId'];
    $recordDate = $_POST['recordDate'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];

    $stmt = $conn->prepare("INSERT INTO medical_record (patientId, doctorId, recordDate, diagnosis, treatment) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("iisss", $patientId, $doctorId, $recordDate, $diagnosis, $treatment);

    if ($stmt->execute()) {
        header('Location: ../patient_detail.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid Request";
    exit();
}
?>
