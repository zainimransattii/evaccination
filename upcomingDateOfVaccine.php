<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];

    if ($_SESSION['role'] === 'Admin') {
        $queryChildren = $pdo->prepare("SELECT * FROM childs");
        $queryChildren->execute();
        $allChildren = $queryChildren->fetchAll(PDO::FETCH_ASSOC);

        $queryVaccines = $pdo->prepare("SELECT * FROM vaccines WHERE availability > 0");
        $queryVaccines->execute();
        $allVaccines = $queryVaccines->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($_SESSION['role'] === 'Parent') {
        $queryChildren = $pdo->prepare("SELECT * FROM childs WHERE parent_id = ?");
        $queryChildren->execute([$userId]);
        $allChildren = $queryChildren->fetchAll(PDO::FETCH_ASSOC);

        $queryVaccines = $pdo->prepare("SELECT * FROM vaccines WHERE availability > 0");
        $queryVaccines->execute();
        $allVaccines = $queryVaccines->fetchAll(PDO::FETCH_ASSOC);
    }
    $_SESSION['vaccines'] = $allVaccines;


    function getVaccinationDate($childDOB, $vaccineYears, $vaccineMonths)
    {
        $vaccinationDate = new DateTime($childDOB);
        $vaccinationDate->add(new DateInterval("P{$vaccineYears}Y{$vaccineMonths}M"));
        return $vaccinationDate;
    }

    ?>


    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Upcoming Date Of Vaccines Of All Childs</h4>
            <div class="card">
                <h5 class="card-header">Table Basic</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Child Name </th>
                                <th>Child Age </th>
                                <th>Vaccine</th>
                                <th>Vaccination Age</th>
                                <th>Upcoming Vaccination Date</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            <?php
                            foreach ($allChildren as $child) {
                                $childDOB = new DateTime($child['dob']);
                                $currentDate = new DateTime();
                                foreach ($allVaccines as $vaccine) {
                                    preg_match('/(\d+) years, (\d+) months/', $vaccine['Vaccination_age'], $matches);
                                    if (!empty($matches)) {
                                        $vaccineYears = (int)$matches[1];
                                        $vaccineMonths = (int)$matches[2];
                                        $vaccinationDate = getVaccinationDate($child['dob'], $vaccineYears, $vaccineMonths);

                                        $existingVaccinationQuery = $pdo->prepare("SELECT * FROM booking_requests WHERE child_id = ? AND vaccine_id = ? AND status != 'Vaccinated'");
                                        $existingVaccinationQuery->execute([$child['id'], $vaccine['id']]);

                                        if ($vaccinationDate > $currentDate && $existingVaccinationQuery->rowCount() == 0) {
                                            echo "<tr>";
                                            echo "<td>" . $child['id'] . "</td>";
                                            echo "<td>" . $child['name'] . "</td>";
                                            echo "<td>" . $child['dob'] . "</td>";
                                            echo "<td>" . $vaccine['name'] . "</td>";
                                            echo "<td>" . $vaccine['Vaccination_age'] . "</td>";
                                            echo "<td><span class='badge bg-label-warning me-1'>" . $vaccinationDate->format('Y-m-d') . "</span></td>";
                                            ?>
                                            <?php if ($_SESSION['role'] === 'Parent') {
                                                ?>
                                                <td>
                                                    <form method="POST" action="">
                                                        <!-- required data -->
                                                        <input type="hidden" name="parentId" value="<?php echo $child['parent_id']; ?>">
                                                        <input type="hidden" name="childId" value="<?php echo $child['id']; ?>">
                                                        <input type="hidden" name="hospitalId" value="<?php echo $vaccine['hospital_id']; ?>">
                                                        <input type="hidden" name="vaccineId" value="<?php echo $vaccine['id']; ?>">
                                                        <input type="hidden" name="appointmentDate" value="<?php echo $vaccinationDate->format('Y-m-d'); ?>">
                                                        <button type="submit" name="submitAppointment" class="badge btn bg-label-primary me-1">Appointment</button>
                                                    </form>
                                                </td>
                                            <?php
                                            }
                                            echo "</tr>";
                                            $_SESSION['upcomingVaccinationDate'] = $vaccinationDate->format('Y-m-d');
                                            $_SESSION['vaccine'] = $vaccine['name'];
                                            $_SESSION['vaccination_age'] = $vaccine['Vaccination_age'];
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php

    include('assets/php/footer.php');

    if (isset($_POST['submitAppointment'])) {
        $parentId = $_POST['parentId'];
        $childId = $_POST['childId'];
        $hospitalId = $_POST['hospitalId'];
        $vaccineId = $_POST['vaccineId'];
        $appointmentDate = $_POST['appointmentDate'];
        $status = 'Pending';

        $existingAppointmentQuery = $pdo->prepare("SELECT * FROM booking_requests WHERE parent_id = ? AND child_id = ? AND vaccine_id = ? AND vaccination_date = ?");
        if ($existingAppointmentQuery->execute([$parentId, $childId, $vaccineId, $appointmentDate]) && $existingAppointmentQuery->rowCount() > 0) {
            echo "<script>
        alert('You have already made an appointment for this child and vaccine on the selected date.');
    </script>";
        } else {
            $query = $pdo->prepare("INSERT INTO booking_requests (parent_id, child_id, hospital_id, vaccine_id, vaccination_date, status) VALUES (?, ?, ?, ?, ?, ?)");
            if ($query->execute([$parentId, $childId, $hospitalId, $vaccineId, $appointmentDate, $status])) {
                echo "<script>
        alert('Appointment request inserted successfully.');
        </script>";
            } else {
                echo "<script>
        alert('Error inserting appointment request.');
        </script>";
            }
        }
    }
}
?>
