<?php
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");

    $personID = $_GET['q'];
    $query = 'SELECT * 
                FROM person P LEFT JOIN image I 
                on P.I_ID = I.I_ID 
                WHERE P.P_ID = :personID';

    $params = array(':personID' => $personID);

    try {
        $stmt = $_DBCONTEXT->prepare($query);
        $result = $stmt->execute($params);
    }
    catch(PDOException $ex) {
        echo ex;
    }

    $person = $stmt->fetch();

    if(isset($_POST['$cb'])) 
    {
      $query = "SELECT PL_ID 
                FROM person_list P join compiles C
                on P.L_ID = C.L_ID
                WHERE U_ID = :userID"; 
      $query_params = array(':userID' => $_SESSION['id']);     
        
      try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
        
      }
      catch(PDOException $ex) {        
        echo $ex;
      }     
          
      if($result)
      {
          $row = $stmt->fetch();
          $PL_ID = $row['PL_ID'];           
      }
        
     $query = "INSERT INTO movie_website_database.contains_person (`P_ID`, `PL_ID`) VALUES (:personID, :PLID)";
     $query_params = array(':personID' => $personID, ':PLID' => $PL_ID);
       
     try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex) {        
        echo $ex;
      }    
        
      if($result)
      {
        $favupdate = true;
        $favmsg = ' has been added to your favorites list!';
      }        
    }

    if(isset($_POST['$cb-remove'])) 
    {
      $query = "SELECT PL_ID 
                FROM person_list P join compiles C
                on P.L_ID = C.L_ID
                WHERE U_ID = :userID"; 
      $query_params = array(':userID' => $_SESSION['id']);     
        
      try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
        
      }
      catch(PDOException $ex) {        
        echo $ex;
      }     
          
      if($result)
      {
          $row = $stmt->fetch();
          $PL_ID = $row['PL_ID'];           
      }
        
     $query = "DELETE FROM contains_person WHERE `P_ID` = :personID AND `PL_ID` = :PLID";
     $query_params = array(':personID' => $personID, ':PLID' => $PL_ID);
       
     try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex) {        
        echo $ex;
      }    
        
      if($result)
      {
        $favupdate = true;
        $favmsg = ' has been removed from your favorites list!';
      }        
    }
