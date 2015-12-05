<?php
    $error='';
    if(empty($_POST['email']) || empty($_POST['em_confirm'])
       || empty($_POST['password']) || empty($_POST['pw_confirm'])) {
        $error = "One or more fields are missing";
    }
    else if($_POST['email'] != $_POST['em_confirm'] ||
          $_POST['password'] != $_POST['pw_confirm']) {
        $error = "Email fields or password fields do not match";
    }
    else { //Input data is valid
        // Establishing Connection with Server by passing server_name, user_id and password as a parameter
        $connection = mysql_connect("localhost", "webUser", "Student2015") or die(mysql_error());

        //Selecting Database
        mysql_select_db("movie_website_database", $connection);

        $sql = "insert into user (Email, Password, Privilege) values('$_POST[email]', '$_POST[password]', '0')";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        
        //Query for user ID
        $sql = "SELECT U_ID
                FROM user 
                WHERE `Email` = '$_POST[email]'
                AND `Password` = '$_POST[password]'";
        $UIDresult = mysql_query($sql,$connection) or die(mysql_error());
        $row = mysql_fetch_row($UIDresult);
        $UserID = $row[0];
        
        //Query for List update
        $sql = "INSERT INTO list (L_ID) values (NULL)";
        $LIDresult = mysql_query($sql,$connection) or die(mysql_error());
        $LID = mysql_insert_id();
        
        //Query for Compiles update
        $sql = "INSERT INTO compiles (U_ID, L_ID) values ('$UserID', '$LID')";
        $Compresult = mysql_query($sql,$connection) or die(mysql_error());
        
        //Query for movie_list update
        $sql = "INSERT INTO movie_list (L_ID, ML_ID) values ('$LID', NULL)";
        $MLresult = mysql_query($sql,$connection) or die(mysql_error());
        
        //Query for person_list update
        $sql = "INSERT INTO person_list (L_ID, PL_ID) values ('$LID', NULL)";
        $PLresult = mysql_query($sql,$connection) or die(mysql_error());
        
        print "<h1>You have successfully registered</h1>";
        print "<a href='LoginPage.php'>Go to login page</a>";
    }
?>