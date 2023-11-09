<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    $queryHospital = $pdo->prepare("SELECT u.name AS hospital_name, v.id AS vaccine_id, v.name AS vaccine_name, v.availability
                                    FROM hospitals h
                                    INNER JOIN users u ON h.hospital_id = u.id
                                    LEFT JOIN vaccines v ON h.id = v.hospital_id
                                    WHERE u.id = :ud");
    $queryHospital->bindParam(":ud", $userID);
    $queryHospital->execute();
    $hospitalData = $queryHospital->fetchAll(PDO::FETCH_ASSOC);

    if (empty($hospitalData)) {
        echo '<script>alert("No data found for the logged-in hospital. Redirecting to add vaccines page...");';
        echo 'window.location.href = "addVaccine.php";</script>';
        exit; // Stop further execution
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateAvailability'])) {
        $vaccineID = $_POST['vaccine_id'];
        $newAvailability = $_POST['new_availability'];

        $updateQuery = $pdo->prepare("UPDATE vaccines SET availability = :availability WHERE id = :vaccine_id");
        $updateQuery->bindParam(":availability", $newAvailability);
        $updateQuery->bindParam(":vaccine_id", $vaccineID);
        $updateQuery->execute();

        echo '<script>alert("Availability updated successfully!");</script>';
    }
    ?>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Hospital Vaccines</h4>
            <div class="card">
                <h5 class="card-header">Vaccine Availability for <?= $hospitalData[0]['hospital_name'] ?></h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vaccine Name</th>
                                <th>Availability</th>
                                <th>Add Availability</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($hospitalData as $vaccine): ?>
                                <tr>
                                    <td><?= $vaccine['vaccine_name'] ?></td>
                                    <td><?= $vaccine['availability'] ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="vaccine_id" value="<?= $vaccine['vaccine_id'] ?>">
                                            <input type="number" class="form-control" name="new_availability" min="0" value="<?= $vaccine['availability'] ?>">
                                            <button type="submit" class="btn btn-outline-primary" name="updateAvailability">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
}
include('assets/php/footer.php');
?>
