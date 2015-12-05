<?php
    $errors=''; // Variable To Store Error Message
    if (isset($_POST['submit'])) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $errors = "Invalid Email or Password";
        }
        else
        {
            // Define $email and $password
            $email=$_POST['email'];
            $password=$_POST['password'];
            
            // Establishing Connection with Server by passing server_name, user_id and password as a parameter
            $connection = mysql_connect("localhost", "webUser", "Student2015");
            
            // To protect MySQL injection for Security purpose
            $email    = stripslashes($email);
            $password = stripslashes($password);
            $email    = mysql_real_escape_string($email);
            $password = mysql_real_escape_string($password);

            // Selecting Database
            $db = mysql_select_db("movie_website_database", $connection);
            
            // SQL query to fetch information of registerd users and finds user match.
            $query = mysql_query("select * from user where Password='$password' AND Email='$email'", $connection);
            $rows = mysql_num_rows($query);
            if ($rows == 1) {
                $row = mysql_fetch_row($query);
                $_SESSION['email'] = $email; // Initializing Session
                $_SESSION['privilege'] = $row[3];
                $_SESSION['id'] = $row[0];
                // header("location: user_profile.php"); // Redirecting To Other Page
                
            } else {
                $errors = "Invalid Email or Password";
            }
            mysql_close($connection); // Closing Connection
        }
    }
?>