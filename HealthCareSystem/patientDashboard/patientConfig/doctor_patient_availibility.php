<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

$doctorId = $_POST['doctorId'];
$patientId = $_POST['patientId'];
$appointmentDate = $_POST['appointmentDate'];

$startTime = date("Y-m-d H:i:s", strtotime($appointmentDate . "-30 minutes"));
$endTime = date("Y-m-d H:i:s", strtotime($appointmentDate . "+30 minutes"));

$query = "SELECT * FROM appointment WHERE doctorId = ? AND appointmentDate BETWEEN ? AND ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('iss', $doctorId, $startTime, $endTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['available' => false, 'reason' => 'Doctor is not available select another time or another doctor.']);
    exit;
}

$query = "SELECT * FROM appointment WHERE patientId = ? AND appointmentDate BETWEEN ? AND ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('iss', $patientId, $startTime, $endTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['available' => false, 'reason' => 'Patient have another appointment at that time please select another time.']);
    exit;
}

echo json_encode(['available' => true]);
?>
