<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';
session_start();

if (isset($_SESSION['adminId'])) {
    $adminId = $_SESSION['adminId'];

    $searchTerm = "";

    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $conn->real_escape_string($_POST['search']);
        $stmt = $conn->prepare("SELECT * FROM doctor WHERE name LIKE ? OR specilization LIKE ? OR phoneNumber LIKE ? OR mailAddress LIKE ? ORDER BY name ASC");
        $searchLike = "%" . $searchTerm . "%";
        $stmt->bind_param('ssss', $searchLike, $searchLike, $searchLike, $searchLike);
    } else {
        $stmt = $conn->prepare("SELECT * FROM doctor ORDER BY name ASC");
    }

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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navigation" id="navbar-navigation">
        <div class="container ml-0 mr-0">
            <a id="brand" class="navbar-brand" href="admin_index.php">
                <img src="../images/hospital.svg" width="60" height="60" alt="Hospital Icon"> Health Care System
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


        </div>
        <div style="width: 80%;">
        </div>
        <div class="ml-5">
            <ul class="navbar-nav ml-5 mr-5">
                <?php                
                    if(isset($_SESSION['adminId'])) {  
                        echo '<li class="nav-item"><a class="nav-link mt-1" href="patients.php">Patients</a></li>';                                            
                        echo '<li style="margin-right: 25px;" class="nav-item mt-1"><a class="nav-link" href="doctors.php">Doctors</a></li>';                                            
                        echo '<form style="margin-top: 5px" action="adminConfig/admin_logout.php" method="get">                        
                                <div class="text-center"><button type="submit" name="logout-submit" class="btn btn-secondary">Logout</button></div>                     
                            </form>'; 
                    }
                ?>
            </ul>
            <div>
    </nav>

    <div class="container mt-4">
        <h2>Doctor List</h2>

        <button type="button" class="btn btn-success mb-2 mt-3" data-toggle="modal" data-target="#addDoctorModal">Add
            New
            Doctor</button>

        <form action="" method="post">
            <div class="row mb-3 mt-2">
                <div class="col-md-5">
                    <input type="text" name="search" placeholder="Search for doctors..." class="form-control"
                        value="<?= isset($_POST['search']) ? $_POST['search'] : '' ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Specilization</th>
                    <th>Phone Number</th>
                    <th>Mail Address</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?= $doctor['name'] ?></td>
                    <td><?= $doctor['specilization'] ?></td>
                    <td><?= $doctor['phoneNumber'] ?></td>
                    <td><?= $doctor['mailAddress'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#editDoctorModal<?= $doctor['id'] ?>">Edit</button>

                        <!-- edit doctor pop-up  -->
                        <div class="modal fade" id="editDoctorModal<?= $doctor['id'] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="editDoctorLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="adminConfig/edit_doctor.php" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDoctorLabel">Edit Doctor</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="doctorId" value="<?= $doctor['id'] ?>">
                                            <div class="form-group">
                                                <label>Name:</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="<?= $doctor['name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Specilization:</label>
                                                <input type="text" class="form-control" name="specilization"
                                                    value="<?= $doctor['specilization'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number:</label>
                                                <input type="text" class="form-control" name="phoneNumber"
                                                    value="<?= $doctor['phoneNumber'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Mail Address:</label>
                                                <input type="email" class="form-control" name="mailAddress"
                                                    value="<?= $doctor['mailAddress'] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <!-- Add Doctor pop-up  -->
        <div class="modal fade" id="addDoctorModal" tabindex="-1" role="dialog" aria-labelledby="addDoctorLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="adminConfig/add_new_doctor.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDoctorLabel">Add New Doctor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Specilization:</label>
                                <input type="text" class="form-control" name="specilization" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number:</label>
                                <input type="text" class="form-control" name="phoneNumber" required>
                            </div>
                            <div class="form-group">
                                <label>Mail Address:</label>
                                <input type="email" class="form-control" name="mailAddress" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Doctor</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
    require_once "../footer.php";
    ?>
</body>

</html>