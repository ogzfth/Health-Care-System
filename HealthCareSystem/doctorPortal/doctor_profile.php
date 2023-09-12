<?php
session_start();
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';
 
    $doctorId = $_SESSION['doctorId']; 
    // get loggeding doctor 
    $query = "SELECT * FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/doctor_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navigation" id="navbar-navigation">
        <div class="container ml-0 mr-0">
            <a id="brand" class="navbar-brand" href="doctor_index.php">
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
            <ul class="navbar-nav ml-5 mr-5 mb-2">
                <?php               
                        if(isset($_SESSION['doctorId'])) {  
                            echo '<form action="doctor_profile.php" method="get">                        
                            <div style="margin-right: 25px; margin-top: 10px;" class="text-center"><button class="btn btn-light ml-3" id="btn-profile-logout" type="submit" name="profile-submit">
                            Profile
                            </button></div>                     
                            </form>';
                            echo '<form action="doctorConfig/doctor_logout.php" method="get">                        
                                    <div style="margin-top: 10px; class="text-center"><button type="submit" name="logout-submit" class="btn btn-dark" id="btn-profile-logout">Logout</button></div>                     
                                </form></div>';
                                            
                        } else {
                            echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="loginDropdown">';
                            echo '<a class="dropdown-item" href="../patientDashboard/patient_index.php">Patient Login</a>';
                            echo '<a class="dropdown-item" href="doctor_index.php">Doctor Login</a>';
                            echo '</div>';
                            echo '</li>';
                        }
                    ?>
            </ul>
            <div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 p-0 bg-light shadowed-div">
                <div class="list-group">
                    <a href="doctor_index.php" class="list-group-item list-group-item-action custom-list-group-item"
                        id="active-panel-selection"><i class="fas fa-user-injured ml-4"></i>Patients</a>
                    <a href="doctor_appointments.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>
                    <a href="doctor_profile.php"
                        class="list-group-item list-group-item-action active custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0">
                <div class="container mt-5 mb-5">
                    <div class="card">
                        <div class="card-header bg-dark text-white text-center">
                            <h3>Doctor Profile</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="row justify-content-center mb-3">
                                <div class="col-md-8">
                                    <h4 class="mb-4"><?php echo $user['name']; ?></h4>
                                    <p><i class="fas fa-user-md"></i> <strong>Name:</strong>
                                        <?php echo $user['name']; ?></p>
                                    <p><i class="fas fa-briefcase-medical"></i> <strong>Specilization:</strong>
                                        <?php echo $user['specilization']; ?></p>
                                    <p><i class="fas fa-envelope"></i> <strong>Email:</strong>
                                        <?php echo $user['mailAddress']; ?>
                                    </p>
                                    <p><i class="fas fa-phone-alt"></i> <strong>Phone:</strong>
                                        <?php echo $user['phoneNumber']; ?>
                                    </p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#updateModal">Edit
                                Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update profile pop-up  -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="doctorConfig/update_doctor_profile.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo $user['name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="specilization">Specilization</label>
                            <input type="text" class="form-control" id="specilization" name="specilization"
                                value="<?php echo $user['specilization']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="mailAddress">Email</label>
                            <input type="email" class="form-control" id="mailAddress" name="mailAddress"
                                value="<?php echo $user['mailAddress']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber"
                                value="<?php echo $user['phoneNumber']; ?>">
                        </div>
                        <input type="hidden" name="doctorId" value="<?php echo $doctorId; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<?php 
require '../footer.php';
?>

</html>