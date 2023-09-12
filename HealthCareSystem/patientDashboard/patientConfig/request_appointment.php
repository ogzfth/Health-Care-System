<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

$doctorId = $_POST['doctorId'];
$patientId = $_POST['patientId'];
$appointmentDate = $_POST['appointmentDate'];

$query = "INSERT INTO appointment (patientId, doctorId,  appointmentDate) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iis', $patientId, $doctorId,  $appointmentDate);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

