<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST["patientId"];
    $studyDate = $_POST["studyDate"];
    $studyType = $_POST["studyType"];

    $stmt = $conn->prepare("SELECT name FROM patient WHERE id = ?");
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $patientName = $patient['name'];

    // Generate a random number to store as doc id
    $randomNumber = mt_rand(100000, 999999); 
    // File upload path
    $target_dir = "D:/Xampp/htdocs/HealthCareSystem/uploads/imagingStudyDocs/";

    $filename = pathinfo($_FILES["imagingStudyPdf"]["name"], PATHINFO_FILENAME);
    $extension = pathinfo($_FILES["imagingStudyPdf"]["name"], PATHINFO_EXTENSION);
    
    $cleanFilename = strtolower(str_replace(" ", "", $filename));
    $newFileName = $cleanFilename . "_" . strtolower(str_replace(" ", "", $patientName)) . "_" . $randomNumber . "." . $extension;
    $target_file = $target_dir . $newFileName;

    if (move_uploaded_file($_FILES["imagingStudyPdf"]["tmp_name"], $target_file)) {        
        $stmt = $conn->prepare("INSERT INTO imaging_study (patientId, studyDate, studyType, result) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $patientId, $studyDate, $studyType, $newFileName);
        $stmt->execute();
        header('Location: ../patient_detail.php?success=fileUploaded');
    } else {
        header('Location: ../patient_detail.php?error=fileNotUploaded');
    }
}
?>
