<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Care System</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">            
            <a id="brand" class="navbar-brand" href="patient_index.php">
                <img src="../images/hospital-icon.svg" width="50" height="50" alt="Hospital Icon"> Hospital Management System
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">                    
                    <li class="nav-item">
                        <a class="nav-link" href="patient_index.php">Home</a>
                    </li>

                    <?php                
                    if(isset($_SESSION['userId'])) {  
                        echo '<li class="nav-item"><a class="nav-link" href="../patientDashboard/appointments.php">Your Appointments</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="patient_index.php">Medical History</a></li>';
                        echo '<form action="patientConfig/patient_logout.php" method="get">                        
                                <div class="text-center"><button type="submit" name="logout-submit" class="btn btn-primary">Logout</button></div>                     
                              </form>';
                     
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
            </div>
        </div>

    </nav>

    <!-- Link to Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
