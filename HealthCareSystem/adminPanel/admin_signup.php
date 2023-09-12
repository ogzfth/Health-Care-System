<?php
require 'admin_navigation.php';
require 'adminConfig/admin_error.php';
?>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/admin_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </link>
    <title> Sign Up as Admin</title>
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">

        <div class="container h-100">

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <p style='text-align:right'>Are you a <a href='admin_index.php'>Admin</a></p>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form action="adminConfig/admin_signup_logic.php" method="post"
                                        class="mx-1 mx-md-4">
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
                                    <img src="../images/doctorTools.jpg" class="img-fluid" alt="Admin image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>

<?php
require '../footer.php';
?>