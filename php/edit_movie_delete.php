<?php
    include("../_include/header.php");
    if(!is_admin()) {
        header("Location: /index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");


    if(!empty($_POST)) {
        //test if all fields are empty
        if(empty($_POST['titleDelete'])) {
            
           echo "Please fill out the title field.";
        }
        else {
            $query = "DELETE 
                        FROM movie_website_database.movie 
                        WHERE Title = :title;";
            $query_params = array(':title' => $_POST['titleDelete']);
            
            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex) {
                
                echo "ERROR: Delete from movie table failed. There is an error in the query or the syntax is incorrect.";
            }
            
            if($result)
            { ?>
                <div><button type="button" class="btn btn-default"><a href="admin_page.php">Back to Admin Page</a></button><BR /><BR /></div>
                
                <?php echo die("Delete from movie table successful");    
            }
        }
    }
?>

<div class="container">
  <div class="jumbotron">
    <h1>Edit Movie Archive</h1>   
  </div>

    <form class="form-horizontal" role="form" method="post" action="edit_movie_delete.php">
        <h3><center>Delete from database</center></h3>
    
      <div class="form-group">
        <label class="control-label col-sm-2" for="title">Title:</label>
        <div class="col-sm-10">
          <input type="title" class="form-control" name="titleDelete" placeholder="Enter Title">
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Delete Movie from Archive</button>
        </div>
      </div>
    
    </form>
</div>


<?php
    include($_INCLUDES."footer.php");
?>