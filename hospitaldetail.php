<?php
include('assets/php/query.php');
include('assets/php/header.php');

    if (isset($_GET['id'])) {
        $hospitalId = $_GET['id'];

        if (isset($_POST['approveHospital'])) {
            $updateQuery = $pdo->prepare("UPDATE hospitals SET status = 'Approved' WHERE id = ?");
            $updateQuery->execute([$hospitalId]);
        }
    
        if (isset($_POST['rejectHospital'])) {
            $updateQuery = $pdo->prepare("UPDATE hospitals SET status = 'Reject' WHERE id = ?");
            $updateQuery->execute([$hospitalId]);
        }

        $query = $pdo->prepare("SELECT hospitals.*, users.name AS hospital_name, users.email AS hospital_email FROM hospitals JOIN users ON hospitals.hospital_id = users.id WHERE hospitals.id = ?");
        $query->execute([$hospitalId]);
        
        $hospitalData = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class=""><a href="allchilds.php" class="text-muted fw-light">Hospitals /</a></span> View Details</h4>

              <div class="row">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="assets/img/hospital.jpg"

                          alt="user-avatar"
                          class="d-block rounded border border-1 p-1 m-1"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <div class="button-wrapper ms-3">
                        <h3><span class="d-none d-sm-block"><?= $hospitalData['hospital_name'] ?></span></h3>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                    <form id="formAccountSettings" method="POST">
                        <div class="row">
                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Hospital Status</label>
                            <h4 class="mt-1"><?= $hospitalData['status'] ?></h4>
                        </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Address</label>
                            <h4 class="mt-1"><?= $hospitalData['address'] ?></h4>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Contect Number</label>
                            <h4 class="mt-1">+92 3<?= $hospitalData['number'] ?></h4>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">description</label>
                            <div class="input-group input-group-merge">
                            <h4 class="mt-1"><?= $hospitalData['description'] ?></h4>
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <h4 class="mt-1"><?= $hospitalData['hospital_email'] ?></h4>
                         </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" >Total Vaccine Childs</label>
                            <h4 class="mt-1">Count</h4>
                          </div>
                        </div>
                        <div class="mt-2">
                        <a href="adminUpdateHospital.php?id=<?= $hospitalData['id'] ?>" class="btn btn-primary me-2">Change Details & Save</a>
                            <button type="submit" name="approveHospital" class="btn btn-primary me-2">Approve</button>
                                    <button type="submit" name="rejectHospital" class="btn btn-outline-secondary">Reject</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <?php
    }
?>
              </div>
            </div>
            <!-- / Content -->

<?php
    include('assets/php/footer.php');
?>