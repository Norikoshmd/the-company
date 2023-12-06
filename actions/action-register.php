<?php
    include "../classes/User.php"; //this is the class fie that contains the logic of the app

    #create an object
    $user = new user;

    #call the store method
    $user->store($_POST);
    //Note : The $_POST --- holds the data from the form "username""password" everything

?>