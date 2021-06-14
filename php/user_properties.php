<?php 
    include "db_conn.php";
    //include "../functions/test_input.php";

    // having some trouble with mapping (including) this function in this file
    function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if(isset($_GET['user_id'])) {
        $id = testInput($_GET['user_id']);

        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        } else {
            header("Location: ../home.php");
        }
    } else if(isset($_POST['update'])) { 
        $firstname = testInput($_POST['firstname']);
        $lastname = testInput($_POST['lastname']);
        $email = testInput($_POST['email']);
        $password = testInput($_POST['password']);
        $confirmPassword = testInput($_POST['confirmPassword']);
        $userType = testInput($_POST['role']);
        $id = testInput($_POST['id']);
    
        $check_mail = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_mail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    

        // Some basic input validation
        if(empty($firstname)) {
            header("Location: ../properties.php?user_id=$id&error=Firstname is Required!");
        }else if(empty($lastname)) {
           header("Location: ../properties.php?user_id=$id&error=Lastname is Required!");
        }else if(empty($email)) {
            header("Location: ../properties.php?user_id=$id&error=Email is Required!");
        // }
        // else if(mysqli_num_rows($result) > 0) {
            // header("Location: properties.php?user_id=$id&error=A user already signed up with this mail. Please try with another one.");
        }else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            header("Location: ../properties.php?user_id=$id&error=This email format is not valid. Please enter a valid email.");
        }else if(empty($password)) {
            header("Location: ../properties.php?user_id=$id&error=Password is Required!");
        }else if(empty($confirmPassword)) {
            header("Location: ../properties.php?user_id=$id&error=You have to confirm your password!");
        }else if($password !== $confirmPassword) {
            header("Location: ../properties.php?user_id=$id&error=The password confirmation does not match.");
        }else {
            $sql = "UPDATE users SET firstname=?, lastname=?, email=?, password=?, role=? WHERE id=$id ";

            $password = md5($password);
            $confirmPassword = md5($confirmPassword);
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $password,  $userType);
            $stmt->execute();

            $result = $stmt->get_result();
            
            // In case everything is OK
            header("Location: ../home.php?success=You successfully updated a user!");
        }
    }
?>