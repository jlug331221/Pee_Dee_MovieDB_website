<?php    

require_once('movie_dbconfig.php');
    
session_start();

$error='';

function login($email, $password, $db) {

    $query = "SELECT `password`, `privilege`, `u_id` FROM `user` WHERE `email` = :email and `password` = :password";
    $query_params = array(':email' => $email, ':password' => $password);
    
    try{
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
        $data               = $stmt->fetchAll();
        $stored_password    = $data['password']; 
        $id                 = $data['u_id']; // id of the user to be returned if the password is verified, below.
        $priv_level         = $data['privilege'];

        if($password === $stored_password) { 
            return array('id' => $id, 'priv_level' => $priv_level); // returning the user's id
        } else {
            return false;   
        }
    } 
    catch(PDOException $e) {
        die($e->getMessage());
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $login_info = login($email, $password, $db);
    if ($login_info === false) {
        $errors = 'Sorry, that username/password is invalid';
    }
    
    $_SESSION['login'] = $login_info['id'];
    $_SESSION['email'] = $email;
    $_SESSION['privilege'] = $login_info['privilege'];
}
    
?>
