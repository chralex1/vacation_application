<?php 
    session_start();
    include "../functions/show_days.php";
    if(isset($_SESSION['email']) && isset($_SESSION['id'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Submission Form Page</title>
</head>
<body>

    <?php require_once "../php/db_conn.php"; ?>

    <div class="d-flex flex-column align-items-center row" style="min-height: 40vh;">
        <form class="mb-3 rounded shadow" style="width: 120rem;" action="../insert.php" method="POST">
            <div class="d-flex flex-column mt-4 align-items-center form-group row">

                <?php if(isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" style="text-align: center; width: 60rem;" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                <?php } ?>

                <label for="example-date-input" class="col-2 col-form-label">
                    <h3 class="text-center">Date From</h3>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" type="date" value="<?= dateFormat(); ?>"  name="vacation_start" id="vacation_start">
                </div>
            </div>
            <div class="d-flex flex-column mt-3 align-items-center form-group row">
                <label for="example-date-input" class="col-2 col-form-label">
                    <h3 class="text-center">Date To</h3>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" type="date" value="<?= dateFormat(); ?>"  name="vacation_end" id="vacation_end">
                </div>
            </div>
            <div class="d-flex flex-column mt-3 align-items-center form-group row">
                    <label for="exampleFormControlTextarea1" class="mb-2">
                        <h3 class="text-center font-italic">Reason</h3>
                    </label>
                    
                    <textarea class="form-control mb-3" style="width:50rem;" name="reason" id="reason" rows="3"></textarea>      
            </div>

            <div class="text-center">
                <a href="../home.php" class="" style="width: 20rem; color: white; text-decoration: none; text-align: center;">
                    <button type="submit" class="btn btn-primary mb-3" name="submit" style="width: 20rem;">
                        Submit
                    </button>
                </a>
            </div>
        </form>     
    </div>
</body>
</html>

<?php } else { header('Location: login.php'); } ?>