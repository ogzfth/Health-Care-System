<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Care System</title>
    <!-- Custom css  -->
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/admin_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <!-- bootsrtap  -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jquerry  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        echo '<form action="adminConfig/admin_logout.php" method="get">                        
                                <div style="margin-top: 10px" class="text-center"><button type="submit" name="logout-submit" class="btn btn-secondary">Logout</button></div>                     
                            </form>'; 
                    }
                ?>
            </ul>
            <div>
    </nav>
</body>

</html>