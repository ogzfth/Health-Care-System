<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST["patientId"];
    $testDate = $_POST["testDate"];
    $testType = $_POST["testType"];

    $stmt = $conn->prepare("SELECT name FROM patient WHERE id = ?");
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $patientName = $patient['name'];

    // Generate a random number to store as doc id
    $randomNumber = mt_rand(100000, 999999);

    $target_dir = "D:/Xampp/htdocs/HealthCareSystem/uploads/labResultsDocs/";

    $filename = pathinfo($_FILES["labResultPdf"]["name"], PATHINFO_FILENAME);
    $extension = pathinfo($_FILES["labResultPdf"]["name"], PATHINFO_EXTENSION);
    
    $cleanFilename = strtolower(str_replace(" ", "", $filename));
    $newFileName = $cleanFilename . "_" . strtolower(str_replace(" ", "", $patientName)) . "_" . $randomNumber . "." . $extension;
    $target_file = $target_dir . $newFileName;

    if (move_uploaded_file($_FILES["labResultPdf"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO lab_test (patientId, testDate, testType, results) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $patientId, $testDate, $testType, $newFileName);
        $stmt->execute();
        header('Location: ../patient_detail.php?success=fileUploaded');
        exit();
    } else {
        header('Location: ../patient_detail.php?error=fileNotUploaded');
    }
}
?>
