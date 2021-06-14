<?php 
    session_start();
    if(isset($_SESSION['email']) && isset($_SESSION['id'])) {
        include "php/user_properties.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>User Update Form</title>
</head>
<body>

    <?php require_once "php/db_conn.php"; ?>

    <div class="d-flex flex-column align-items-center row" style="min-height: 40vh;">
        <form class="mb-3 rounded shadow" style="width: 60rem;" action="php/user_properties.php" method="POST">
            <div class="d-flex flex-column mt-4 align-items-center form-group row">

                <?php if(isset($_GET['error'])) { ?>
                    <div class="alert alert-danger" style="text-align: center; width: 60rem;" role="alert">
                        <?= $_GET['error'] ?>
                    </div>
                <?php } ?>

                <label for="example-date-input" class="col-2 col-form-label">
                    <h5 class="text-center">First name</h5>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" type="text" name="firstname" id="firstname" value="<?= $row['firstname']; ?>">
                </div>
            </div>
            <div class="d-flex flex-column mt-1 align-items-center form-group row">
                <label for="example-date-input" class="col-2 col-form-label">
                    <h5 class="text-center">Last name</h5>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" type="text" name="lastname" id="lastname" value="<?= $row['lastname']; ?>">
                </div>
            </div>
            <div class="d-flex flex-column mt-1 align-items-center form-group row">
                <label for="email-input" class="col-2 col-form-label">
                    <h5 class="text-center">E-mail</h5>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" type="text" name="email" id="email" value="<?= $row['email']; ?>">
                </div>
            </div>
            <div class="d-flex flex-column mt-1 align-items-center form-group row">
                <label for="password" class="col-2 col-form-label">
                    <h5 class="text-center">Password</h5>
                </label>
                <div class="col-4 mb-3">
                    <input class="form-control" id="password" type="password" name="password">
                </div>
            </div>
            <div class="d-flex flex-column mt-1 align-items-center form-group row">
                <label for="confirmPassword" class="form-label">
                    <h5 class="text-center">Confirm Password</h5>
                </label>
                <div class="col-4 mb-3">
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
                </div>
            </div>
            <div class="d-flex flex-column mt-1 align-items-center form-group row">
                <label class="form-label">
                    <h5 class="text-center">Select User Type</h5>
                </label>
                <div class="col-4 mb-3">
                    <select class="form-select mb-3" name="role" aria-label="userType">
                        <option selected value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <input type="text" name="id" value=<?= $row['id'] ?> hidden>

            <div class="text-center">
                <a href="../home.php" class="" style="width: 20rem; color: white; text-decoration: none; text-align: center;">
                    <button type="submit" class="btn btn-primary mb-3" name="update" style="width: 20rem;">
                        Update
                    </button>
                </a>
            </div>
        </form>     
    </div>
</body>
</html>

<?php } else { header('Location: login.php'); } ?>