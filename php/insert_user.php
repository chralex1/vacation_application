<?php
session_start();
include "db_conn.php";

if(isset($_POST['submit'])) {
    function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $firstname = testInput($_POST['firstname']);
    $lastname = testInput($_POST['lastname']);
    $email = testInput($_POST['email']);
    $password = testInput($_POST['password']);
    $confirmPassword = testInput($_POST['confirmPassword']);
    $userType = testInput($_POST['role']);

    $password = md5($password);
    $confirmPassword = md5($confirmPassword);

    $check_mail = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_mail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if(empty($firstname)) {
        header("Location: ../create/new_user.php?error=Firstname is Required!");
    }else if(empty($lastname)) {
       header("Location: ../create/new_user.php?error=Lastname is Required!");
    }else if(empty($email)) {
        header("Location: ../create/new_user.php?error=Email is Required!");
    }else if(mysqli_num_rows($result) > 0) {
        header("Location: ../create/new_user.php?error=A user already signed up with this mail. Please try with another one.");
    }else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        header("Location: ../create/new_user.php?error=This email format is not valid. Please enter a valid email.");
    }else if(empty($password)) {
        header("Location: ../create/new_user.php?error=Password is Required!");
    }else if(empty($confirmPassword)) {
        header("Location: ../create/new_user.php?error=You have to confirm your password!");
    }else if($password !== $confirmPassword) {
        header("Location: ../create/new_user.php?error=The password confirmation does not match.");
    }else {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $password,  $userType);
        $stmt->execute();
        
        // In case everything is OK
        header("Location: ../home.php?success=You successfully created a new user. Thank you!");
    }      
}else {
    header("Location: insert_user.php");
}