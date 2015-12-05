<?php
    include("../_include/header.php");
    if(!is_admin()) {
        header("Location: ../../index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");


    if(!empty($_POST)) {
        //test if all fields are empty
        if(empty($_POST['titleAdd']) || empty($_POST['genre']) ||
           empty($_POST['parentalrating']) || empty($_POST['date']) || empty($_POST['run_time'])){
            
           echo "Please fill out all fields";
        }
        else{
            $query = "INSERT INTO movie_website_database.movie (`Genre`, `Title`, `Date`, `Country`, `Parental Rating`, `Runtime`) 
                        VALUES (:genre, :title, :date, :country, :parental_rating, :run_time);";
            $query_params = array(':title' => $_POST['titleAdd'], ':genre' => $_POST['genre'], ':country' => $_POST['country'],
                            ':parental_rating' => $_POST['parentalrating'], ':date' => $_POST['date'], ':run_time' => $_POST['run_time']);
               
            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex) {
                
                echo "ERROR: Insert query into Movie table failed. There is an error in the query or the syntax is incorrect.";
            }
            
            if($result)
            { ?>
                <div><button type="button" class="btn btn-default"><a href="admin_page.php">Back to Admin Page</a></button><BR /><BR /></div>
                
                <?php echo die("Insert into movie table successful");    
            }
        }
    }
?>

<div class="container">
  <div class="jumbotron">
    <h1>Edit Movie Archive</h1>   
  </div>

    <form class="form-horizontal" role="form" method="post" action="edit_movie_add.php">
        <h3><center>Add movie to database</center></h3>
      <div class="form-group">
        <label class="control-label col-sm-2" for="titleAdd">Title:</label>
        <div class="col-sm-10">
          <input type="title" class="form-control" name="titleAdd" placeholder="Enter Title">
        </div>
      </div>
      <div class="form-group">
            <label class="control-label col-sm-2" for="genres">Genre:</label>
            <ul class="control-group genre-checkbox-group col-sm-10" id="genres">
                <li><input type="radio" name="genre" id="radio1" value="Action" style="margin-right: 7px;"/><label for="radio1">Action</label></li> 
                <li><input type="radio" name="genre" id="radio2" value="Adventure" style="margin-right: 7px;"/><label for="radio2">Adventure</label></li> 
                <li><input type="radio" name="genre" id="radio3" value="Adventure" style="margin-right: 7px;"/><label for="radio3">Animation</label></li> 
                <li><input type="radio" name="genre" id="radio4" value="Biography" style="margin-right: 7px;"/><label for="radio4">Biography</label></li> 
                <li><input type="radio" name="genre" id="radio5" value="Comedy" style="margin-right: 7px;"/><label for="radio5">Comedy</label></li> 
                <li><input type="radio" name="genre" id="radio6" value="Crime" style="margin-right: 7px;"/><label for="radio6">Crime</label></li> 
                <li><input type="radio" name="genre" id="radio7" value="Documentary" style="margin-right: 7px;"/><label for="radio7">Documentary</label></li> 
                <li><input type="radio" name="genre" id="radio8" value="Drama" style="margin-right: 7px;"/><label for="radio8">Drama</label></li> 
                <li><input type="radio" name="genre" id="radio9" value="Fantasy" style="margin-right: 7px;"/><label for="radio9">Fantasy</label></li> 
                <li><input type="radio" name="genre" id="radio10" value="Horror" style="margin-right: 7px;"/><label for="radio10">Horror</label></li>
                <li><input type="radio" name="genre" id="radio11" value="Musical" style="margin-right: 7px;"/><label for="radio11">Musical</label></li>
                <li><input type="radio" name="genre" id="radio12" value="Mystery" style="margin-right: 7px;"/><label for="radio12">Mystery</label></li>
                <li><input type="radio" name="genre" id="radio13" value="Romance" style="margin-right: 7px;"/><label for="radio13">Romance</label></li>
                <li><input type="radio" name="genre" id="radio14" value="Science Fiction" style="margin-right: 7px;"/><label for="radio14">Sci-Fi</label></li>
                <li><input type="radio" name="genre" id="radio15" value="Sports" style="margin-right: 7px;"/><label for="radio15">Sports</label></li>
                <li><input type="radio" name="genre" id="radio16" value="Thriller" style="margin-right: 7px;"/><label for="radio16">Thriller</label></li>
                <li><input type="radio" name="genre" id="radio17" value="War" style="margin-right: 7px;"/><label for="radio17">War</label></li>
                <li><input type="radio" name="genre" id="radio18" value="Western" style="margin-right: 7px;"/><label for="radio18">Western</label></li>
            </lu>
      </div>
      <div class="form-group">
            <label class="control-label col-sm-2" for="parental-rating">MPAA Rating:</label>
            <ul class="control-group parental-rating-checkbox-group col-sm-10" id="parental-rating">
                <li><input type="radio" name="parentalrating" id="radio19" value="G" style="margin-right: 7px;"/>
                    <label for="radio19">
                        <img src=<?php echo rating_logo("G"); ?> alt="G" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="radio" name="parentalrating" id="radio20" value="PG" style="margin-right: 7px;"/>
                    <label for="radio20">
                        <img src=<?php echo rating_logo("PG"); ?> alt="PG" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="radio" name="parentalrating" id="radio21" value="PG-13" style="margin-right: 7px;"/>
                    <label for="radio21">
                        <img src=<?php echo rating_logo("PG-13"); ?> alt="PG-13" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="radio" name="parentalrating" id="radio22" value="R" style="margin-right: 7px;"/>
                    <label for="radio22">
                        <img src=<?php echo rating_logo("R"); ?> alt="R" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="radio" name="parentalrating" id="radio23" value="NC-17" style="margin-right: 7px;"/>
                    <label for="radio23">
                        <img src=<?php echo rating_logo("NC-17"); ?> alt="NC-17" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="radio" name="parentalrating" id="radio23" value="NR" style="margin-right: 7px;"/>
                    <label for="radio23">
                        <img src=<?php echo rating_logo("NR"); ?> alt="Not Rated" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
            </ul>
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
      <div class="form-group" id="date-selection">
            <label class="control-label col-sm-2" for="date">Date:</label>
            <div class="control-label col-sm-10">
                <input type="text" class="form-control col-sm-3 datefield" placeholder="Enter date" id="datefield" name="date">
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
</div>


<?php
    include($_INCLUDES."footer.php");
?>