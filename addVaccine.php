<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    echo $userID;

    $queryHospitalID = $pdo->prepare("SELECT id FROM users WHERE id = :userID");
    $queryHospitalID->bindParam(":userID", $userID);
    $queryHospitalID->execute();
    $hospitalID = $queryHospitalID->fetchColumn();

    echo $hospitalID;
    $queryHospitalTableID = $pdo->prepare("SELECT id FROM hospitals WHERE hospital_id = :userID");
    $queryHospitalTableID->bindParam(":userID", $hospitalID);
    $queryHospitalTableID->execute();
    $hospitalTabelID = $queryHospitalTableID->fetchColumn();
    echo $hospitalTabelID;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addVaccine'])) {
        $vaccineName = $_POST['vaccine_name'];
        $vaccineManufacturer = $_POST['vaccine_manufacturer'];
        $vaccineAge = $_POST['vaccine_age'];
        $vaccineAvailability = $_POST['vaccine_availability'];

        // insert query
        $insertQuery = $pdo->prepare("INSERT INTO vaccines (hospital_id, name, availability) VALUES (:hospitalID, :vaccineName, :vaccineAvailability)");
        $insertQuery->bindParam(":hospitalID", $hospitalTabelID);
        $insertQuery->bindParam(":vaccineName", $vaccineName);
        $insertQuery->bindParam(":vaccineManufacturer", $vaccineManufacturer);
        $insertQuery->bindParam(":vaccineAge", $vaccineAge);
        $insertQuery->bindParam(":vaccineAvailability", $vaccineAvailability);
        $insertQuery->execute();

        echo '<script>alert("Vaccine added successfully!");</script>';
    }
    ?>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Add Vaccine</h4>
            <div class="card">
                <h5 class="card-header">Add New Vaccine</h5>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="vaccine_name" class="form-label">Vaccine Name</label>
                            <input type="text" class="form-control" name="vaccine_name" id="vaccine_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="vaccine_manufacturer" class="form-label">Manufacturer</label>
                            <input type="text" class="form-control" name="vaccine_manufacturer" id="vaccine_manufacturer" required>
                        </div>
                        <div class="mb-3">
                            <label for="vaccine_age" class="form-label">Vaccination Age</label>
                            <input type="text" class="form-control" name="vaccine_age" id="vaccine_age" placeholder="type Like a (1 years, 5 months,)" required>
                        </div>
                        <div class="mb-3">
                            <label for="vaccine_availability" class="form-label">Availability</label>
                            <input type="number" class="form-control" name="vaccine_availability" id="vaccine_availability" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addVaccine">Add Vaccine</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('assets/php/footer.php');
?>
