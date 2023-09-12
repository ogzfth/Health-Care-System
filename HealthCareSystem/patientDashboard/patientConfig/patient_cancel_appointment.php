<?php 
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

$response = ['status' => 'error', 'message' => 'Failed to cancel the appointment.'];

if(isset($_POST['appointmentId'])) {
    $appointmentId = $_POST['appointmentId'];

    $stmt = $conn->prepare("DELETE FROM appointment WHERE id = ?");
    $stmt->bind_param('i', $appointmentId);

    if($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Appointment cancelled successfully.';
    }
    
    $stmt->close();
}

echo json_encode($response);
?>
