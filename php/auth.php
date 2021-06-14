<?php 
session_start();
include "db_conn.php";
include "../functions/test_input.php";

if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = testInput($_POST['email']);
    $password = testInput($_POST['password']);
    // Some basic validations for email & password inputs
    if(empty($email)) {
        header("Location: ../login.php?error=Email is Required!");
    }else if(empty($password)) {
        header("Location: ../login.php?error=Password is Required!");
    }else {
        $password = md5($password);

        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if($row['password'] === $password) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];

                // In case everything is OK redirect user to home.php
                header("Location: ../home.php");
            // In case of incorrect email or password displaying errors
            } else {
                header("Location: ../login.php?error=Incorrect data given. Check your email and your Password.");
            }
        } else {
            header("Location: ../login.php?error=Incorrect data given. Check your email and your Password.");
        }
    } 
} else {
    header("Location: ../login.php");
}
