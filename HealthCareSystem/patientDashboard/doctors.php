<?php
require_once __DIR__ . '/../config/db.php';

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <!-- custom styling  -->
    <link rel="stylesheet" href="../css/patient_style.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- scripts  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark navigation">
        <div class="container ml-0 mr-0">
            <a id="brand" class="navbar-brand" href="patient_index.php">
                <img src="../images/hospital.svg" width="60" height="60" alt="Hospital Icon"> Health Care System
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex justify-content-start">
                <div>
                </div>
            </div>

        </div>
        <div style="width: 80%;">
        </div>
        <div class="ml-5 mr-5">
            <ul class="navbar-nav ml-5">
                <?php               
                        if(isset($_SESSION['userId'])) {  
                            echo '<form action="patient_profile.php" method="get">                        
                            <div style="margin-right: 25px; margin-top: 5px;" class="text-center"><button class="btn btn-light ml-3" id="btn-profile-logout" type="submit" name="profile-submit">
                            Profile
                            </button></div>                     
                            </form>';
                            echo '<form action="patientConfig/patient_logout.php" method="get">                        
                                    <div style="margin-top: 5px;" class="text-center"><button type="submit" name="logout-submit" class="btn btn-dark" id="btn-profile-logout">Logout</button></div>                     
                                </form></div>';
                                            
                        } else {
                            echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="loginDropdown">';
                            echo '<a class="dropdown-item" href="patient_index.php">Patient Login</a>';
                            echo '<a class="dropdown-item" href="doctorDashboard/doctorConfig/doctor_login.php">Doctor Login</a>';
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
                    <a href="patient_index.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-notes-medical ml-4"></i>Medical History</a>
                    <a href="appointments.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>                    
                    <a href="doctors.php" class="list-group-item list-group-item-action active custom-list-group-item"><i
                            class="fas fa-user-md ml-4"></i>Doctors</a>
                    <a href="patient_profile.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0">
               


                <div id="specializations" class="subpage mt-4 ml-5 mb-5">                    
                    <h2>Doctors</h2>
                        <?php
                        // Fetch distinct specilizations
                        $sql = "SELECT DISTINCT specilization FROM `doctor`";
                        $result = $conn->query($sql);

                        echo '<div class="accordion" id="specilizationAccordion">';
                        
                        if ($result->num_rows > 0) {
                            $counter = 0;                                              
                            while ($specilization_row = $result->fetch_assoc()) {
                                $specilization = $specilization_row['specilization'];                                
                                
                                $doctors_sql = "SELECT name, mailAddress FROM `doctor` WHERE specilization = '$specilization'";
                                $doctors_result = $conn->query($doctors_sql);
                                
                                echo '
                                <div class="card">
                                    <div class="card-header" id="heading'.$counter.'">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse'.$counter.'" aria-expanded="true" aria-controls="collapse'.$counter.'">
                                               '.$specilization.'
                                            </button>
                                        </h2>
                                    </div>                                    
                                    <div id="collapse'.$counter.'" class="collapse" aria-labelledby="heading'.$counter.'" data-parent="#specilizationAccordion">
                                        <div class="card-body">';
                                        
                                        if ($doctors_result->num_rows > 0) {
                                            while ($doctor_row = $doctors_result->fetch_assoc()) {
                                                $name = $doctor_row['name'];
                                                $mailAddress = $doctor_row['mailAddress'];
                                                echo '<p>'.$name.' (<a href="mailto:'.$mailAddress.'">'.$mailAddress.'</a>)</p>';
                                            }
                                        } else {
                                            echo "No doctors found for this specialization.";
                                        }                                        
                                echo '  </div>
                                    </div>
                                </div>';
                                
                                $counter++; 
                            }
                        } else {
                            echo "No specializations found.";
                        }
                        echo '</div>'; 
                        ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php 
require '../footer.php';
?>