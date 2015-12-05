<?php
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");

    $movieID = $_GET['q'];
    $query = 'SELECT * 
                FROM movie M LEFT JOIN image I 
                on M.I_ID = I.I_ID 
                WHERE M.M_ID = :movieID';
    $params = array(':movieID' => $movieID);

    try {
        $stmt = $_DBCONTEXT->prepare($query);
        $result = $stmt->execute($params);
    }
    catch(PDOException $ex) {
        echo 'Error: image/movie query';
    }

    $results = array();
    $row = $stmt->fetch();
    array_push($results, $row);

    $favupdate = false;
    $favmsg = ''; 
        
    if(isset($_POST['$cb'])) 
    {
      $query = "SELECT ML_ID 
                FROM movie_list M join compiles C
                on M.L_ID = C.L_ID
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
          $ML_ID = $row['ML_ID'];           
      }
        
     $query = "INSERT INTO movie_website_database.contains_movie (`M_ID`, `ML_ID`) VALUES (:movID, :MLID)";
     $query_params = array(':movID' => $movieID, ':MLID' => $ML_ID);
       
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
        $favmsg = " was added to your favorites list!";  
      }        
    }            
        
    if(isset($_POST['$cb-delete'])) 
    {
      $query = "SELECT ML_ID 
                FROM movie_list M join compiles C
                on M.L_ID = C.L_ID
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
          $ML_ID = $row['ML_ID'];           
      }
        
     $query = "DELETE FROM contains_movie WHERE `M_ID` = :movID and `ML_ID` = :MLID";
     $query_params = array(':movID' => $movieID, ':MLID' => $ML_ID);
       
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
        $favmsg = " was removed from your favorites list!";  
      }        
    }
        
?>
<div class="container">
       
    
    
    <div class="row equal">
        <div class="col-xs-4 col-sm-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="thumbnail">
                        <img src="data:<?php echo $results[0]['Image_type']; ?>; base64,<?php echo base64_encode($results[0]['Image']); ?>" 
                                 alt="<?php echo $results[0]['Title']; ?>" style="width:300;height:450px;">
                        <div class="caption">
                            <h3><?php echo $results[0]['Title']; ?></h3>
                            <p><?php echo $results[0]['Genre']; ?> | <?php echo '<img src='.rating_logo($results[0]['Parental Rating']).' height="18">'; ?></p>
                            <p style="display:block">Released: <?php echo $results[0]['Date']; 
                                if(is_userLoggedIn() && !movieInList($movieID)) { ?>
                                    <form action="<?php $_PHP_SELF ?>" method="POST">
                                        <div class="checkbox" >
                                          <label>
                                            <input id="$cb" name="$cb" type="checkbox" value="" checked hidden>
                                          </label>
                                              <button type="submit" 
                                                      style="font-size:18px;"   
                                                      class="btn btn-primary glyphicon glyphicon-heart pull-right" 
                                                      data-toggle="tooltip"
                                                      data-placement="bottom"
                                                      title="Add to favorites!"></button>
                                        </div>
                                    </form>
                                <?php }

                                if(is_userLoggedIn() && movieInList($movieID)) { ?>
                                    <form action="<?php $_PHP_SELF ?>" method="POST">
                                        <div class="checkbox">
                                          <label>
                                            <input id="$cb-delete" name="$cb-delete" type="checkbox" value="" checked hidden>
                                          </label>
                                              <button type="submit" 
                                                      style="font-size:18px;"
                                                      class="btn btn-primary glyphicon glyphicon-remove pull-right"
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
                <strong><?php echo $results[0]['Title']; ?></strong><?php echo ' '.$favmsg; ?>
            </div> 
        <?php } ?>
    </div>
    <div class="col-xs-8 col-sm-8">
        
        
<?php
    $query = 'SELECT `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, person.P_ID as id
              FROM person INNER JOIN director ON person.P_ID = director.P_ID 
                INNER JOIN directed on director.D_ID = directed.D_ID 
                INNER JOIN movie on directed.M_ID = movie.M_ID
              WHERE movie.M_ID = :movieID';
    $params = array(':movieID' => $movieID);
    $query_result = db_query($query, $params);
        
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#director-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Directors</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="director-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/person.php?q=<?php echo $row['id']; ?>">
                                    <?php echo format_person_name($row); ?></a></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>  
<?php } ?>
        

<?php
    $query = 'SELECT `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, `Role`, person.P_ID as id
              FROM `acted_in` INNER JOIN `movie` ON acted_in.M_ID = movie.M_ID
                INNER JOIN `actor` ON acted_in.A_ID = actor.A_ID
                INNER JOIN `person` ON actor.P_ID = person.P_ID
              WHERE movie.M_ID = :movieID;';
    $params = array(':movieID' => $movieID);
    $query_result = db_query($query, $params);
        
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#actor-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Actors</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse in" id="actor-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/person.php?q=<?php echo $row['id']; ?>">
                                    <?php echo format_person_name($row); ?></a></td>
                                <td><?php echo '... '.$row['Role']; ?></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
        
        
<?php
    $query = 'SELECT `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, person.P_ID as id
              FROM person INNER JOIN writer ON person.P_ID = writer.P_ID 
                INNER JOIN wrote ON wrote.W_ID = writer.W_ID
                INNER JOIN movie ON wrote.M_ID = movie.M_ID
              WHERE movie.M_ID = :movieID';
    $params = array(':movieID' => $movieID);
    $query_result = db_query($query, $params);
        
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#writer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Writers</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse" id="writer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/person.php?q=<?php echo $row['id']; ?>">
                                    <?php echo format_person_name($row); ?></a></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>     
<?php } ?>
        
        
<?php
    $query = 'SELECT `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, person.P_ID as id
              FROM person INNER JOIN composer ON person.P_ID = composer.P_ID 
                INNER JOIN composed ON composed.C_ID = composer.C_ID
                INNER JOIN movie ON composed.M_ID = movie.M_ID
              WHERE movie.M_ID = :movieID';
    $params = array(':movieID' => $movieID);
    $query_result = db_query($query, $params);
        
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#composer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Composers</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse" id="composer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/person.php?q=<?php echo $row['id']; ?>">
                                    <?php echo format_person_name($row); ?></a></td>
                            </tr> <?php
                        } ?>
                </tbody>
            </table>
        </div>
    </div>  
<?php } ?>
        
        
<?php
    $query = 'SELECT `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, person.P_ID as id
              FROM person INNER JOIN producer ON person.P_ID = producer.P_ID 
                INNER JOIN produced ON produced.PR_ID = producer.PR_ID
                INNER JOIN movie ON produced.M_ID = movie.M_ID
              WHERE movie.M_ID = :movieID';
    $params = array(':movieID' => $movieID);
    $query_result = db_query($query, $params);
        
    if(!empty($query_result)) {
?>
    <div class="panel panel-default">
        <a href="#producer-panel" data-toggle="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Producers</h2>
            </div>
        </a>
        <div class="panel-body panel-collapse collapse" id="producer-panel">
            <table class="table">
                <tbody>
                    <?php
                        foreach($query_result as $row) { ?>
                            <tr>
                                <td><a href="/Database_Website/php/person.php?q=<?php echo $row['id']; ?>">
                                    <?php echo format_person_name($row); ?></a></td>
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
