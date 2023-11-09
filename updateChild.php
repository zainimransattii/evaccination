<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    if (isset($_GET['id'])) {
        $childId = $_GET['id'];

        $childQuery = $pdo->prepare("SELECT * FROM childs WHERE id = ?");
        $childQuery->execute([$childId]);
        $childData = $childQuery->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $childName = $_POST['childName'];
            $childPhone = $_POST['number'];
            $childDOB = $_POST['dob'];
            $childAddress = $_POST['address'];

            $updateChildQuery = $pdo->prepare("UPDATE childs SET name = ?, phone = ?, dob = ?, address = ? WHERE id = ?");
            $updateChildQuery->execute([$childName, $childPhone, $childDOB, $childAddress, $childId]);

            echo '<script>alert("Child details updated successfully."); location.assign("viewchild.php?id=' . $childId . '");</script>';
        }
    }

?>


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Child Details</h4>
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
    <label class="col-sm-2 col-form-label" for="basic-default-name">Child Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="childName" value="<?= $childData['name'] ?>" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-phone">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="number" value="<?= $childData['phone'] ?>" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-phone">Date Of Birth</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="dob" value="<?= $childData['dob'] ?>" />
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="basic-default-phone">Address</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="address" value="<?= $childData['address'] ?>" />
    </div>
</div>


                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" name="update">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
include('assets/php/footer.php');
?>
