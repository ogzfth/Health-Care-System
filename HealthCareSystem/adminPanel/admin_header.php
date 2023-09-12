<?php
session_start();
require_once __DIR__ . '/adminConfig/admin_error.php';                   
?>

<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/admin_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </link>
</head>

<body>
    <?php     
        require_once __DIR__ . '/admin_navigation.php';    
        if(isset($_SESSION['adminId'])){                            
                       
            require_once __DIR__ . '/admin_panel.php';      
        }
        else {
                                
            if($_GET['register']?? null == "success"){               
                echo "<script type='text/javascript'>alert('Registered succesfully!');</script>";
            }
                     
            echo '<form action="adminConfig/admin_login.php" method="post" style="margin-bottom: 0px;">                
                        <section class="vh-100 ">
                        <div class="container py-5 h-100" id="login-form">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                                <div class="card bg-dark text-white shadow-lg" style="border-radius: 1rem;"> 
                                    <div class="card-body p-5 text-center">
                                        <h1 class="fw-bold mb-2 text-uppercase">Health Care System</h1>
                                        <div class="mb-md-5 mt-md-4 pb-5">
                    
                                            <h2 class="fw-bold mb-2 text-uppercase">Admin Login</h2>
                                            <p class="text-white-50 mb-5">Please enter your login and password!</p>
                    
                                            <div class="form-outline form-white mb-4">
                                                <input type="text" name="email" placeholder="Username or Email" class="form-control form-control-lg shadow-sm">
                                                <label class="form-label" for="typeEmailX"></label>
                                            </div>
                                            <div class="form-outline form-white mb-4">
                                                <input type="password" name="password" placeholder="Password" class="form-control form-control-lg shadow-sm"> 
                                                <label class="form-label" for="typePasswordX"></label>
                                            </div>
                                            <button type="submit" name="login-submit" class="btn btn-outline-light btn-lg px-5 shadow-sm">Login</button> 
                    
                                            <div class="mt-4"> <!-- Adjusted for spacing -->
                                                <p class="mb-0">Don\'t have an account? <a href="admin_signup.php" class="text-white-50 fw-bold">Sign Up</a></p>
                                            </div>
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
</body>

</html>