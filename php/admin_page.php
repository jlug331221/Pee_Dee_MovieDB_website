<?php
    include("../_include/header.php");
    if(!is_admin()) {
        header("Location: /index.php");
    }
    include($_INCLUDES."navbar.php");

    echo "<link rel='stylesheet' type='text/css' href='../css/Admin.css' />";
    
?>

<div class="container">
  <div class="jumbotron">
    <h1>Admin Page</h1>   
  </div>

  <div><button type="button" class="btn btn-default"><a href = "edit_movie_add.php">Add to Movie Archive</a></button><BR /><BR /></div>
  <div><button type="button" class="btn btn-default"><a href = "edit_movie_delete.php">Delete from Movie Archive</a></button><BR /><BR /></div>
  <div><button type="button" class="btn btn-default"><a href = "edit_person_add.php">Add to Person Archive</a></button><BR /><BR /></div>
  <div><button type="button" class="btn btn-default"><a href = "edit_person_delete.php">Delete from Person Archive</a></button><BR /><BR /></div>

</div>


<?php
    include($_INCLUDES."footer.php");
?>