<?php 
    if(is_userLoggedIn()) {
        if (is_admin()){
            include($_PHP."navbar_admin.php");
        }
        else{
            include($_PHP."navbar_user.php");
        }   
        
       // include($_PHP."navbar_user.php");
    }
    else {
        include($_PHP."navbar_nouser.php");
    }
?>