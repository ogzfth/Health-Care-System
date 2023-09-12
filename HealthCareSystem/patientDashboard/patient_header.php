<?php
session_start();
require_once __DIR__ . '/patientConfig/patient_error.php';

?>

<html>

<head>
    <title>Health Care System</title>
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/patient_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </link>
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
        <div class="ml-5">
            <ul class="navbar-nav ml-5 mr-5 ">
                <?php               
                        if(isset($_SESSION['userId'])) {  
                            echo '<form action="patient_profile.php" method="get">                        
                            <div style="margin-right: 25px; margin-top: 10px;" class="text-center"><button class="btn btn-light ml-3" id="btn-profile-logout" type="submit" name="profile-submit">
                            Profile
                            </button></div>                     
                            </form>';
                            echo '<form action="patientConfig/patient_logout.php" method="get">                        
                                    <div style="margin-top: 10px;" class="text-center"><button type="submit" name="logout-submit" class="btn btn-dark" id="btn-profile-logout">Logout</button></div>                     
                                </form></div>';
                                            
                        } else {
                            echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="loginDropdown">';
                            echo '<a class="dropdown-item" href="patient_index.php">Patient Login</a>';
                            echo '<a class="dropdown-item" href="../doctorPortal/doctor_index.php">Doctor Login</a>';
                            echo '</div>';
                            echo '</li>';
                        }
                    ?>
            </ul>
            <div>
    </nav>

    <?php
      
            if(isset($_SESSION['userId'])){                           
              require_once __DIR__ . '/medical_history.php';                  
        }
        else {
                                
            if($_GET['register']?? null == "success"){               
                echo "<script type='text/javascript'>alert('Registered succesfully!');</script>";
            }
                     
            echo '<form action="patientConfig/patient_login.php" method="post" style="margin-bottom: 0px;">                
                        <section class="vh-100">
                            <div class="container py-5 h-100">
                                <div class="row d-flex justify-content-center align-items-center h-100">
                                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                                        <div class="card bg-dark text-white" style="border-radius: 1rem;">                                            
                                            <div class="card-body p-5 text-center">
                                            <h1 class="fw-bold mb-2 text-uppercase"> Hospital Management System</h1>
                                            <div class="mb-md-5 mt-md-4 pb-5">
                                            
                                            <h2 class="fw-bold mb-2 text-uppercase">Patient Login</h2>
                                            <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                           
                                            <div class="form-outline form-white mb-4">
                                              <input type="text" name="email" placeholder="Username or Email" class="form-control form-control-lg"></input>
                                              <label class="form-label" for="typeEmailX"></label>
                                            </div>
                                            <div class="form-outline form-white mb-4">
                                              <input type="password" name="password" placeholder="Password" class="form-control form-control-lg" ></input>
                                              <label class="form-label" for="typePasswordX"></label>
                                            </div>
                                            <button type="submit" name="login-submit" class="btn btn-outline-light btn-lg px-5">Login</button> 
                                          </div>
                                          <div>
                                            <p class="mb-0">Don\'t have an account? <a href="patient_signup.php" class="text-white-50 fw-bold">Sign Up</a>
                                            </p>
                                           </div>
                                    </div>
                                </div>
                              </div>
                            </div>  
                          </div>
                      </section>                                     
                    </form>                   
                    ';                                                                                              
        }        
    ?>

    <!-- bootsrap to use dropdown login  -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>