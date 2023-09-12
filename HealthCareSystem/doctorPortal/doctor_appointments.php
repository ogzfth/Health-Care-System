<?php 
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';
if (!isset($_SESSION['doctorId'])) {
    header('Location: doctor_header.php');
    exit();
}
$doctorId = $_SESSION['doctorId']; 
$searchTerm = "";

    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $searchTerm = $conn->real_escape_string($_POST['search']);
        $stmt = $conn->prepare("SELECT * FROM patient WHERE name LIKE ? ORDER BY name ASC");
        $searchLike = "%" . $searchTerm . "%";
        $stmt->bind_param('s', $searchLike);
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


if (isset($_SESSION['doctorEmail'])) {
    $email = $_SESSION['doctorEmail']; 

    $query = "SELECT * FROM doctor WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
        
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

    } else {
        echo "No doctor record found for the logged-in user.";
    }
} else {
    echo "Not logged in or session expired.";
    header('Location: doctor_index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portal</title>
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/doctor_style.css">
    <link rel="stylesheet" href="http://localhost/HealthCareSystem/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">   

    <!-- jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->

    <!-- Fullcalendar -->
    <!-- <script type="text/javascript" src="fullcalendar-6.1.8\dist\index.global.min.js"></script> -->

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

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
                        class="list-group-item list-group-item-action active custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>
                    <a href="doctor_profile.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0" >
                <div class="container mt-2 mb-4 ml-3">
                    <h1>Welcome, Dr. <?php echo $user['name']; ?></h1>
                    <h3 class="mb-3">Your Appointments</h2>
                    

                </div>

                <div class="container mt-3 mb-4 ml-4 mw-100 w-100 pr-5 p-0">
                    <div id='container mt-5 mb-5' class='calendar'>
                        <div id='calendar'></div>
                    </div>
                </div>
                <div class="container mt-3 mb-5">

                    <?php
                        $stmt = $conn->prepare("SELECT a.*, p.name as 'patientName' FROM appointment as a
                        LEFT JOIN  patient as p on a.patientId = p.id
                        WHERE doctorId = ?");
                        $stmt->bind_param('i', $doctorId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $events = [];

                        while($row = $result->fetch_assoc()) {
                            $events[] = [
                                'id'    => $row["id"],
                                'title' => $row["patientName"],
                                'start' => $row["appointmentDate"]
                            ];
                        }
                        
                    ?>                   


                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');
                        var eventsData = <?php echo json_encode($events); ?>;

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth', 
                            events: eventsData,
                            headerToolbar: { 
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,dayGridWeek,dayGridDay'
                            },
                            eventTimeFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            },
                            height: 'auto',
                            eventContent: function(info) {
                                let content = document.createElement('div');
                                content.innerHTML = `
                        <div> ${info.event.title}</div>
                        <div> ${info.event.start.toLocaleString([], {month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit'})}</div>
                        <div><a href="#" class="cancel-appointment" data-appointment-id="${info.event.id}">Cancel Appointment</a></div>
                    `;
                                return {
                                    domNodes: [content]
                                };
                            },

                        });
                        $(document).on('click', '.cancel-appointment', function(e) {
                            e.preventDefault();
                            let appointmentId = $(this).data('appointment-id');

                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Do you want to cancel this appointment?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, cancel it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: 'doctorConfig/cancel_appointment.php',
                                        method: 'POST',
                                        data: {
                                            appointmentId: appointmentId
                                        },
                                        success: function(response) {
                                            response = JSON.parse(response);
                                            if (response.status == 'success') {
                                                var event = calendar.getEventById(
                                                    appointmentId);
                                                if (event) {
                                                    event.remove();
                                                }
                                                Swal.fire(
                                                    'Cancelled!',
                                                    'The appointment has been cancelled.',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire(
                                                    'Error!',
                                                    response.message,
                                                    'error'
                                                );
                                            }
                                        }
                                    });
                                }
                            });
                        });

                        calendar.render();

                    });
                    </script>
                    <?php $conn->close(); ?>


                </div>

            </div>
        </div>
    </div>




</body>

</html>

<?php 
require '../footer.php';
?>