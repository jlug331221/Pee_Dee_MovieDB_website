<?php
    include("/Database_Website/_include/header.php");
    include($_INCLUDES."navbar.php");
?>


<div class="jumbotron">
  <div class="container">
      <h1>Welcome to Pee Dee's Movie Database!</h1>
      
  <div class="row equal">
    <div class="col-xs-6 col-sm-4">
        <h3 align="center" style ="color:#592A8A">Welcome to Pee Dee's collection of movie data.</h3>
        <p>Feel free to search our database for information regarding movies and the personnel involved in them. </p> 
        
    </div>

    <div class="col-xs-6 col-sm-4">
        <h3 align="center" style ="color:#592A8A">Random Movie to See Today!  <span class="glyphicon glyphicon-film"></span></h3>
        <p>Check out this movie... </p>
        
<?php 
      $query = 'SELECT * 
                FROM movie M join image I
                ON M.I_ID = I.I_ID 
                ORDER BY RAND()
                LIMIT 1';


    $results = db_query($query, NULL);
    
    $randIndex = rand(0,count($results, 0));
    $movieID = $results[0]['M_ID'];
    
    echo '<dt align="center"><strong>Movie Poster:</strong></dt><dd>'
     . '<img class="center-block" src="data:image/jpeg;base64,' . base64_encode($results[0]['Image']) . '" width="300" height="450">'
     . '</dd>';
?>
    <a href="/Database_Website/php/movie.php?q=<?php echo $movieID; ?>"><h4 align="center">Title: <?php echo $results[0]['Title']; ?>      
    </h4></a>
    <h4 align="center">Genre: <?php echo $results[0]['Genre']; ?></h4>
    <h4 align="center">Date Released: <?php echo $results[0]['Date']; ?></h4>
    <h4 align="center">Rating: <?php echo $results[0]['Parental Rating']; ?></h4>
    
    </div>
        



    <div class="col-xs-6 col-sm-4">
        <h3 align="center" style ="color:#592A8A">Create an account today.  <span class="glyphicon glyphicon-user"></span></h3>
                
        <p>With an account to Pee Dee's Movie Database, you will have the ability to create
           lists of your favorite movies, actors, or directors.</p>
        <?php
 
        if(!is_userLoggedIn())
        {
        ?>
          <p><a class="btn btn-warning btn-lg2" href="/Database_Website/php/registration.php" role="button" >Register now!</a></p>
        <?php
        }
        ?>
        
    </div>

  </div>      
      
      
  </div>
  
</div>



<?php
    include($_INCLUDES."footer.php");
?>

















