<?php

include('assets/php/query.php');
include('assets/php/header.php');


function getAllVaccines() {
    global $pdo; 
    $stmt = $pdo->prepare("SELECT u.name AS hospital_name, v.id AS vaccine_id, v.name AS vaccine_name, v.availability, v.manufacturer, v.Vaccination_age
    FROM hospitals h
    INNER JOIN users u ON h.hospital_id = u.id
    LEFT JOIN vaccines v ON h.id = v.hospital_id");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$vaccines = getAllVaccines();
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Vaccines</h4>
        <div class="mb-3">
    <button class="btn badge m-1 bg-label-success filter-btn" data-status="available">Available Vaccines</button>
    <button class="btn badge m-1 bg-label-warning filter-btn" data-status="unavailable">Unavailable Vaccines</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var status = button.getAttribute('data-status');
            filterVaccines(status);
        });
    });

    function filterVaccines(status) {
        var rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(function (row) {
            var availabilityCell = row.querySelector('.availability-cell'); 
            if (availabilityCell) {
                var isAvailable = availabilityCell.textContent.trim() > 0;

                if ((status === 'available' && isAvailable) || (status === 'unavailable' && !isAvailable)) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
});
</script>
        <div class="card">
            <h5 class="card-header">Table Basic</h5>
            
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vaccine</th>
                            <th>Hospital Name</th>
                            <th>Manufacturer</th>
                            <th>Availability</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    <?php foreach($vaccines as $vaccine): ?>
        <tr>
            <td><?php echo $vaccine['vaccine_id']; ?></td>
            <td><?php echo $vaccine['vaccine_name']; ?></td>
            <td><?php echo $vaccine['hospital_name']; ?></td>
            <td><?php echo $vaccine['manufacturer']; ?></td>
            <td class="availability-cell"><?php echo $vaccine['availability']; ?></td>
            <td>
                <?php 
                if($vaccine['availability'] <= 0) {
                    echo '<span class="badge bg-label-warning me-1">Unavailable</span>';
                } else {
                    echo '<span class="badge bg-label-success me-1">Available</span>';
                }
                ?>
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
    include('assets/php/footer.php');
?>