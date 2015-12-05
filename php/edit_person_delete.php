<?php
    include("../_include/header.php");
    if(!is_admin()) {
        header("Location: /index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");


    if(!empty($_POST)) {
        if(empty($_POST['firstNameDelete']) || empty($_POST['lastNameDelete'])) {
            
           echo "Please fill out both fields.";
        }
        else {
            $query = "DELETE 
                        FROM movie_website_database.person 
                        WHERE First = :first and Last = :last";
            $query_params = array(':first' => $_POST['firstNameDelete'], ':last' => $_POST['lastNameDelete']);
            
            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex) {
                
                echo "ERROR: ";
                echo $ex;
            }
            
            if($result)
            { ?>
                <div><button type="button" class="btn btn-default"><a href="admin_page.php">Back to Admin Page</a></button><BR /><BR /></div>
                
                <?php echo die("Delete from person table successful");    
            }
        }
    }
?>

<div class="container">
  <div class="jumbotron">
    <h1>Edit Person Archive</h1>   
  </div>

    <form class="form-horizontal" role="form" method="post" action="edit_person_delete.php">
        <h3><center>Remove person from database</center></h3>
    
      <div class="form-group">
        <label class="control-label col-sm-2" for="firstNameDelete">First:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="firstNameDelete" placeholder="Enter First Name">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="lastNameDelete">Last:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="lastNameDelete" placeholder="Enter Last Name">
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