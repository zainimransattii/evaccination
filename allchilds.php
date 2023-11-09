<?php
include('assets/php/query.php');
include('assets/php/header.php');

if (isset($_SESSION['userID'])) {
    if ($_SESSION['role'] === 'Admin') {
        $adminQuery = $pdo->prepare("SELECT childs.*, users.name AS parent_name, users.email AS parent_email FROM childs JOIN users ON childs.parent_id = users.id WHERE users.role = 'Parent'");
        $adminQuery->execute();
        $children = $adminQuery->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($_SESSION['role'] === 'Parent') {
        $parentQuery = $pdo->prepare("SELECT childs.*, users.name AS parent_name, users.email AS parent_email FROM childs JOIN users ON childs.parent_id = users.id WHERE users.role = 'Parent' AND users.id = ?");
        $parentQuery->execute([$_SESSION['userID']]);
        $children = $parentQuery->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Childs <span class="text-muted fw-light">Details</span></h4>

    <div class="card">
        <h5 class="card-header">Table Basic</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Parent Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($children as $child): ?>
                    <tr>
                        <td><?= $child['id'] ?></td>
                        <td><?= $child['name'] ?></td>
                        <td><?= $child['parent_name'] ?></td>
                        <td>+92 3<?= $child['phone'] ?></td>
                        <td><?= $child['parent_email'] ?></td>
                        <td><a href="viewchild.php?id=<?= $child['id'] ?>" class="badge bg-label-primary btn m-1">View More</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('assets/php/footer.php');
?>
