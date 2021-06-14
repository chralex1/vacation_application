<?php 
    session_start();
    include "php/approveFromMail.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Application Approved</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="p-5 rounded shadow" style="width: 30rem;" action="php/approveFromMail.php" method="POST">
            <h1 class="text-center pb-5 display-4">Application Updated</h1>

                <?php if(isset($_GET['success'])) { ?>
                    <div class="alert alert-success" style="text-align: center; width: 24rem;" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php } ?>

                <input type="text" name="id" hidden>
        </form>
    </div>
</body>
</html>