?>
<div class="container">
  <div class="row equal">
    <div class="col-xs-4 col-sm-4">
        <div class="row">
            <div class="col-md-12">
                <div class="thumbnail">
                    <img src="data:<?php echo $person['Image_type']; ?>; base64,<?php echo base64_encode($person['Image']); ?>" 
                             alt="<?php echo format_person_name($person); ?>" style="width:300;height:450px;">
                    <div class="caption">
                        <h2><?php echo format_person_name($person); ?></h2>
                        <p>Country of Origin: <?php echo $person['Country_Of_Origin']; ?></p>
                        <p style="display:block">Born: <?php echo $person['DOB'];
                            if(is_userLoggedIn() && !personInList($personID)) { ?>
                                <form action="<?php $_PHP_SELF ?>" method="POST">
                                    <div class="checkbox">
                                        <label><input id="$cb" name="$cb" type="checkbox" value="" checked hidden></label>
                                        <button type="submit" 
                                              style="margin-left:10px;"
                                              class="btn btn-primary glyphicon glyphicon-heart pull-right" 
                                              style="font-size:30px;"
                                              data-toggle="tooltip"
                                              data-placement="bottom"
                                              title="Add to favorites!"></button>
                                    </div>
                                </form>
                            <?php } 
                            
                            if(is_userLoggedIn() && personInList($personID)) { ?>
                                <form action="<?php $_PHP_SELF ?>" method="POST">
                                    <div class="checkbox">
                                        <label><input id="$cb-remove" name="$cb-remove" type="checkbox" value="" checked hidden></label>
                                        <button type="submit" 
                                              style="margin-left:10px;"
                                              class="btn btn-primary glyphicon glyphicon-remove pull-right" 
                                              style="font-size:30px;"
                                              data-toggle="tooltip"
                                              data-placement="bottom"
                                              title="Remove from favorites!"></button>
                                    </div>
                                </form>
                            <?php } ?>                
                        </p>
                    </div>
                </div>
            </div>
        </div> 
        <?php if($favupdate) { ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?php echo format_person_name($person); ?></strong><?php echo ' '.$favmsg; ?>
            </div> 
        <?php } ?>   
      
        <?php if(is_admin()) { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 style="display:inline">Admin Options:</h4>
                    <a href="edit_person_addRole.php?q=<?php echo $personID; ?>&f=<?php echo $person['First']; ?>&l=<?php echo $person['Last']; ?>">
                        <button class="btn btn-warning" style="float:right;display:inline;">Add Roles</button>
                    </a>
                </div>
            </div> 
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Bio:</h4>
                <p><?php echo $person['Description']; ?>
            </div>
        </div> 
      
        </div>
    
               
        <div class="col-xs-8 col-sm-8">

            
<?php
    $query = 'SELECT `Title`, `Genre`, `Date`, `Parental Rating`, `Role`, movie.M_ID as id
              FROM `acted_in` INNER JOIN `movie` ON acted_in.M_ID = movie.M_ID
                INNER JOIN `actor` ON acted_in.A_ID = actor.A_ID
                INNER JOIN `person` ON actor.P_ID = person.P_ID
              WHERE person.P_ID = :personID;';
    $params = array(':personID' => $personID);
    $query_result = db_query($query, $params);
            
    if(!empty($query_result)) {            
?>
    <div class="panel panel-default">
        <a href="#actor-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Roles</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="actor-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/movie.php?q=<?php echo $row['id']; ?>">
                                    <?php echo $row['Title']; ?></a></td>
                                <td><?php echo 'as '.$row['Role']; ?></td>
                                <td><?php echo $row['Genre']; ?></td>
                                <td><?php echo substr($row['Date'], 0, 4); ?></td>
                                <td><?php echo '<img src='.rating_logo($row['Parental Rating']).' height="18">'; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>            
            
<?php
    $query = 'SELECT `Title`, `Genre`, `Date`, `Parental Rating`, movie.M_ID as id
              FROM `directed` INNER JOIN `movie` ON directed.M_ID = movie.M_ID
                INNER JOIN `director` ON directed.D_ID = director.D_ID
                INNER JOIN `person` ON director.P_ID = person.P_ID
              WHERE person.P_ID = :personID;';
    $params = array(':personID' => $personID);
    $query_result = db_query($query, $params);
    
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#director-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Director</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="director-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/movie.php?q=<?php echo $row['id']; ?>">
                                    <?php echo $row['Title']; ?></a></td>
                                <td><?php echo $row['Genre']; ?></td>
                                <td><?php echo substr($row['Date'], 0, 4); ?></td>
                                <td><?php echo '<img src='.rating_logo($row['Parental Rating']).' height="18">'; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
            
<?php
    $query = 'SELECT `Title`, `Genre`, `Date`, `Parental Rating`, movie.M_ID as id
              FROM `wrote` INNER JOIN `movie` ON wrote.M_ID = movie.M_ID
                INNER JOIN `writer` ON writer.W_ID = wrote.W_ID
                INNER JOIN `person` ON writer.P_ID = person.P_ID
              WHERE person.P_ID = :personID;';
    $params = array(':personID' => $personID);
    $query_result = db_query($query, $params);
    
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#writer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Writer</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="writer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/movie.php?q=<?php echo $row['id']; ?>">
                                    <?php echo $row['Title']; ?></a></td>
                                <td><?php echo $row['Genre']; ?></td>
                                <td><?php echo substr($row['Date'], 0, 4); ?></td>
                                <td><?php echo '<img src='.rating_logo($row['Parental Rating']).' height="18">'; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
            
<?php
    $query = 'SELECT `Title`, `Genre`, `Date`, `Parental Rating`, movie.M_ID as id
              FROM `composed` INNER JOIN `movie` ON composed.M_ID = movie.M_ID
                INNER JOIN `composer` ON composer.C_ID = composed.C_ID
                INNER JOIN `person` ON composer.P_ID = person.P_ID
              WHERE person.P_ID = :personID;';
    $params = array(':personID' => $personID);
    $query_result = db_query($query, $params);
    
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#composer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Composer</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="composer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/movie.php?q=<?php echo $row['id']; ?>">
                                    <?php echo $row['Title']; ?></a></td>
                                <td><?php echo $row['Genre']; ?></td>
                                <td><?php echo substr($row['Date'], 0, 4); ?></td>
                                <td><?php echo '<img src='.rating_logo($row['Parental Rating']).' height="18">'; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>            
            
<?php
    $query = 'SELECT `Title`, `Genre`, `Date`, `Parental Rating`, movie.M_ID as id
              FROM `produced` INNER JOIN `movie` ON produced.M_ID = movie.M_ID
                INNER JOIN `producer` ON producer.PR_ID = produced.PR_ID
                INNER JOIN `person` ON producer.P_ID = person.P_ID
              WHERE person.P_ID = :personID;';
    $params = array(':personID' => $personID);
    $query_result = db_query($query, $params);
    
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#producer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Producer</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="producer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/movie.php?q=<?php echo $row['id']; ?>">
                                    <?php echo $row['Title']; ?></a></td>
                                <td><?php echo $row['Genre']; ?></td>
                                <td><?php echo substr($row['Date'], 0, 4); ?></td>
                                <td><?php echo '<img src='.rating_logo($row['Parental Rating']).' height="18">'; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>            
            
            
            
        </div>
    </div>
</div>
<?php
    
    include($_INCLUDES."footer.php");

?>