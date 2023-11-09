<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];

    if ($_SESSION['role'] === 'Admin') {
        $appointmentQuery = $pdo->prepare("SELECT 
            b.id, 
            b.parent_id, 
            b.child_id, 
            u.name AS hospital_name, 
            v.name AS vaccine_name, 
            c.name AS child_name, 
            b.vaccination_date, 
            b.status 
        FROM booking_requests b 
        INNER JOIN vaccines v ON b.vaccine_id = v.id 
        INNER JOIN users u ON v.hospital_id = u.id 
        INNER JOIN childs c ON b.child_id = c.id");

        $appointmentQuery->execute();
        $userAppointments = $appointmentQuery->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($_SESSION['role'] === 'Parent') {
        $appointmentQuery = $pdo->prepare("SELECT 
            b.id, 
            b.parent_id, 
            b.child_id, 
            u.name AS hospital_name, 
            v.name AS vaccine_name, 
            c.name AS child_name, 
            b.vaccination_date, 
            b.status 
        FROM booking_requests b 
        INNER JOIN vaccines v ON b.vaccine_id = v.id 
        INNER JOIN users u ON v.hospital_id = u.id 
        INNER JOIN childs c ON b.child_id = c.id
        WHERE b.parent_id = ?");

        $appointmentQuery->execute([$userId]);
        $userAppointments = $appointmentQuery->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<?php if ($_SESSION['role'] === 'Parent' || $_SESSION['role'] === 'Admin'): ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Appointments</h4>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child Name</th>
                        <th>Vaccine</th>
                        <th>Hospital</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <?php if ($_SESSION['role'] === 'Admin') { ?>
                            <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($userAppointments as $appointment): ?>
                        <tr>
                            <td><?= $appointment['id'] ?></td>
                            <td><?= $appointment['child_name'] ?></td>
                            <td><?= $appointment['vaccine_name'] ?></td>
                            <td><?= $appointment['hospital_name'] ?></td>
                            <td><?= $appointment['vaccination_date'] ?></td>
                            <td><?= $appointment['status'] ?></td>
                            <?php if ($_SESSION['role'] === 'Admin' && $appointment['status'] === 'Pending') { ?>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                        <button type="submit" name="submitDone" class="btn badge m-1 bg-label-primary m-1">Appointment Done</button>
                                    </form>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php include('assets/php/footer.php'); ?>

<?php
if (isset($_POST['submitDone'])) {
    $appointmentId = $_POST['appointment_id'];
    $status = 'Appointment Done';

    $updateQuery = $pdo->prepare("UPDATE booking_requests SET status = ? WHERE id = ?");
    if ($updateQuery->execute([$status, $appointmentId])) {
        echo "<script>alert('Appointment status updated successfully.')</script>";
    } else {
        echo "<script>alert('Error updating appointment status.')</script>";
    }
}
?>
