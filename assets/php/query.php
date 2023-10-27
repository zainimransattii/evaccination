<?php
include('assets/php/connection.php');

// registeration -- signup
if(isset($_POST['signup'])) {

    $parentName = $_POST['parentName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];

    // Check if email already exists
    $emailCheck = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $emailCheck->execute([$email]);

    if($emailCheck->rowCount() > 0) {
        echo "<script>
            alert('Email already exists!');
        </script>";
    }else {
        
    

    // validation
    if(!empty($parentName) && !empty($email) && !empty($password) && $password == $confirmPassword) {
        

        // Insert into database
        $query = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $query->execute([$parentName, $email, $password]);
        
        
        echo "<script>
            alert('corect data')
        </script>";
    } else {
        echo "<script>
            alert('incorect data')
        </script>";
    }
}
}




// login

if(isset($_POST['login'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists with the provided email
    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);

    if($user = $query->fetch()) {
        
        if(password_verify($password, $user['password'])) {
            // session_start();
            // $_SESSION['userID'] = $user['id'];
            // $_SESSION['username'] = $user['name'];

            
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
    }
}
?>


