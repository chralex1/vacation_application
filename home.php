<?php 
    session_start();
    include "php/db_conn.php";
    include "read/applications_list.php";
    include "functions/show_days.php";
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
    <?php if($_SESSION['role'] == "user") { ?>
        <title>User Page</title> 
    <?php }else{ ?> 
        <title>Admin Page</title>
    <?php } ?>
</head>
<body>

    <?php if($_SESSION['role'] == "user") { ?>

    <div class="d-flex flex-column mt-2 align-items-center row" style="min-height: 40vh;">
        <a href="create/sub_form.php" style="width: 20rem; color: white; text-decoration: none; text-align: center;">
            <button type="submit" class="btn btn-primary mb-3" style="width: 20rem;">
                Submit Request
            </button>
        </a>
        <table class="table shadow p-3 mb-5 bg-body rounded">
            <?php if(isset($_GET['success'])) { ?>
                <div class="alert alert-success" style="text-align: center; width: 60rem;" role="alert">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>
            <thead>
                <tr class="text-center">
                    <th>Date Submitted</th>
                    <th>Vacation Start</th>
                    <th>Vacation End</th>
                    <th>Days Requested</th>
                    <th>Status</th>
                </tr>
            </thead>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr class="text-center">
                    <td> <?= $row['date_submitted']; ?> </td>
                    <td> <?= $row['vacation_start']; ?> </td>
                    <td> <?= $row['vacation_end']; ?> </td>
                    <td> 
                        <?php
                                $date1 = $row['vacation_end'];
                                $date2 = $row['vacation_start'];
                                echo showDays($date2, $date1);
                        ?> 
                    </td>
                    <td> <?= $row['status']; ?> </td>
                </tr>
            <?php endwhile; ?>

        </table>

        <a href="php/logout.php" style="text-align: right; width: 10rem; color: white; text-decoration: none;">
            <button type="submit" class="btn btn-primary mb-3" style="width: 10rem;">
                Logout
            </button>
        </a>    
    </div>
    <?php } else { include "read/users_list.php";?>
    
        <div class="d-flex flex-column mt-2 align-items-center row" style="min-height: 40vh;">
            <a href="create/new_user.php" class="" style="width: 20rem; color: white; text-decoration: none; text-align: center;">
                <button type="submit" class="btn btn-primary mb-3" style="width: 20rem;">
                    Create User
                </button>
            </a>
            <!-- needs better implementation -->
            
            <table class="table shadow p-3 mb-5 bg-body rounded">
            
                <?php if(isset($_GET['success'])) { ?>
                    <div class="alert alert-success" style="text-align: center; width: 60rem;" role="alert">
                        <?= $_GET['success'] ?>
                    </div>
                <?php } ?>
                
                <thead>       
                    <tr class="text-center">
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>E-mail</th>
                        <th>User Type</th>
                        <th></th>
                    </tr>   
                </thead>
                 
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    
                    <tr class="text-center" id="update_<?= $row['id'] ?>">               
                        <td><?= $row['firstname']; ?> </td>
                        <td> <?= $row['lastname']; ?> </td>
                        <td> <?= $row['email']; ?> </td>
                        <td> <?= $row['role']; ?> </td>
                        <td>
                            <a href="properties.php?user_id=<?= $row['id'];?>" class="btn btn-success" style="width: 120px;">
                            Edit
                            </a>
                        </td>       
                    </tr>
                    
                <?php endwhile; ?>
                
            </table>
            
            <a href="php/logout.php" style="text-align: right; width: 10rem; color: white; text-decoration: none;">
                <button type="submit" class="btn btn-primary mb-3" style="width: 10rem;">
                    Logout
                </button>
            </a>    
        </div>

    <?php } ?>

</body>
</html>
<?php } else { header('Location: login.php'); } ?>