<?php
    include("../_include/header.php");
    if(!is_userLoggedIn()) {
        header("Location: /index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");
?>

<?php 
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
          $results = array();
          $row = $stmt->fetch();
          array_push($results, $row);
          $ML_ID = $results[0]['ML_ID'];           
      }

      $query = "SELECT *
                FROM contains_movie CM JOIN movie M
                ON CM.M_ID = M.M_ID JOIN image I
                ON M.I_ID = I.I_ID
                WHERE CM.ML_ID = :MLID"; 
      $query_params = array(':MLID' => $ML_ID); 

      try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex) {        
        echo $ex;
      }  

      if($result)
      {
          $movie_list_results = array();
          while($row = $stmt->fetch()) {
              array_push($movie_list_results, $row);
          }
      }

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
          $results = array();
          $row = $stmt->fetch();
          array_push($results, $row);
          $PL_ID = $results[0]['PL_ID'];           
      }

      $query = "SELECT *
                FROM contains_person CP JOIN person P
                ON CP.P_ID = P.P_ID JOIN image I
                ON P.I_ID = I.I_ID
                WHERE CP.PL_ID = :PLID"; 
      $query_params = array(':PLID' => $PL_ID); 

      try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
      }
      catch(PDOException $ex) {        
        echo $ex;
      }  

      if($result)
      {
          $person_list_results = array();
          while($row = $stmt->fetch()) {
              array_push($person_list_results, $row);
          }
      }
?>



<!--Need to change where and how the image is sourced... (do not use url, save as .jpg somewhere)
    The <a href tag can reference another php page when clicked. 
    Need to determine how to link to particular movie when clicked, entire thumbnail clickable.--> 

<!-- Use CSS to change background of jumbrotron - can use image as background or just change colors. -->


<div class="container">
    <h1 style="margin-bottom:15px;">Welcome, <i><?php echo $_SESSION['email'];?></i>! </h1>
    
  <div class="jumbotron jumbotron-special">
    <h1>My Favorite Movies</h1>
  </div>
    <?php
        foreach($movie_list_results as $movie) {
            ?>
            
            <div class="row-fluid">
                <div class="col-md-3">
                <a href="movie.php?q=<?php echo $movie['M_ID']; ?>" class="thumbnail">
                    <p><center><?php echo $movie['Title']; ?></center></p>
                    <img src="data:<?php echo $movie['Image_type']; ?>; base64,<?php echo base64_encode($movie['Image']); ?>" 
                         alt="<?php echo $movie['Title']; ?>" style="width:350px;height:400px;">
                </a>
                </div>
            </div>
    
            <?php
        }
    ?>
</div>

<div class="container">
  <div class="jumbotron jumbotron-special">
    <h1>My Favorite People in Movies</h1>
  </div>
    <?php
        foreach($person_list_results as $person) {
            ?>
            
            <div class="row-fluid">
                <div class="col-md-3">
                <a href="person.php?q=<?php echo $person['P_ID']; ?>" class="thumbnail">
                    <p><center><?php echo $person['First'].' '.$person['Last']; ?></center></p>
                    <img src="data:<?php echo $person['Image_type']; ?>; base64,<?php echo base64_encode($person['Image']); ?>" 
                         alt="<?php echo $person['First'].' '.$person['Last']; ?>" style="width:350px;height:400px;">
                </a>
                </div>
            </div>
    
            <?php
        }
    ?>
</div>

<?php
    include($_INCLUDES."footer.php");
?>