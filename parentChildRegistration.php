<?php
include('assets/php/query.php');
include('assets/php/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentName = $_POST['parentName'];
    $parentEmail = $_POST['parentEmail'];
    $parentPassword = $_POST['parentPassword'];

    $parentPhone = $_POST['parentPhone'];
    $childName = $_POST['childName'];
    $childDOB = $_POST['childDOB'];
    $childGender = $_POST['childGender'];
    $childAddress = $_POST['childAddress'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$parentName, $parentEmail, $parentPassword, 'Parent']);
    $parentID = $pdo->lastInsertId(); 

    $stmt = $pdo->prepare("INSERT INTO childs (parent_id, phone, name, dob, gender, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$parentID, $parentPhone, $childName, $childDOB, $childGender, $childAddress]);

    echo "<script>
        alert('Registration Successful!');
        window.location.href = 'login.php';
    </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Parent and Child Registration</title>
</head>
<body>
    <h2>Parent and Child Registration</h2>
    <form action="parentChildRegistration.php" method="POST">
        <h3>Parent Details</h3>
        <label for="parentName">Parent Name:</label>
        <input type="text" name="parentName" id="parentName" required><br><br>

        <label for="parentEmail">Parent Email:</label>
        <input type="email" name="parentEmail" id="parentEmail" required><br><br>

        <label for="parentPassword">Password:</label>
        <input type="password" name="parentPassword" id="parentPassword" required><br><br>

        <!-- Set default role as Parent -->
        <input type="hidden" name="role" value="Parent">

        <h3>Child Details</h3>
        <label for="parentPhone">Parent Phone:</label>
        <input type="text" name="parentPhone" id="parentPhone" required><br><br>

        <label for="childName">Child Name:</label>
        <input type="text" name="childName" id="childName" required><br><br>

        <label for="childDOB">Child Date of Birth:</label>
        <input type="date" name="childDOB" id="childDOB" required><br><br>

        <label for="childGender">Child Gender:</label>
        <input type="text" name="childGender" id="childGender" required><br><br>

        <label for="childAddress">Child Address:</label>
        <textarea name="childAddress" id="childAddress" required></textarea><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
<?php
include('assets/php/footer.php');
?>