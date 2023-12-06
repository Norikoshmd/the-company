<?php
   # we need to start the session in order
   # to use the session variables
    session_start();

    require "../classes/user.php";

    $user =  new User;
    $all_users = $user->getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
     <!-- Bootstrap CDN -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Stylesheet -->
    <link rel="stylesheet" href= "..//assets/css/style.css">

</head>
<body>

<nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
    <div class="container">
        <a href="dashboard.php" class="navbar-brand">
            <h1 class="h3">The Company</h1>
        </a>
        <div class="navbar-nav">
            <span class= "navbar-text"><?=$_SESSION['fullname']?></span>
            <form action="../actions/action-logout.php" method="post" class="d-flex ms-2">
                <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
            </form>
        </div>
    </div>
</nav>

<main class="row justify-content-center gx-o">
    <div class="col-6">
        <h2 class="text-center">User List</h2>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Id</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Username</th>
                    <th>Edit|Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($user = $all_users->fetch_assoc()){
                ?>
                <tr>
                    <td>
                        <?php
                        if($user['photo']){
                        ?>
                        
                       <img src="../assets/images/<?=$user['photo']?>" alt="<? $user['photo']?>" class="d-block mx-auto dashboard-photo">

                       <?php
                        }else{
                       ?>
                       <i class = "fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                       <?php
                        }
                       ?>
                    </td>
                    <td><?=$user['id']?></td>
                    <td><?=$user['first_name']?></td>
                    <td><?=$user['last_name']?></td>
                    <td><?=$user['username']?></td>
                    <td>
                        <?php
                            if($_SESSION['id'] == $user['id']){
                        ?>
                            <a href="edit-user.php" class="btn btn-outline-warning" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="delete-user.php" class="btn btn-outline-danger" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>


    
    



<!-- Bootstrap JS CDN Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>