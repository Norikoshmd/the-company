<?php
    include "../classes/User.php";

    #Create an object
    $user = new User;

    #call the login method
    $user->login($_POST);
    # $_POST holds the data coming from the login form

?>