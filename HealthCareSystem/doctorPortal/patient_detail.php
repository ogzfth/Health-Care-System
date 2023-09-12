<?php
require 'D:\Xampp\htdocs\HealthCareSystem\config\db.php';

if (isset($_SESSION['doctorId']) && isset($_SESSION['patientId'])) {
    $patientId = $_SESSION['patientId'];
    $doctorId = $_SESSION['doctorId'];    
    $patientName = $_SESSION['patientName'];  

    // get selected patient
    $stmt = $conn->prepare("SELECT * FROM patient WHERE id = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $stmt->close();

    // get medical history of selected patient 
    $stmt = $conn->prepare("SELECT mr.id as 'recordId', 
    p.name as 'patientName',  mr.recordDate, mr.diagnosis, 
    mr.treatment, d.name as 'doctorName', d.specilization 
    FROM medical_record as mr
    LEFT JOIN patient as p ON mr.patientId = p.id
    LEFT JOIN doctor as d ON mr.doctorId = d.id
    where p.id=?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($recordId, $patientName,  $recordDate, $diagnosis, $treatment, $doctorName, $specilization);

    while ($stmt->fetch()) {
        $medicalRecords[] = [
            'recordId' => $recordId,
            'recordDate' => $recordDate,
            'diagnosis' => $diagnosis,
            'treatment' => $treatment,
            'specilization' => $specilization,
            'doctorName' => $doctorName,
            'patientName' => $patientName
        ];
    }
    $stmt->close();
} else {
    header('Location: doctor_portal.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Doctor Portal</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/doctor_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </link>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body>
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
            <ul class="navbar-nav ml-5 mr-5 mb-2 mt-3">
                <?php               
                        if(isset($_SESSION['doctorId'])) {  
                            echo '<form action="doctor_profile.php" method="get">                        
                            <div style="margin-right: 25px;" class="text-center"><button class="btn btn-light ml-3" id="btn-profile-logout" type="submit" name="profile-submit">
                            Profile
                            </button></div>                     
                            </form>';
                            echo '<form action="doctorConfig/doctor_logout.php" method="get">                        
                                    <div class="text-center"><button type="submit" name="logout-submit" class="btn btn-dark" id="btn-profile-logout">Logout</button></div>                     
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
                    <a href="doctor_index.php"
                        class="list-group-item list-group-item-action active custom-list-group-item"
                        id="active-panel-selection"><i class="fas fa-user-injured ml-4"></i>Patients</a>
                    <a href="doctor_appointments.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-calendar-check ml-4"></i>Your Appointments</a>
                    <a href="doctor_profile.php"
                        class="list-group-item list-group-item-action custom-list-group-item"><i
                            class="fas fa-user-circle ml-4"></i>Profile</a>
                </div>
            </div>
            <div class="col-lg-9 pl-0">
                <div class="container-fluid">
                    <div class="container mt-3 ml-3 mw-100 w-100">
                        <h2 class="mb-4">Medical History of <a
                                href='mailto:<?php echo $patient['mailAddress']; ?>'><?= $_SESSION['patientName'] ?></a>
                        </h2>
                        
                        <button style="margin-bottom: 10px;" class="btn btn-warning" onclick="openAddModal();">Add New
                            Record</button>
                        <button style="margin-bottom: 10px;" type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#labResultModal">Upload Lab Result</button>
                        <button style="margin-bottom: 10px;" type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#imagingStudyModal">Upload Imaging Study</button>

                        <div class="row">
                            <div class="scrollable-table col-12" id="scrollable-table">
                                <table class="table table-bordered table-hover" id="scrollable-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="col-patient">Patient</th>
                                            <th class="col-date">Date</th>
                                            <th class="col-specialization">Specialization</th>
                                            <th class="col-doctor">Doctor</th>
                                            <th class="col-diagnosis">Diagnosis</th>
                                            <th class="col-treatment">Treatment</th>
                                            <th class="col-edit">Edit</th>
                                        </tr>
                                    </thead>

                                    <tbody class="scrollable-tbody">
                                        <?php foreach ($medicalRecords as $entry): ?>
                                        <tr data-specialization="<?php echo $entry['specilization']; ?>">
                                            <td class="col-patient"><?php echo $entry['patientName']; ?></td>
                                            <td class="col-date"><?php echo $entry['recordDate']; ?></td>
                                            <td class="col-specialization"><?php echo $entry['specilization']; ?></td>
                                            <td class="col-doctor"><?php echo $entry['doctorName']; ?></td>
                                            <td class="col-diagnosis"><?php echo $entry['diagnosis']; ?></td>
                                            <td class="col-treatment"><?php echo $entry['treatment']; ?></td>
                                            <td class="col-edit">
                                                <?php if ($entry['doctorName'] == $doctorName): ?>
                                                <button class="btn btn-primary" onclick="openEditModal(<?= $entry['recordId'] ?>, 
                                    '<?= $entry['diagnosis'] ?>', '<?= $entry['treatment'] ?>', '<?= $entry['patientName'] ?>', 
                                    '<?= $entry['doctorName'] ?>', '<?= $entry['recordDate'] ?>');">Edit</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- Lab Test -->
                    <?php
                    $query = "SELECT * FROM lab_test WHERE patientId = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $patientId);  
                    $stmt->execute();
                    $results = $stmt->get_result();
                    ?>
                    <div class="scrollable-table container mt-3 ml-3 mw-100 w-100">
                        <h2 class="mb-3">Lab Tests</h2>

                        <table class="table table-bordered table-hover" id="scrollable-table">
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
                    $query = "SELECT * FROM imaging_study WHERE patientId = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $patientId);  
                    $stmt->execute();
                    $results = $stmt->get_result();
                    ?>

                    <div class="scrollable-table container mt-3 mb-5 ml-3 mw-100 w-100">
                        <h2 class="mb-3">Imaging Studies</h2>

                        <table class="table table-bordered table-hover" id="scrollable-table">
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
            </div>
        </div>
    </div>


    <!-- Link to Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <!-- edit popup -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="doctorConfig/edit_medical_record.php" method="post">
                        <input type="hidden" id="recordId" name="recordId" value="">

                        <div class="form-group">
                            <label for="patientName">Patient:</label>
                            <input type="text" class="form-control" id="patientName" name="patientName" readonly>
                        </div>

                        <div class="form-group">
                            <label for="doctorName">Doctor:</label>
                            <input type="text" class="form-control" id="doctorName" name="doctorName" readonly>
                        </div>

                        <div class="form-group">
                            <label for="recordDate">Record Date:</label>
                            <input type="date" class="form-control" id="recordDate" name="recordDate" readonly>
                        </div>

                        <div class="form-group">
                            <label for="diagnosis">Diagnosis:</label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3"
                                maxlength="255"></textarea>
                            <small class="form-text text-muted">Max 255 characters.</small>
                        </div>

                        <div class="form-group">
                            <label for="treatment">Treatment:</label>
                            <textarea class="form-control" id="treatment" name="treatment" rows="3"
                                maxlength="255"></textarea>
                            <small class="form-text text-muted">Max 255 characters.</small>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" value="Update" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- add popup  -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="doctorConfig/add_medical_record.php" method="post">

                        <input type="hidden" id="addDoctorId" name="doctorId" value="<?= $doctorId ?>">
                        <input type="hidden" id="addPatientId" name="patientId" value="<?= $patientId ?>">

                        <div class="form-group">
                            <label for="addPatientName">Patient:</label>
                            <input type="text" class="form-control" id="addPatientName" name="patientName" readonly
                                value="<?= $patientName ?>">
                        </div>

                        <div class="form-group">
                            <label for="addDoctorName">Doctor:</label>
                            <input type="text" class="form-control" id="addDoctorName" name="doctorName" readonly
                                value="<?= $doctorName ?>">
                        </div>

                        <div class="form-group">
                            <label for="addRecordDate">Record Date:</label>
                            <input type="date" class="form-control" id="addRecordDate" name="recordDate">
                        </div>

                        <div class="form-group">
                            <label for="addDiagnosis">Diagnosis:</label>
                            <textarea class="form-control" id="addDiagnosis" name="diagnosis" rows="3"
                                maxlength="255"></textarea>
                            <small class="form-text text-muted">Max 255 characters.</small>
                        </div>

                        <div class="form-group">
                            <label for="addTreatment">Treatment:</label>
                            <textarea class="form-control" id="addTreatment" name="treatment" rows="3"
                                maxlength="255"></textarea>
                            <small class="form-text text-muted">Max 255 characters.</small>
                        </div>                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" value="Add" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lab result popup -->
    <div id="labResultModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Lab Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="doctorConfig/upload_lab_result.php" method="post" enctype="multipart/form-data">

                        <input type="hidden" id="labDoctorId" name="doctorId" value="<?= $doctorId ?>">
                        <input type="hidden" id="labPatientId" name="patientId" value="<?= $patientId ?>">

                        <div class="form-group">
                            <label>Doctor:</label>
                            <input type="text" class="form-control" value="<?= $doctorName ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Patient:</label>
                            <input type="text" class="form-control" value="<?= $patientName ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="testDate">Test Date:</label>
                            <input type="date" class="form-control" id="testDate" name="testDate" required>
                        </div>

                        <div class="form-group">
                            <label for="testType">Test Type:</label>
                            <input type="text" class="form-control" id="testType" name="testType" required>
                        </div>

                        <div class="form-group">
                            <label for="labResultPdf">Results (PDF):</label>
                            <input type="file" class="form-control" id="labResultPdf" name="labResultPdf" accept=".pdf"
                                required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" value="Upload Lab Result" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Imagin study popup -->
    <div id="imagingStudyModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Imaging Study</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="doctorConfig/upload_imaging_study.php" method="post" enctype="multipart/form-data">

                        <input type="hidden" id="imagingDoctorId" name="doctorId" value="<?= $doctorId ?>">
                        <input type="hidden" id="imagingPatientId" name="patientId" value="<?= $patientId ?>">

                        <div class="form-group">
                            <label>Doctor:</label>
                            <input type="text" class="form-control" value="<?= $doctorName ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Patient:</label>
                            <input type="text" class="form-control" value="<?= $patientName ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="studyDate">Study Date:</label>
                            <input type="date" class="form-control" id="studyDate" name="studyDate" required>
                        </div>

                        <div class="form-group">
                            <label for="studyType">Study Type:</label>
                            <input type="text" class="form-control" id="studyType" name="studyType" required>
                        </div>

                        <div class="form-group">
                            <label for="imagingStudyPdf">Result (PDF):</label>
                            <input type="file" class="form-control" id="imagingStudyPdf" name="imagingStudyPdf"
                                accept=".pdf" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" value="Upload Imaging Study" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
    var modal = document.getElementById('editModal');

    function openEditModal(recordId, diagnosis, treatment, patientName, doctorName, recordDate) {
        document.getElementById('recordId').value = recordId;
        document.getElementById('diagnosis').value = diagnosis;
        document.getElementById('treatment').value = treatment;
        document.getElementById('patientName').value = patientName;
        document.getElementById('doctorName').value = doctorName;
        document.getElementById('recordDate').value = recordDate;
        $('#editModal').modal('show');
    }

    function openAddModal() {
        document.getElementById('addRecordDate').value = '';
        document.getElementById('addDiagnosis').value = '';
        document.getElementById('addTreatment').value = '';
        $('#addModal').modal('show');
    }
    </script>
</body>

</html>

<?php
require_once '../footer.php'

?>