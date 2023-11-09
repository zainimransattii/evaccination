<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_GET['id'])) {
    $hospitalId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $hospitalName = $_POST['hospitalName'];
        
        
        $hospitalAddress = $_POST['hospitalAddress'];
        $hospitalDescription = $_POST['hospitalDescription'];

        $hospitalsUpdateQuery = $pdo->prepare("UPDATE hospitals SET address = ?,  description = ?, status = 'Approved' WHERE id = ?");
        $hospitalsUpdateQuery->execute([$hospitalAddress, $hospitalDescription, $hospitalId]);

        $userQuery = $pdo->prepare("SELECT id FROM users WHERE id = (SELECT hospital_id FROM hospitals WHERE id = ?)");
        $userQuery->execute([$hospitalId]);
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);
        $userId = $user['id'];

        $usersUpdateQuery = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
        $usersUpdateQuery->execute([$hospitalName, $userId]);

        echo '<script>alert("Details updated and approved successfully."); location.assign("hospitals.php");</script>';
    }

    $query = $pdo->prepare("SELECT hospitals.*, users.name AS hospital_name, users.email AS hospital_email FROM hospitals JOIN users ON hospitals.hospital_id = users.id WHERE hospitals.id = ?");
    $query->execute([$hospitalId]);

    $hospitalData = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Hospital Details</h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Basic Layout</h5>
                    <small class="text-muted float-end">Default label</small>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Hospital Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="hospitalName" value="<?= $hospitalData['hospital_name'] ?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="hospitalAddress" value="<?= $hospitalData['address'] ?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-message">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="hospitalDescription"><?= $hospitalData['description'] ?></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" name="updateHospital">Update & Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('assets/php/footer.php');
?>
