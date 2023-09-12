<?php
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 

    $query = "SELECT * FROM patient WHERE mailAddress = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the patient's information
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

    } else {
        echo "No patient record found for the logged-in user.";
    }
} else {
    echo "Not logged in or session expired.";
    exit;
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>

    <link rel="stylesheet" href="../css/patient_style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- fontawesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 p-0 bg-light shadowed-div">
                <div class="list-group">
                    <a href="patient_index.php"
                        class="list-group-item list-group-item-action active custom-list-group-item" id="active-panel-selection">
                            <i class="fas fa-notes-medical ml-4"></i>Medical History</a>
                    <a href="appointments.php" class="list-group-item list-group-item-action custom-list-group-item">
                        <i class="fas fa-calendar-check ml-4"></i>Your Appointments</a>                    
                    <a href="doctors.php" class="list-group-item list-group-item-action custom-list-group-item">
                        <i class="fas fa-user-md ml-4"></i>Doctors</a>
                    <a href="patient_profile.php" class="list-group-item list-group-item-action custom-list-group-item">
                        <i class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0">
                <div id="medical-history" class="section">
                    <!-- Medical history of logged in user -->                    
                    <div id="medical-history-details" class="subpage ml-5 mt-3">
                    <h1 id="welcome-banner" class="mt-3 ml-3">Welcome, <?php echo $user['name']; ?></h1>
                        <h4 class="ml-3">Medical History for Selected Specialization</h4>
                            <?php
                            $userMail = $_SESSION['email'];
                            $sql = "SELECT DISTINCT d.specilization 
                            FROM doctor as d 
                            LEFT JOIN medical_record as mr ON d.id = mr.doctorId 
                            LEFT JOIN patient as p ON mr.patientId = p.id 
                            WHERE p.mailAddress = ? 
                            ORDER BY d.specilization ASC";
                            
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $userMail);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            $specializations = [];
                            while ($row = $result->fetch_assoc()) {
                                $specializations[] = $row['specilization'];
                            }
                        ?>
                            <div class="container ml-0 mr-0 mw-100 form-group">
                                <label for="specializationFilter">Filter by Specialization:</label>
                                <select id="specializationFilter" class="form-control">
                                    <option value="all">All</option>
                                    <?php foreach ($specializations as $specialization): ?>
                                    <option value="<?php echo htmlspecialchars($specialization); ?>">
                                        <?php echo htmlspecialchars($specialization); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php                        
                        $userMail = $_SESSION['email'];                       
                        $sql = "SELECT p.name as 'patientName', mr.recordDate, mr.diagnosis, mr.treatment, d.name as 'doctorName', d.specilization FROM medical_record as mr
                        LEFT JOIN patient as p ON mr.patientId = p.id
                        LEFT JOIN doctor as d ON mr.doctorId = d.id
                        where p.mailAddress=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $userMail);
                        $stmt->execute();
                        $medicalHistory = $stmt->get_result();
                        ?>

                            <div class="container ml-0 mr-0 mw-100">
                                <div class="row">
                                    <div class="scrollable-table col-12">
                                        <table class="table table-bordered table-hover" id="medicalHistoryTable">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="col-patient">Patient</th>
                                                    <th class="col-date">Date</th>
                                                    <th class="col-specialization">Specialization</th>
                                                    <th class="col-doctor">Doctor</th>
                                                    <th class="col-diagnosis">Diagnosis</th>
                                                    <th class="col-treatment">Treatment</th>
                                                </tr>
                                            </thead>
                                            <tbody class="scrollable-tbody">
                                                <?php while($entry = $medicalHistory->fetch_assoc()): ?>
                                                <tr data-specialization="<?php echo $entry['specilization']; ?>">
                                                    <td class="col-patient"><?php echo $entry['patientName']; ?></td>
                                                    <td class="col-date"><?php echo $entry['recordDate']; ?></td>
                                                    <td class="col-specialization">
                                                        <?php echo $entry['specilization']; ?>
                                                    </td>
                                                    <td class="col-doctor"><?php echo $entry['doctorName']; ?></td>
                                                    <td class="col-diagnosis"><?php echo $entry['diagnosis']; ?></td>
                                                    <td class="col-treatment"><?php echo $entry['treatment']; ?></td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Lab Test -->
                            <?php
                            $query = "SELECT lt.* FROM lab_test as lt
                            LEFT JOIN patient as p on lt.patientId = p.id
                            WHERE p.mailAddress=?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('s', $userMail);  
                            $stmt->execute();
                            $results = $stmt->get_result();
                            ?>
                            <div class="scrollable-table container mt-3 ml-0 mr-0 mw-100" id="scrollable-table">
                                <h2 class="mb-4">Lab Tests</h2>

                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Test Date</th>
                                            <th>Test Type</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scrollable-tbody">
                                        <?php while ($row = $results->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['testDate']; ?></td>
                                            <td><?php echo $row['testType']; ?></td>
                                            <td><a href="/HealthCareSystem/uploads/labResultsDocs/<?php echo $row['results']; ?>"
                                                    target="_blank">Download PDF</a></td>                                            
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Imagin Study -->
                            <?php
                            $query = "SELECT ims.* FROM imaging_study as ims
                            LEFT JOIN patient as p on ims.patientId = p.id
                            WHERE p.mailAddress=?";                       
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('s', $userMail);  
                            $stmt->execute();
                            $results = $stmt->get_result();
                            ?>

                            <div class="scrollable-table container mt-3 ml-0 mr-0 mw-100" id="scrollable-table">
                                <h2 class="mb-4">Imaging Studies</h2>

                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Study Date</th>
                                            <th>Study Type</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scrollable-tbody">
                                        <?php while ($row = $results->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['studyDate']; ?></td>
                                            <td><?php echo $row['studyType']; ?></td>
                                            <td><a href="/HealthCareSystem/uploads/imagingStudyDocs/<?php echo $row['result']; ?>"
                                                    target="_blank">Download PDF</a></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>

                   
                    <script>
                    $(document).ready(function() {
                        $('#specializationFilter').on('change', function() {
                            let filterValue = $(this).val();

                            if (filterValue === "all") {
                                $('#medicalHistoryTable tbody tr').show(); 
                            } else {
                                $('#medicalHistoryTable tbody tr').hide();
                                $('#medicalHistoryTable tbody tr[data-specialization="' + filterValue +
                                        '"]')
                                    .show();
                            }
                        });
                    });
                    </script>

                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS and jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>