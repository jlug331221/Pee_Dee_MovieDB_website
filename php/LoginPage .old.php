<?php
    include('movie_user_login.php'); // Includes Login Script

    if(isset($_SESSION['email'])){
        header("location: user_profile.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <title>Database Project-Login</title>
    <meta charset="utf-8">
        
    <meta name="viewport" content="width=device-width, initial-scal=1">
        
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <!-- Custom css style -->
    <link rel="stylesheet" href="../css/Login.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <!-- Icon -->
    <link rel="icon" type="image/png" href="../images/icon.png" sizes="16x16">
    
</head>
    
<body>
    
    <div class = "container">
        <div class="wrapper">
            <form action="" method="post" name="Login_Form" class="form-signin">       
                <h3 class="form-signin-heading">Welcome Back! Please Sign in</h3>
                <br>

                <input type="text" class="form-control" name="email" placeholder="Email" required="" autofocus="" />
                <input type="password" class="form-control" name="password" placeholder="Password" required=""/>     		  

                <button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="Submit">Login</button>
                <span> <?php echo $errors; ?> </span>

            </form>			
        </div>
    </div>
    
</body>

</html>