<?php 
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['userId'])) {
    echo "User ID is not set in the session.";
    exit; 
}



if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 

    $query = "SELECT * FROM patient WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

    } else {
        echo "No patient record found for the logged-in user.";
    }
} else {
    echo "Not logged in or session expired.";
}
  

    $getSpecializationsQuery = "SELECT DISTINCT specilization FROM doctor";
    $result = $conn->query($getSpecializationsQuery);
    $specializations = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $specializations[] = $row["specilization"];
        }   
    }    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal</title>

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/patient_style.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Scripts -->    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="patient_index.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-notes-medical ml-4"></i>Medical History</a>
                    <a href="appointments.php"
                        class="list-group-item list-group-item-action active custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>
                    <a href="doctors.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-md ml-4"></i>Doctors</a>
                    <a href="patient_profile.php" class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9">
                <h1 class="ml-4 mt-3">Welcome, <?php echo $user['name']; ?></h1>
                <h3 class="ml-4 mt-2">Your Appointments</h2>
                    <div class="container mt-3 mb-4 ml-4 mw-100 w-100 pr-5 p-0">
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                            data-target="#appointmentModal">
                            Request an Appointment
                        </button>

                        <?php 
                            $allDoctorsQuery = "SELECT id, name FROM doctor";
                            $result = $conn->query($allDoctorsQuery);
                            $allDoctors = $result->fetch_all(MYSQLI_ASSOC);
                        ?>

                        <!-- Appointment Request pop-up -->
                        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog"
                            aria-labelledby="appointmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="appointmentModalLabel">Request an Appointment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="appointmentForm">
                                            <input type="hidden" class="form-control" id="patientId" name="patientId"
                                                value=<?php echo $user['id']?>>
                                            
                                            <div class="form-group">
                                                <label for="specialization">Specialization</label>

                                                <select class="form-control" id="specialization" name="specialization"
                                                    required>
                                                    <option value="">All</option>
                                                    <?php foreach($specializations as $specialization): ?>
                                                    <option value="<?php echo $specialization; ?>">
                                                        <?php echo $specialization; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="doctor">Doctor</label>
                                                <select class="form-control" id="doctor" name="doctor" required>
                                                    <?php foreach($allDoctors as $doctor): ?>
                                                    <option value="<?php echo $doctor['id']; ?>">
                                                        <?php echo $doctor['name']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="appointmentDate">Date</label>
                                                <input type="datetime-local" class="form-control" id="appointmentDate"
                                                    name="appointmentDate" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            id="submitAppointment">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $stmt = $conn->prepare("SELECT a.*, p.name as 'patientName', d.name as 'doctorName', d.specilization as 'specilization' FROM appointment as a
                            LEFT JOIN  patient as p on a.patientId = p.id
                            LEFT JOIN  doctor as d on a.doctorId = d.id
                            WHERE patientId = ?");
                            $stmt->bind_param('i', $user['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $events = [];

                            while($row = $result->fetch_assoc()) {
                                $events[] = [
                                    'id'    => $row["id"],
                                    'title' => "Dr. " . $row["doctorName"] . "<br>" . $row["specilization"] ,
                                    'start' => $row["appointmentDate"]
                                ];
                            }
                            
                        ?>
                        <div id='container mt-5 mb-5' class='calendar'>
                            <div id='calendar'></div>
                        </div>

                        <script>
                        $(document).ready(function() {
                            $('#specialization').change(function() {
                                var specialization = $(this).val();

                                $.ajax({
                                    url: "http://localhost/HealthCareSystem/patientDashboard/patientConfig/get_doctors_by_specilization.php",
                                    method: "POST",
                                    data: {
                                        specialization: specialization
                                    },
                                    dataType: "json",
                                    success: function(data) {
                                        console.log("Data received:",
                                            data);

                                        if (!data || data.length === 0) {
                                            console.error(
                                                "No doctors found for the given specialization"
                                                );
                                            return;
                                        }

                                        $('#doctor').empty();
                                        $.each(data, function(key, value) {
                                            $('#doctor').append('<option value="' +
                                                value
                                                .id +
                                                '">' + value.name + '</option>');
                                        });
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error("Error fetching doctors:", textStatus,
                                            errorThrown);
                                    }
                                });
                            });
                        });
                        

                        $("#submitAppointment").click(function() {
                            var doctorId = $("#doctor").val();
                            var patientId = $("#patientId").val();
                            var appointmentDate = $("#appointmentDate").val();

                            $.ajax({
                                url: "http://localhost/HealthCareSystem/patientDashboard/patientConfig/doctor_patient_availibility.php",
                                method: "POST",
                                data: {
                                    doctorId: doctorId,
                                    patientId: patientId,
                                    appointmentDate: appointmentDate
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.available) {                                       
                                        bookAppointment(doctorId, patientId, appointmentDate);
                                    } else {
                                        Swal.fire('Unavailable!', response.reason, 'error');
                                    }
                                }
                            });
                        });

                        function bookAppointment(doctorId, patientId, appointmentDate) {
                            $.ajax({
                                url: "http://localhost/HealthCareSystem/patientDashboard/patientConfig/request_appointment.php",
                                method: "POST",
                                data: {
                                    doctorId: doctorId,
                                    patientId: patientId,
                                    appointmentDate: appointmentDate
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Success!', 'Appointment booked successfully!', 'success')
                                            .then(
                                                () => {
                                                    location
                                                        .reload();
                                                });
                                    } else {
                                        Swal.fire('Error!',
                                            'Error booking the appointment. Please try again later.',
                                            'error');
                                    }
                                }
                            });
                        }



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
                                            url: "http://localhost/HealthCareSystem/patientDashboard/patientConfig/patient_cancel_appointment.php",
                                            method: 'POST',
                                            data: {
                                                appointmentId: appointmentId
                                            },
                                            success: function(response) {
                                                response = JSON.parse(response);
                                                    if (response.status == 'success') {
                                                    var event = calendar
                                                        .getEventById(
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

                    </div>
            </div>

        </div>
    </div>


    <?php $conn->close(); ?>


    </div>

</body>

</html>

<?php 
require '../footer.php';
?>