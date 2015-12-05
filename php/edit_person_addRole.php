<?php
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");

    if(!is_admin()) {
        header("Location: /index.php");
    }

    $personID = $_GET['q'];

    if(isset($_POST['person-add-role'])) {
        $url = '';
        $urlarray = array();
        $error = false;
        $errormsg = '';
        $success = false;
        $successmsg ='Successfully added '.$_GET['f'].' '.$_GET['l'].' ';
        
        if(isset($_POST['actor_role']) && !empty($_POST['actor_role']) && empty($_POST['role_name'])) {
            $error = true;
            $errormsg = 'Please enter role name for actor!';
        }
        else {
            list($title, $M_ID) = split(" - ", $_POST['movie']);
            $successmsg .= 'to movie "'.$title.'" ';
            if(isset($_POST['actor_role']) && !empty($_POST['actor_role']))
            {
                $A_ID = NULL;

                $actor_query = 'SELECT * FROM actor WHERE `P_ID` = '.$personID;
                $result = db_query($actor_query, NULL);
                //var_dump($result);
                if(empty($result)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO actor (P_ID) values (?)");
                        $stmt->bindParam(1, $personID);
                        $stmt->execute();
                        $A_ID = $db->lastInsertId();
                        //echo $A_ID;
                    }
                    catch(PDOException $ex) {
                        echo $ex;    
                    }   
                }
                else {
                    $A_ID = $result[0]['A_ID'];
                    //echo $A_ID;
                }
                try {
                    $stmt = $db->prepare("INSERT INTO acted_in (A_ID, M_ID, Role) values (?, ?, ?)");
                    $stmt->bindParam(1, $A_ID);
                    $stmt->bindParam(2, $M_ID);
                    $stmt->bindParam(3, $_POST['role_name']);
                    $stmt->execute();
                    $success = true;
                    $successmsg .= ' as an actor with role "'.$_POST['role_name'].'", ';
                    
                }
                catch(PDOException $ex) {
                        $error = true;
                        $errormsg = 'Database Error: This actor already exists with this role in the database!' ;
                }  
                
            }
            if(isset($_POST['director_role']) && !empty($_POST['director_role']))
            {
                $D_ID = NULL;

                $director_query = 'SELECT * FROM director WHERE `P_ID` = '.$personID;
                $result = db_query($director_query, NULL);
                //var_dump($result);
                if(empty($result)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO director (P_ID) values (?)");
                        $stmt->bindParam(1, $personID);
                        $stmt->execute();
                        $D_ID = $db->lastInsertId();
                        //echo $D_ID;
                    }
                    catch(PDOException $ex) {
                        echo $ex;    
                    }   
                }
                else {
                    $D_ID = $result[0]['D_ID'];
                    //echo $D_ID;
                }
                try {
                    $stmt = $db->prepare("INSERT INTO directed (D_ID, M_ID) values (?, ?)");
                    $stmt->bindParam(1, $D_ID);
                    $stmt->bindParam(2, $M_ID);
                    $stmt->execute();
                    $success = true;
                    $successmsg .= 'as a director, ';
                }
                catch(PDOException $ex) {
                        $error = true;
                        $errormsg = 'Database Error: This director already exists in the database!';
                }  
            }
            if(isset($_POST['composer_role']) && !empty($_POST['composer_role']))
            {
                $C_ID = NULL;

                $composer_query = 'SELECT * FROM composer WHERE `P_ID` = '.$personID;
                $result = db_query($composer_query, NULL);
                //var_dump($result);
                if(empty($result)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO composer (P_ID) values (?)");
                        $stmt->bindParam(1, $personID);
                        $stmt->execute();
                        $C_ID = $db->lastInsertId();
                        //echo $C_ID;
                    }
                    catch(PDOException $ex) {
                        echo $ex;    
                    }   
                }
                else {
                    $C_ID = $result[0]['C_ID'];
                    //echo $C_ID;
                }
                try {
                    $stmt = $db->prepare("INSERT INTO composed (C_ID, M_ID) values (?, ?)");
                    $stmt->bindParam(1, $C_ID);
                    $stmt->bindParam(2, $M_ID);
                    $stmt->execute();
                    $success = true;
                    $successmsg .= 'as a composer, ';
                }
                catch(PDOException $ex) {
                        $error = true;
                        $errormsg = 'Database Error: This composer already exists in the database!';
                }  
            }
            if(isset($_POST['producer_role']) && !empty($_POST['producer_role']))
            {
                $PR_ID = NULL;

                $producer_query = 'SELECT * FROM producer WHERE `P_ID` = '.$personID;
                $result = db_query($producer_query, NULL);
                //var_dump($result);
                if(empty($result)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO producer (P_ID) values (?)");
                        $stmt->bindParam(1, $personID);
                        $stmt->execute();
                        $PR_ID = $db->lastInsertId();
                        //echo $PR_ID;
                    }
                    catch(PDOException $ex) {
                        echo $ex;    
                    }   
                }
                else {
                    $PR_ID = $result[0]['PR_ID'];
                    //echo $PR_ID;
                }
                try {
                    $stmt = $db->prepare("INSERT INTO produced (PR_ID, M_ID) values (?, ?)");
                    $stmt->bindParam(1, $PR_ID);
                    $stmt->bindParam(2, $M_ID);
                    $stmt->execute();
                    $success = true;
                    $successmsg .= 'as a producer, ';
                }
                catch(PDOException $ex) {
                        $error = true;
                        $errormsg = 'Database Error: This producer already exists in the database!';
                }  
            }
            $successmsg = rtrim($successmsg, ', ');
            $successmsg .= '.';
            if(isset($_POST['writer_role']) && !empty($_POST['writer_role']))
            {
                $W_ID = NULL;

                $writer_query = 'SELECT * FROM writer WHERE `P_ID` = '.$personID;
                $result = db_query($writer_query, NULL);
                //var_dump($result);
                if(empty($result)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO writer (P_ID) values (?)");
                        $stmt->bindParam(1, $personID);
                        $stmt->execute();
                        $W_ID = $db->lastInsertId();
                        //echo $W_ID;
                    }
                    catch(PDOException $ex) {
                        echo $ex;    
                    }   
                }
                else {
                    $W_ID = $result[0]['W_ID'];
                    //echo $W_ID;
                }
                try {
                    $stmt = $db->prepare("INSERT INTO wrote (W_ID, M_ID) values (?, ?)");
                    $stmt->bindParam(1, $W_ID);
                    $stmt->bindParam(2, $M_ID);
                    $stmt->execute();
                    $success = true;
                    $successmsg .= 'as a writer, ';
                }
                catch(PDOException $ex) {
                        $error = true;
                        $errormsg = 'Database Error: This writer already exists in the database!';
                }  
            }
            $successmsg = rtrim($successmsg, ', ');
            $successmsg .= '.';
        }
        
        /*if(isset($_POST['country']) && !empty($_POST['country'])) {
            $urlarray['country'] = $_POST['country'];
        }*/
        
    }
    
    $query = "SELECT `Title`, `M_ID`
                FROM movie
                ORDER BY `Title`";
    $results = db_query($query, NULL);

