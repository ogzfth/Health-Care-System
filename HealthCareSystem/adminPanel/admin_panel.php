<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if (isset($_SESSION['adminId'])) {
    $adminId = $_SESSION['adminId']; 
    // Get all patients
    $stmt = $conn->prepare("SELECT * FROM patient");
    $stmt->execute();

    $patients = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
    $stmt->close();

    // get all doctors
    $stmt = $conn->prepare("SELECT * FROM doctor");  
    $stmt->execute();

    $doctors = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
    $stmt->close();
} else {
    header('Location: admin_header.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Custom styling  -->
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/admin_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <div class="container mt-4">
        <h2 style='marging-bottom: 50px;'>Welcome to Admin Panel</h2>
    </div>

    <div class="container mt-2">
        <div class="row">
            <!-- Patients Box -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <a href="patients.php" class="btn btn-light">
                        <img src="../images/patient.jpg" class="card-img-top mx-auto d-block" alt="Patient Icon">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Patients</h5>
                        <p class="card-text">Manage and view all patients.</p>
                        <a href="patients.php" class="btn btn-primary">Go to Patients</a>
                    </div>
                </div>
            </div>

            <!-- Doctors Box -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <a href="doctors.php" class="btn btn-light">
                        <img src="../images/surgery.jpg" class="card-img-top mx-auto d-block" alt="Doctor Icon">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Doctors</h5>
                        <p class="card-text">Manage and view all doctors.</p>
                        <a href="doctors.php" class="btn btn-primary">Go to Doctors</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>