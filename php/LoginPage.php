<?php
    include('../_include/header.php');
    echo "<link rel='stylesheet' type='text/css' href='../css/Login.css' />";

    include('movie_user_login.php'); // Includes Login Script

    if(isset($_SESSION['email'])){
        header("location: user_profile.php");
    }
?>
    
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

<?php
    include($_INCLUDES.'footer.php');
?>