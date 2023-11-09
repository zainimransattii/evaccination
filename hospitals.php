<?php
include('assets/php/query.php');
include('assets/php/header.php');

$queryHospitals = $pdo->prepare("SELECT h.id, u.name, u.email, h.status, h.number, h.address 
                                FROM hospitals h 
                                INNER JOIN users u ON h.hospital_id = u.id");
$queryHospitals->execute();
$allHospitals = $queryHospitals->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Hospitals</h4>

        <div class="mb-3">
            <button class="btn badge m-1 bg-label-success filter-btn" data-status="approved">Approved Hospitals</button>
            <button class="btn badge m-1 bg-label-primary filter-btn" data-status="pending">Pending Hospitals</button>
            <button class="btn badge m-1 bg-label-danger filter-btn" data-status="reject">Rejected Hospitals</button>
        </div>

        <div class="card">
            <h5 class="card-header">Hospitals</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hospital</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($allHospitals as $hospital): ?>
                            <tr data-status="<?= strtolower($hospital['status']) ?>">
                                <td><?= $hospital['id'] ?></td>
                                <td><?= $hospital['name'] ?></td>
                                <td><?= $hospital['email'] ?></td>
                                <td>+92 3<?= $hospital['number'] ?></td>
                                <td>
                                    <a href="hospitaldetail.php?id=<?= $hospital['id'] ?>" class="badge m-1  <?php
                                    if ($hospital['status'] === "Approved") {
                                        echo 'bg-label-success';
                                    } elseif ($hospital['status'] === "Reject") {
                                        echo 'bg-label-danger';
                                    } else {
                                        echo 'bg-label-primary';
                                    }
                                    ?>">
                                        <?php echo $hospital['status'] ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var status = button.getAttribute('data-status');
            filterHospitals(status);
        });
    });

    function filterHospitals(status) {
        var rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(function (row) {
            var rowStatus = row.getAttribute('data-status');
            if (status === 'all' || status === rowStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
});
</script>

<?php
include('assets/php/footer.php');
?>
