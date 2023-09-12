<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';
session_start();

if (isset($_SESSION['adminId'])) {
    $adminId = $_SESSION['adminId'];

    $searchTerm = "";

    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $conn->real_escape_string($_POST['search']);
        $stmt = $conn->prepare("SELECT * FROM patient WHERE name LIKE ? OR gender LIKE ? OR dateOfBirth LIKE ? OR phoneNumber LIKE ? 
        OR mailAddress LIKE ? OR address LIKE ? ORDER BY name ASC");
        $searchLike = "%" . $searchTerm . "%";
        $stmt->bind_param('ssssss', $searchLike, $searchLike, $searchLike, $searchLike, $searchLike, $searchLike);
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
                        echo '<li style="margin-right: 25px; margin-top: 0px" class="nav-item mt-1"><a class="nav-link" href="doctors.php">Doctors</a></li>';                                            
                        echo '<form action="adminConfig/admin_logout.php" method="get">                        
                                <div style="margin-top: 5px" class="text-center"><button type="submit" name="logout-submit" class="btn btn-secondary">Logout</button></div>                     
                            </form>'; 
                    }
                ?>
            </ul>
            <div>
    </nav>


    <div class="container mt-4">
        <h2>Patient List</h2>

        <button type="button" class="btn btn-success mb-2 mt-3" data-toggle="modal" data-target="#addPatientModal">Add
            New
            Patient</button>

        <form action="" method="post">
            <div class="row mb-3 mt-2">
                <div class="col-md-5">
                    <input type="text" name="search" placeholder="Search for patients..." class="form-control"
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
                    <th>Gender</th>
                    <th>Date Of Birth</th>
                    <th>Phone Number</th>
                    <th>Mail Address</th>
                    <th>Address</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= $patient['name'] ?></td>
                    <td><?= $patient['gender'] ?></td>
                    <td><?= $patient['dateOfBirth'] ?></td>
                    <td><?= $patient['phoneNumber'] ?></td>
                    <td><?= $patient['mailAddress'] ?></td>
                    <td><?= $patient['address'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#editPatientModal<?= $patient['id'] ?>">Edit</button>

                        <!-- edit patient pop-up  -->
                        <div class="modal fade" id="editPatientModal<?= $patient['id'] ?>" tabindex="-1" role="dialog"
                            aria-labelledby="editPatientLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="adminConfig/edit_patient.php" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPatientLabel">Edit Patient</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="patientId" value="<?= $patient['id'] ?>">
                                            <div class="form-group">
                                                <label>Name:</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="<?= $patient['name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender:</label>
                                                <select name="gender" class="form-control">
                                                    <option value="Male"
                                                        <?= $patient['gender'] == 'Male' ? 'selected' : '' ?>>Male
                                                    </option>
                                                    <option value="Female"
                                                        <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>Female
                                                    </option>
                                                    <option value="Other"
                                                        <?= $patient['gender'] == 'Other' ? 'selected' : '' ?>>Other
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Birth:</label>
                                                <input type="date" class="form-control" name="dateOfBirth"
                                                    value="<?= $patient['dateOfBirth'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number:</label>
                                                <input type="text" class="form-control" name="phoneNumber"
                                                    value="<?= $patient['phoneNumber'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Mail Address:</label>
                                                <input type="email" class="form-control" name="mailAddress"
                                                    value="<?= $patient['mailAddress'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Address:</label>
                                                <textarea class="form-control"
                                                    name="address"><?= $patient['address'] ?></textarea>
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


        <!-- Add Patient pop-up  -->

        <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="adminConfig/add_new_patient.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPatientLabel">Add New Patient</h5>
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
                                <label>Gender:</label>
                                <select name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input type="date" class="form-control" name="dateOfBirth" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number:</label>
                                <input type="text" class="form-control" name="phoneNumber" required>
                            </div>
                            <div class="form-group">
                                <label>Mail Address:</label>
                                <input type="email" class="form-control" name="mailAddress" required>
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Patient</button>
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