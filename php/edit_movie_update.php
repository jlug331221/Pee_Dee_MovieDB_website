<?php
    include("../_include/header.php");
    if(!is_userLoggedIn()) {
        header("Location: ../../index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");
?>

    <form class="form-horizontal" role="form" method="post" action="edit_movie_update.php">
        <h3><center>Edit movie in database</center></h3>
      <div class="form-group">
        <label class="control-label col-sm-2" for="titleAdd">Title:</label>
        <div class="col-sm-10">
          <input type="title" class="form-control" name="titleAdd" placeholder="Edit Title">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="genre">Genre:</label>
        <div class="col-sm-10"> 
          <input type="genre" class="form-control" name="genre" placeholder="Enter Genre">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="parental_rating">Parental Rating:</label>
        <div class="col-sm-10"> 
          <input type="parental_rating" class="form-control" name="parental_rating" placeholder="Enter Parental Rating">
        </div>
      </div>
       <div class="form-group">
            <label class="control-label col-sm-2" for="country">Country:</label>
            <div class="control-label col-sm-10">
                <select class="input-medium form-control" name="country">
                    <?php 
                        $countries = countries_array();
                        foreach($countries as $country)
                        {
                            echo "<option>".$country."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="date">Date:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="date" placeholder="Enter Date 'yyyy-mm-dd'">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="run_time">Runtime:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="run_time" placeholder="Enter Runtime">
        </div>
      </div>    
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Add Movie to Archive</button>
        </div>
      </div>
    
    </form>

<?php
    include($_INCLUDES."footer.php");
?>