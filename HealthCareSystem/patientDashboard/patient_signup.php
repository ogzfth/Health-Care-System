<?php
require 'patientConfig/patient_error.php';
?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/patient_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </link>


    <title>Patient Signup</title>
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
            <ul class="navbar-nav ml-5 mr-5 mb-2">
                <?php               
                        if(isset($_SESSION['userId'])) {  
                            echo '<form action="patient_profile.php" method="get">                        
                            <div style="margin-right: 25px;" class="text-center"><button class="btn btn-light ml-3" id="btn-profile-logout" type="submit" name="profile-submit">
                            Profile
                            </button></div>                     
                            </form>';
                            echo '<form action="patientConfig/patient_logout.php" method="get">                        
                                    <div class="text-center"><button type="submit" name="logout-submit" class="btn btn-dark" id="btn-profile-logout">Logout</button></div>                     
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


    <section class="vh-100" style="background-color: #eee;">

        <div class="container h-100">

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <p style='text-align:right'>Are you a <a href='./patient_header.php'>Member</a></p>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form action="patientConfig/signup_logic.php" method="post" class="mx-1 mx-md-4">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="username" id="form3Example1c"
                                                    placeholder="Username" class="form-control"></input>
                                                <label class="form-label" for="form3Example1c"></label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" name="email" placeholder="E-mail"
                                                    class="form-control"></input>
                                                <label class="form-label" for="form3Example3c"></label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" placeholder="Password"
                                                    class="form-control"
                                                    title="At least 4 character no speacial character only letters and number"></input>
                                                <label class="form-label" for="form3Example4c"></label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password-repeat"
                                                    placeholder="Repeat Password" class="form-control"></input>
                                                <label class="form-label" for="form3Example4c"></label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="signup-submit"
                                                class="btn btn-primary btn-lg">Signup</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="../images/patient2.jpg" class="img-fluid" alt="Doctor image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

<?php
require '../footer.php';
?>