<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID']) && $_SESSION['role'] === 'Hospital') {
    $userId = $_SESSION['userID'];

    // Retrieve the hospital_id corresponding to the user's userID
    $hospitalQuery = $pdo->prepare("SELECT id FROM hospitals WHERE hospital_id = ?");
    $hospitalQuery->execute([$userId]);
    $hospital = $hospitalQuery->fetch(PDO::FETCH_ASSOC);

    $hospitalId = $hospital['id'];

    $appointmentQuery = $pdo->prepare("SELECT 
        b.id, 
        c.name AS child_name, 
        v.name AS vaccine_name, 
        b.vaccination_date, 
        b.status 
    FROM booking_requests b 
    INNER JOIN vaccines v ON b.vaccine_id = v.id 
    INNER JOIN childs c ON b.child_id = c.id 
    WHERE v.hospital_id = ? AND b.status = 'Appointment Done'");

    $appointmentQuery->execute([$hospitalId]);
    $hospitalAppointments = $appointmentQuery->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SESSION['role'] === 'Hospital'): ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Appointments for Your Hospital</h4>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child Name</th>
                        <th>Vaccine</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($hospitalAppointments as $appointment): ?>
                        <tr>
                            <td><?= $appointment['id'] ?></td>
                            <td><?= $appointment['child_name'] ?></td>
                            <td><?= $appointment['vaccine_name'] ?></td>
                            <td><?= $appointment['vaccination_date'] ?></td>
                            <td><?= $appointment['status'] ?></td>
                            <td>
                                <form method="POST" action=""> <!-- Specify action attribute here -->
                                    <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                    <button type="submit" name="submitVaccinated" class="btn btn-success m-1">Vaccinated</button>
                                    <button type="submit" name="submitNotVaccinated" class="btn btn-danger m-1">Not Vaccinated</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php
if ($_SESSION['role'] === 'Hospital' && isset($_POST['submitVaccinated'])) {
    $appointmentId = $_POST['appointment_id'];
    $status = 'Vaccinated';

    $updateQuery = $pdo->prepare("UPDATE booking_requests SET status = ? WHERE id = ? AND vaccine_id IN (SELECT id FROM vaccines WHERE hospital_id = ?)");
    if ($updateQuery->execute([$status, $appointmentId, $hospitalId])) {
        // Fetch appointment details
        $appointmentQuery = $pdo->prepare("SELECT * FROM booking_requests WHERE id = ?");
        $appointmentQuery->execute([$appointmentId]);
        $appointmentDetails = $appointmentQuery->fetch(PDO::FETCH_ASSOC);

        // Insert a record into the vaccination_reports table
        $insertReportQuery = $pdo->prepare("INSERT INTO vaccination_reports (vaccine_id, child_id, parent_id, vaccinated_date, hospital_id, status) VALUES (?, ?, ?, NOW(), ?, 'Vaccinated')");
        $insertReportQuery->execute([$appointmentDetails['vaccine_id'], $appointmentDetails['child_id'], $appointmentDetails['parent_id'], $hospitalId]);

        // Decrement vaccine availability
        $decrementAvailabilityQuery = $pdo->prepare("UPDATE vaccines SET availability = availability - 1 WHERE id = ?");
        $decrementAvailabilityQuery->execute([$appointmentDetails['vaccine_id']]);

        echo "<script>alert('Appointment status updated to Vaccinated.')</script>";
    } else {
        echo "<script>alert('Error updating appointment status.')</script>";
    }
}

if ($_SESSION['role'] === 'Hospital' && isset($_POST['submitNotVaccinated'])) {
    $appointmentId = $_POST['appointment_id'];
    $status = 'Not Vaccinated';

    $updateQuery = $pdo->prepare("UPDATE booking_requests SET status = ? WHERE id = ? AND vaccine_id IN (SELECT id FROM vaccines WHERE hospital_id = ?)");
    if ($updateQuery->execute([$status, $appointmentId, $hospitalId])) {
        // Fetch appointment details
        $appointmentQuery = $pdo->prepare("SELECT * FROM booking_requests WHERE id = ?");
        $appointmentQuery->execute([$appointmentId]);
        $appointmentDetails = $appointmentQuery->fetch(PDO::FETCH_ASSOC);

        // Insert a record into the vaccination_reports table
        $insertReportQuery = $pdo->prepare("INSERT INTO vaccination_reports (vaccine_id, child_id, parent_id, vaccinated_date, hospital_id, status) VALUES (?, ?, ?, NOW(), ?, 'Not Vaccinated')");
        $insertReportQuery->execute([$appointmentDetails['vaccine_id'], $appointmentDetails['child_id'], $appointmentDetails['parent_id'], $hospitalId]);

        echo "<script>alert('Appointment status updated to Not Vaccinated.')</script>";
    } else {
        echo "<script>alert('Error updating appointment status.')</script>";
    }
}
?>
<?php include('assets/php/footer.php'); ?>