?>
<div class="container">
    
    <?php if($error) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> <?php echo $errormsg; ?>
        </div>
    <?php } ?>
    
    <?php if($success) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success!</strong> <?php echo $successmsg; ?>
        </div>
    <?php } ?>
    
    <h2 align="center">Add roles for: <?php echo $_GET['f'].' '.$_GET['l']; ?></h2>
    
    <form class="form-horizontal" role="form" id="person-add-role" method="POST">
    <div class="form-group">
        <label class="control-label col-sm-2" for="roles">Roles:</label>
        <ul class="control-group genre-checkbox-group col-sm-10" id="roles">
            <li><input type="checkbox" name="actor_role" id="add-actor-role" value="actor" style="margin-right: 7px;"/><label for="cb1">Actor</label></li> 
            <li><input type="checkbox" name="director_role" id="add-director-role" value="director" style="margin-right: 7px;"/><label for="cb2">Director</label></li> 
            <li><input type="checkbox" name="composer_role" id="add-composer-role" value="composer" style="margin-right: 7px;"/><label for="cb3">Composer</label></li>
             <li><input type="checkbox" name="producer_role" id="add-producer-role" value="producer" style="margin-right: 7px;"/><label for="cb3">Producer</label></li>
             <li><input type="checkbox" name="writer_role" id="add-writer-role" value="writer" style="margin-right: 7px;"/><label for="cb3">Writer</label></li>
        </lu>
    </div>
        
   <div class="form-group">
        <label class="control-label col-sm-2" for="role_name">Role:</label>
        <div class="col-sm-10">
          <input type=text class="form-control" name="role_name" placeholder="Enter Role Name of Actor">
            <p class="help-block">If actor is selected, a role name must also be provided.</p>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-2" for="movie">Movie:</label>
        <div class="control-label col-sm-10">
            <select class="input-medium form-control" id="movie" placeholder="Select a movie" name="movie">
                <?php 
                    foreach($results as $row) {
                        echo "<option>".$row['Title'].' '.'-'.' '.$row['M_ID']."</option>";
                    }
                ?>
            </select>
        </div>
    </div>
        <div align="center"><button type="submit" name="person-add-role" class="btn btn-default">Submit</button></div>
    </form>
    
</div>



<?php
    
?>

<?php
    include($_INCLUDES."footer.php");
?>