<?php
include "db_conn.php";
include "./functions/test_input.php";
    if(isset($_GET['appId'])) {
        $id = testInput($_GET['appId']);
        $sql = "SELECT * FROM applications WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        $sql = "UPDATE applications SET status=? WHERE id=?";

        $statusRejected = "rejected";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $statusRejected, $id);
        $stmt->execute();

        header("Location: ./reject.php?success=You successfully rejected the user's application!");

        $getUserId = "SELECT * FROM applications WHERE id='$id'";
        $dataUser = mysqli_query($conn, $getUserId);
        $dataUserIdArray = mysqli_fetch_array($dataUser);
        $dataUserId = $dataUserIdArray['user_id'];
        $date_submitted = $dataUserIdArray['date_submitted'];

        $getEmployeeMail = "SELECT email FROM users WHERE id='$dataUserId'";
        $data = mysqli_query($conn, $getEmployeeMail);
        $dataEmailArray = mysqli_fetch_array($data);
        $userEmail = $dataEmailArray['email'];

        $subject = "Vacation Application Rejected!";
        $body = "Dear employee, your supervisor has rejected your application submitted on " . $date_submitted . ".";

        mail($userEmail, $subject, $body);
    } 