<?php
include('assets/php/query.php');
include('assets/php/header.php');

function calculateExactAge($dob) {
    $birthdate = new DateTime($dob);
    $currentDate = new DateTime('today');
    $diff = $birthdate->diff($currentDate);

    return $diff->y . " years, " . $diff->m . " months";
}


    if (isset($_SESSION['userID'])) {
      
    


    if (isset($_GET['id'])) {
        $childId = $_GET['id'];

        $query = $pdo->prepare("SELECT childs.*, users.name AS parent_name, users.email AS parent_email FROM childs JOIN users ON childs.parent_id = users.id WHERE childs.id = ?");
        $query->execute([$childId]);
        
        $childData = $query->fetch(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class=""><a href="allchilds.php" class="text-muted fw-light">Childs /</a></span> View Profile</h4>

              <div class="row">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="assets/img/profile.jpg"

                          alt="user-avatar"
                          class="d-block rounded border border-1 p-1 m-1"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        <div class="button-wrapper ms-3">
                        <h3><span class="d-none d-sm-block"><?= $childData['name'] ?></span></h3>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row">
                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Parent</label>
                            <h4 class="mt-1"><?= $childData['parent_name'] ?></h4>
                        </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Age</label>
                            <h4 class="mt-1"><?= calculateExactAge($childData['dob']) ?></h4>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Phone Number</label>
                            <h4 class="mt-1">+92 3<?= $childData['phone'] ?></h4>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label"> Gender</label>
                            <div class="input-group input-group-merge">
                            <h4 class="mt-1"><?= $childData['gender'] ?></h4>
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <h4 class="mt-1"><?= $childData['parent_email'] ?></h4>
                         </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Date Of Birth</label>
                            <h4 class="mt-1"><?= $childData['dob'] ?></h4>
                            </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">Address</label>
                            <h4 class="mt-1"><?= $childData['address'] ?></h4>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" >Total Vaccine</label>
                            <h4 class="mt-1">Count</h4>
                          </div>
                        </div>
                        <?php
                          if ($_SESSION['role'] == 'Parent') {
                            ?>
                            <div class="mt-2">
                        <a href="updateChild.php?id=<?= $childData['id'] ?>" class="btn btn-primary me-2">Update Child Profile</a>
                            </div>
                            <?php
                          }
                        ?>
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
    }
    include('assets/php/footer.php');
?>