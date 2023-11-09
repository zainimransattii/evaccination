<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    // for hospitals
    if ($_SESSION['role'] === 'Hospital') {
        $userId = $_SESSION['userID'];

        $hospitalNameQuery = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $hospitalNameQuery->execute([$userId]);
        $hospitalNam = $hospitalNameQuery->fetch(PDO::FETCH_ASSOC);
        $hospitalName = $hospitalNam['name'];

        $hospitalQuery = $pdo->prepare("SELECT id FROM hospitals WHERE hospital_id = ?");
        $hospitalQuery->execute([$userId]);
        $hospital = $hospitalQuery->fetch(PDO::FETCH_ASSOC);

        $hospitalId = $hospital['id'];

        $reportsQuery = $pdo->prepare("SELECT 
            r.report_id,
            c.name AS child_name,
            v.name AS vaccine_name,
            r.vaccinated_date,
            r.status
        FROM vaccination_reports r
        INNER JOIN vaccines v ON r.vaccine_id = v.id
        INNER JOIN childs c ON r.child_id = c.id
        WHERE r.hospital_id = ?");
        
        $reportsQuery->execute([$hospitalId]);
        $hospitalReports = $reportsQuery->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Vaccination Reports for <?= $hospitalName ?></h4>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Child Name</th>
                            <th>Vaccine</th>
                            <th>Vaccinated Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($hospitalReports as $report): ?>
                            <tr>
                                <td><?= $report['report_id'] ?></td>
                                <td><?= $report['child_name'] ?></td>
                                <td><?= $report['vaccine_name'] ?></td>
                                <td><?= $report['vaccinated_date'] ?></td>
                                <td><?= $hospitalName ?></td>
                                <td><?= $report['status'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    // for parents
    elseif ($_SESSION['role'] === 'Parent') {
        $parentUserId = $_SESSION['userID'];
    
        $parentReportsQuery = $pdo->prepare("SELECT 
            r.report_id,
            c.name AS child_name,
            v.name AS vaccine_name,
            r.vaccinated_date,
            r.status
        FROM vaccination_reports r
        INNER JOIN vaccines v ON r.vaccine_id = v.id
        INNER JOIN childs c ON r.child_id = c.id
        WHERE r.parent_id = ?");
        
        $parentReportsQuery->execute([$parentUserId]);
        $parentReports = $parentReportsQuery->fetchAll(PDO::FETCH_ASSOC);
    
        ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">Your Children's Vaccination Reports</h4>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Child Name</th>
                            <th>Vaccine</th>
                            <th>Vaccinated Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($parentReports as $report): ?>
                            <tr>
                                <td><?= $report['report_id'] ?></td>
                                <td><?= $report['child_name'] ?></td>
                                <td><?= $report['vaccine_name'] ?></td>
                                <td><?= $report['vaccinated_date'] ?></td>
                                <td><?= $report['status'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    
    // for admin
    elseif ($_SESSION['role'] === 'Admin') {
        $reportsQuery = $pdo->prepare("SELECT 
            r.report_id,
            c.name AS child_name,
            v.name AS vaccine_name,
            r.vaccinated_date,
            r.status,
            h.hospital_id AS hospital_id
        FROM vaccination_reports r
        INNER JOIN vaccines v ON r.vaccine_id = v.id
        INNER JOIN childs c ON r.child_id = c.id
        INNER JOIN hospitals h ON r.hospital_id = h.id");
        
        $reportsQuery->execute();
        $adminReports = $reportsQuery->fetchAll(PDO::FETCH_ASSOC);
    
        ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">All Vaccination Reports</h4>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Child Name</th>
                            <th>Hospital Name</th>
                            <th>Vaccine</th>
                            <th>Vaccinated Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach ($adminReports as $report): ?>
                            <tr>
                                <td><?= $report['report_id'] ?></td>
                                <td><?= $report['child_name'] ?></td>
                                <td>
                                    <?php
                                    $hospitalId = $report['hospital_id'];
                                    $hospitalNameQuery = $pdo->prepare("SELECT name FROM users WHERE id = ?");
                                    $hospitalNameQuery->execute([$hospitalId]);
                                    $hospitalName = $hospitalNameQuery->fetch(PDO::FETCH_ASSOC);
                                    echo $hospitalName['name'];
                                    ?>
                                </td>
                                <td><?= $report['vaccine_name'] ?></td>
                                <td><?= $report['vaccinated_date'] ?></td>
                                <td><?= $report['status'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    } else {
        echo "404 ERROR";
    }
}

include('assets/php/footer.php');
?>
