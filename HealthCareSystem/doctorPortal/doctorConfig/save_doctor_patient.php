<?php
session_start();

if(isset($_GET['doctorId']) && isset($_GET['patientId'])) {
    $_SESSION['doctorId'] = $_GET['doctorId'];
    $_SESSION['patientId'] = $_GET['patientId'];
    $_SESSION['patientName'] = $_GET['patientName'];
    header('Location: ../patient_detail.php');
    exit();
} else {
    echo "Error: Missing doctor or patient ID.";
}
?>
