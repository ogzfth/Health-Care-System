<?php 
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if (!isset($_SESSION['doctorId'])) {
    header('Location: doctor_header.php');
    exit();
}
$doctorId = $_SESSION['doctorId']; 
$searchTerm = "";
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $conn->real_escape_string($_POST['search']);
        $stmt = $conn->prepare("SELECT * FROM patient WHERE name LIKE ? ORDER BY name ASC");
        $searchLike = "%" . $searchTerm . "%";
        $stmt->bind_param('s', $searchLike);
    } else {
        $stmt = $conn->prepare("SELECT * FROM patient ORDER BY name ASC");
    }

    $stmt->execute();
    $patients = [];
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }

    $stmt->close();


if (isset($_SESSION['doctorEmail'])) {
    $email = $_SESSION['doctorEmail']; 
    // get loggedin doctor
    $query = "SELECT * FROM doctor WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No doctor record found for the logged-in user.";
    }
} else {
    echo "Not logged in or session expired.";
    header('Location: doctor_index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portal</title>
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/doctor_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bodyDesign">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 p-0 bg-light shadowed-div">
                <div class="list-group">
                    <a href="doctor_index.php"
                        class="list-group-item list-group-item-action active custom-list-group-item"
                        id="active-panel-selection"><i class="fas fa-user-injured ml-4"></i>Patients</a>
                    <a href="doctor_appointments.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>                    
                    <a href="doctor_profile.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0">
                <div class="container mt-2 mb-0 ml-3">
                    <h1>Welcome, Dr. <?php echo $user['name']; ?></h1>
                </div>
                <div class="container mt-2 ml-3">

                    <h3 class="mt-2">Patient List</h3>
                    <form action="" method="post">
                        <div class="row mb-3 mt-3">
                            <div class="col-md-5">
                                <input type="text" name="search" placeholder="Search for patients by name..."
                                    class="form-control" value="<?= isset($_POST['search']) ? $_POST['search'] : '' ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info">Search</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-hover" id="patients-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Patient Name</th>
                            </tr>
                        </thead>
                        <tbody class="scrollable-tbody">
                            <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <a
                                        href="doctorConfig/save_doctor_patient.php?patientId=<?= $patient['id'] ?>&doctorId=<?= $doctorId ?>&patientName=<?= $patient['name'] ?>">
                                        <?= $patient['name'] ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                            $stmt = $conn->prepare("SELECT a.*, p.name as 'patientName' FROM appointment as a
                            LEFT JOIN  patient as p on a.patientId = p.id
                            WHERE doctorId = ?");
                            $stmt->bind_param('i', $doctorId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $events = [];

                            while($row = $result->fetch_assoc()) {
                                $events[] = [
                                    'id'    => $row["id"],
                                    'title' => $row["patientName"],
                                    'start' => $row["appointmentDate"]
                                ];
                            }          
                    ?>

                </div>
            </div>
        </div>
    </div>


    <?php $conn->close(); ?>
</body>

</html>