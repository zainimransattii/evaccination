<?php
include('assets/php/query.php');
include('assets/php/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitBookingRequest'])) {
    $vaccineName = $_POST['vaccineName'];
    $vaccinationDate = $_POST['vaccinationDate'];
    $hospitalID = $_POST['hospitalID'];
    $childID = $_SESSION['childID']; 

    $insertQuery = $pdo->prepare("INSERT INTO booking_request (vaccine_name, vaccination_date, hospital_id, child_id) VALUES (?, ?, ?, ?)");
    $insertQuery->execute([$vaccineName, $vaccinationDate, $hospitalID, $childID]);

    echo '<script>alert("Booking request submitted successfully!");</script>';
}

$childID = $_SESSION['childID'];
$queryChild = $pdo->prepare("SELECT name FROM childs WHERE id = ?");
$queryChild->execute([$childID]);
$child = $queryChild->fetch(PDO::FETCH_ASSOC);

$queryUpcomingVaccines = $pdo->prepare("SELECT v.name AS vaccineName, vaccination_age AS vaccinationDate
                                        FROM vaccines v
                                        WHERE v.availability > 0
                                        ");
$queryUpcomingVaccines->execute();
$upcomingVaccines = $queryUpcomingVaccines->fetchAll(PDO::FETCH_ASSOC);

$queryHospitals = $pdo->prepare("SELECT id, name FROM hospitals");
$queryHospitals->execute();
$hospitals = $queryHospitals->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Hospital Booking</span></h4>
        <div class="card">
            <h5 class="card-header">Upcoming Vaccines for <?= $child['name'] ?></h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Child Name</th>
                            <th>Vaccine Name</th>
                            <th>Vaccination Date</th>
                            <th>Select Hospital</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <form method="post">
                            <?php foreach ($upcomingVaccines as $vaccine): ?>
                                <tr>
                                    <td><?= $child['name'] ?></td>
                                    <td><?= $vaccine['vaccineName'] ?></td>
                                    <td><?= $vaccine['vaccinationDate'] ?></td>
                                    <td>
                                        <select name="hospitalID" class="form-select">
                                            <option value="" disabled selected>Select Hospital</option>
                                            <?php foreach ($hospitals as $hospital): ?>
                                                <option value="<?= $hospital['id'] ?>"><?= $hospital['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="vaccineName" value="<?= $vaccine['vaccineName'] ?>">
                                        <input type="hidden" name="vaccinationDate" value="<?= $vaccine['vaccinationDate'] ?>">
                                        <button type="submit" name="submitBookingRequest" class="btn btn-primary">Book</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include('assets/php/footer.php');
?>
