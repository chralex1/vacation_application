<?php
session_start();
include "php/db_conn.php";
include "functions/show_days.php";
include "functions/test_input.php";

if(isset($_POST['submit'])) {
    $date_time = date("Y-m-d h:i:s");
    $vacation_start = testInput($_POST['vacation_start']);
    $vacation_end = testInput($_POST['vacation_end']);
    $reason = testInput($_POST['reason']);
    $user_id = $_SESSION['id'];

    // In case dates are invalid or reason is empty
    if(strtotime($vacation_start) == strtotime($vacation_end) || strtotime($vacation_start) > strtotime($vacation_end)){
        header("Location: create/sub_form.php?error=Something is wrong with the dates you entered. Please check it out!");

    // In case everything is ok
    } else if(showDays($vacation_start, $vacation_end) > 0 && !empty($reason)) {
        $sql = "INSERT INTO applications (date_submitted, vacation_start, vacation_end, reason, user_id) VALUES (?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $date_time, $vacation_start, $vacation_end, $reason, $user_id);
        $stmt->execute();
    
        $result = $stmt->get_result();

        // Mail Functionality From Users' side
        $getAdmins = "SELECT email FROM users WHERE role='admin' LIMIT 1";
        $result_mails = mysqli_query($conn, $getAdmins);

        $mailConf = mysqli_fetch_array($result_mails);

        $userData = "SELECT * FROM users WHERE id='$user_id'";
        $result_data = mysqli_query($conn, $userData);
        $dataConf = mysqli_fetch_array($result_data);

        $getApplicationId = "SELECT id FROM applications WHERE date_submitted='$date_time' AND vacation_start='$vacation_start' AND vacation_end='$vacation_end' AND reason='$reason'";

        $application_id = mysqli_query($conn, $getApplicationId);
        $appId_array = mysqli_fetch_array($application_id);
        $appId = $appId_array['id'];

        $user_full_name = $dataConf['firstname'] . " " . $dataConf['lastname'];
        $approve_link = '<a href="http://localhost/epignosis-test/approve.php?appId='.$appId.'" style="text-decoration: none;">Approve Application</a>';
        $reject_link = '<a href="http://localhost/epignosis-test/reject.php?appId='.$appId.'" style="text-decoration: none;">Reject Application</a>';

        $mailTo = $mailConf['email'];
        $subject = "Vacation Application " . $user_full_name;
        $body = "Dear supervisor, employee " . $user_full_name . " requested for some time off, starting on " . $vacation_start . " and ending on " . $vacation_end . ", stating the reason: <br><br>" . $reason . "<br><br>Click on one of the below links to approve or reject the application: <br><br>" . $approve_link . " -- " . $reject_link;
        $headers = "From: " . $dataConf['email'];
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
        mail($mailTo, $subject, $body, $headers);     
    
        // In case everything is OK
        header("Location: home.php?success=Your Application has been sent to your supervisor. Thank you!");
        }
    
    if(empty($reason)) {
        header("Location: create/sub_form.php?error=Reason is required. Please write some text in it.");
    }
} else {
        header("Location: create/sub_form.php");
    }