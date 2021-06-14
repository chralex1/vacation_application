<?php 
    include "./php/db_conn.php";
    if(isset($_SESSION['email']) && isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $sql = "SELECT * FROM applications WHERE user_id = '$user_id' ORDER BY date_submitted DESC";
        $result = mysqli_query($conn, $sql);
    }
?>