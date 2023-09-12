function showPatientInfo(patientId) {
    // You would make an AJAX call to a PHP script that retrieves patient information based on the ID
    // and returns it as JSON data
    // Example:
    // $.ajax({
    //     url: "get_patient_info.php",
    //     data: { patientId: patientId },
    //     success: function(data) {
    //         // Populate patientInfo and medicalHistory divs with the received data
    //     }
    // });
    
    // For demonstration purposes, let's assume we have a sample patientInfo object
    const samplePatientInfo = {
        name: "Sample Patient",
        gender: "Male",
        dateOfBirth: "1990-01-01",
        phoneNumber: "123-456-7890",
        address: "123 Main St",
        mailAddress: "sample@example.com"
    };

    const patientInfoElement = document.getElementById("patientInfo");
    const medicalHistoryElement = document.getElementById("medicalHistory");

    // Populate patient's information
    patientInfoElement.innerHTML = `
        <h3>${samplePatientInfo.name}</h3>
        <p>Gender: ${samplePatientInfo.gender}</p>
        <p>Date of Birth: ${samplePatientInfo.dateOfBirth}</p>
        <p>Phone: ${samplePatientInfo.phoneNumber}</p>
        <p>Address: ${samplePatientInfo.address}</p>
        <p>Email: ${samplePatientInfo.mailAddress}</p>
    `;

    // Populate medical history
    medicalHistoryElement.innerHTML = `
        <h3>Medical History</h3>
        <!-- Loop through medical history data and populate here -->
    `;
}
