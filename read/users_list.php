<?php 
    include "./php/db_conn.php";
    if(isset($_SESSION['email']) && isset($_SESSION['id'])) {
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
    }
?>