<?php 
    
  ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/patient_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/patient_styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navigation">
        <div class="container ml-0 mr-0">

            <?php
            echo '<a id="brand" class="navbar-brand" href="">
            <img src="images/hospital.svg" width="60" height="60" alt="Hospital Icon"> Health Care System
            </a>';                      
            ?>
        </div>
        <div style="width: 80%;">
        </div>
        <div class="ml-5">
            <ul class="navbar-nav ml-5 mr-5">
                <li class="nav-item"><a class="nav-link mt-1" href="patientDashboard/patient_index.php">Patient</a></li>
                <li class="nav-item"><a class="nav-link mt-1" href="doctorPortal/doctor_index.php">Doctor</a></li>
                <li class="nav-item"><a class="nav-link mt-1" href="adminPanel/admin_index.php">Admin</a></li>

            </ul>
            <div>
    </nav>


    <main class="container mt-4">
        <h1>Contact Us</h1>
        <p>If you have any questions, suggestions, or feedback, please feel free to contact us using the form below or
            via the provided contact information.</p>

        <form class="row mt-4">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-12 mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="col-12 mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <div class="mt-5">
            <h2>Contact Information</h2>
            <p>
                Helth Care System<br>
                Address: Okopowa 59, Warsaw, Poland<br>
                Phone: +48 (123) 456 789<br>
                Email: info@hospitalmanagement.com<br>
            </p>
        </div>
    </main>

    <?php
    require_once 'footer.php';
  ?>
</body>

</html>