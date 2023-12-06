<?php
    require_once "Database.php";

    # The logic of our application will be place here
    class User extends Database{
        //use 'extends' to use protected function 
        public function store($request){
            $first_name =$request['firstname'];
            $last_name =$request['lastname'];
            $username =$request['username'];
            $password =$request['password'];


            # Hashed the password before inserting into the database
            $password = password_hash($password, PASSWORD_DEFAULT);
            #Note : $password - supplied by the user from the form
            #PASSWORD DEFAULT - The algorithm use to hashed the password
            
            #SQL Query string
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$password')";

            # Execute the query string
            if ($this->conn->query($sql)) {
                header("location: ../views"); //index.php or the login page
                exit();                       //same as die()
            }else {
                die("Error in creating a user. " . $this->conn->error);
            }   
        }

        public function login($request){
            $username = $request['username'];
            $password = $request['password'];

            $sql = "SELECT * FROM users WHERE username = '$username'";

            $result = $this->conn->query($sql);

            #Check the username if available
            if($result->num_rows == 1){ //if true, meaning the username is available
                #check if the password supplied is correct
                $user = $result->fetch_assoc();
                #$user['id'=>1, 'first_name'=>'mary', 'last_name'=>'Watson', 'username'=>'mary', 'password' => '8*23ka723'..]

                #check and compare the supplied password against the password already in the database
                if(password_verify($password, $user['password'])){
                #create the session variables
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['first_name'] . " " . $user['last_name'];

                header("location:../views/dashboard.php");//we will create dashboard.php later on
                exit;
            }else{
                die("Password do not matched.");
            }
            }else{
                die("username not found");
            }
        }
        public function logout(){
            session_start();//start the session
            session_unset();//unset the session variables we have set suring login
            session_destroy();//destroy or remove the session variables
            
            header("location:../views"); //redirect to the login page
            exit;
            }

        public function getAllUsers(){
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";

            if($result = $this->conn->query($sql)){
                return $result;
            }else{
                die("Error in retrieving all users." . $this->conn->error);
            }
        }

        public function getUser(){
            $id = $_SESSION['id'];//ge the id of the logged-in user

            $sql ="SELECT first_name,last_name, username, photo FROM users WHERE id='$id'";

            if($result = $this->conn->query($sql))
            {
                    return $result->fetch_assoc();        
            }else {
                die("Error in retrieving user:" . $this->conn->error);
             }
        }

        public function update($request, $files){
            session_start();
            $id = $_SESSION['id']; //user who is currently logged-in
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
          
            #Image file
            $photo =$files['photo']['name'];
            $tmp_photo =$files['photo']['tmp_name'];

            $sql = "UPDATE users SET first_name ='$first_name', last_name ='$last_name', username= '$username' WHERE id='$id'";

            if($this->conn->query($sql)){
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = "$first_name $last_name";

                #Check if there is an uploaded photo, save to Db and save the file into the image folder
                if($photo){
                    $sql ="UPDATE users SET photo ='$photo' WHERE id ='$id'";
                    $destination = "../assets/images/$photo";

                    #save the image into Db
                    if($this->conn->query($sql)){
                        #save the image into the images folder
                        if(move_uploaded_file($tmp_photo, $destination)){
                            header("location: ../views/dashboard.php");
                            exit;
                        }else{
                            die("Error in moving the photo.");
                        }
                    }else{
                        die("Error in uploading photo . " . $this-conn->error);
                        }
                        header("location: ../views/dashboard.php");
                        exit;
                    }
                }else{
                    die("Error in updating the user." . $this->conn->error);
            }
        }
        # This method is called from the action file 
        public function delete(){
            session_start();
            $id = $_SESSION['id']; //the id of the currently logged-in user

            $sql = "DELETE FROM users where id= '$id'";

            if($this->conn->query($sql)){//if this is okay, call the logout method
                $this->logout();// call the logout method
            }else{
                die("Error in deleting your account." );
            }
        }
    }
?>