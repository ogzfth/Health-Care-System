<?php 
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

$specialization = $_POST['specialization'];

if ($specialization == '') {
    $query = "SELECT id, name FROM doctor";
    $stmt = $conn->prepare($query);
} else {
    $query = "SELECT id, name FROM doctor WHERE specilization = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $specialization);
}

$stmt->execute();
$result = $stmt->get_result();

$doctors = [];

while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

echo json_encode($doctors);

?>
