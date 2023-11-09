<?php
session_start();
include('assets/php/connection.php');

// registeration -- signup
if(isset($_POST['signup'])) {

    $parentName = $_POST['parentName'];
    $parentEmail = $_POST['parentEmail'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    $parentPhone = $_POST['parentPhone'];
    $childName = $_POST['childName'];
    $childDOB = $_POST['childDOB'];
    $childGender = $_POST['childGender'];
    $childAddress = $_POST['childAddress'];

    // Check if email already exists
    $emailCheck = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $emailCheck->execute([$parentEmail]);

    if($emailCheck->rowCount() > 0) {
        echo "<script>
            alert('Email already exists!');
        </script>";
    }else {
        
    

    // validation
    if(!empty($parentName) && !empty($parentEmail) && !empty($password) && $password == $confirmPassword) {
        

        // Insert into database
        $query = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $query->execute([$parentName, $parentEmail, $password]);
        $parentID = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO childs (parent_id, phone, name, dob, gender, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$parentID, $parentPhone, $childName, $childDOB, $childGender, $childAddress]);
        
        
        echo "<script>
        alert('Registration Successful!');
        window.location.href = 'login.php';
    </script>";
    } else {
        echo "<script>
            alert('incorect data')
        </script>";
    }
}
}


// hospital Registration
if (isset($_POST['hospitalRegister'])) {
    $hospitalName = $_POST['hospitalName'];
    $hospitalEmail = $_POST['hospitalEmail'];
    $hospitalNum = $_POST['hospitalNum'];
    $hospitalAddress = $_POST['hospitalAddress'];
    $hopitalPassword = $_POST['hopitalPassword'];
    $hopitalConfirmPassword = $_POST['hopitalConfirmPassword'];  
    $hospitalDescription = $_POST['hospitalDescription'];

    // Check if passwords match
if ($hopitalPassword !== $hopitalConfirmPassword) {
    echo "<script>
    alert('Passwords do not match!');
    </script>";
    return;
}else{

    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = ? OR email = ?");
$stmt->execute([$hospitalName, $hospitalEmail]);

if ($stmt->rowCount() > 0) {
    echo "<script>
        alert('Hospital with this name or email already exists!');
    </script>";
} else {

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'hospital')");        $stmt->execute([$hospitalName, $hospitalEmail, $hopitalPassword]);
    
    $lastID = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO hospitals (hospital_id, number, address, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$lastID, $hospitalNum, $hospitalAddress, $hospitalDescription]);


    echo "<script>
        location.assign('hospitals.php')
    </script>";
}
}
}


// login
if(isset($_POST['login'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);

    if($user = $query->fetch()) {
        
        if($password === $user['password']) {
            
            $_SESSION['userID'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['userEmail'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($_SESSION['role'] === 'Hospital') {
                
                $queryStatus = $pdo->prepare("SELECT status FROM hospitals WHERE hospital_id = ?");
                $queryStatus->execute([$user['id']]);
                $hospitalStatus = $queryStatus->fetchColumn();
        
                
                $_SESSION['hospitalStatus'] = $hospitalStatus;
            }

            header('Location: index.php');
            exit; 
            
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>


