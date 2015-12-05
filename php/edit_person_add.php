<?php
    include("../_include/header.php");
    if(!is_admin()) {
        header("Location: /index.php"); // Redirecting To Home Page
    }
    include($_INCLUDES."navbar.php");

    if(!empty($_POST)) {
        //test if all fields are empty
        if(empty($_POST['first']) || empty($_POST['last']) ||
           empty($_POST['date_of_birth']) || empty($_POST['description'])){
            
           echo "DOB, Description, First and Last name required. All other fields can be left blank.";
        }
        else {
            $query = "INSERT INTO movie_website_database.person (`First`, `Middle`, `Last`, `AFirst`, `ALast`, `DOB`, `Country_Of_Origin`, `Description`) 
                        VALUES (:first, :middle, :last, :Afirst, :Alast, :DOB, :country, :description)";
            $query_params = array(':first' => $_POST['first'], ':middle' => $_POST['middle'], ':last' => $_POST['last'], ':Afirst' => $_POST['Afirst'], 
                                  ':Alast' => $_POST['Alast'], ':DOB' => $_POST['date_of_birth'], ':country' => $_POST['country'], ':description' => $_POST['description']);
            
            $result = 0;
            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex) {
                
                echo "Error: '\n'";
                echo $ex;
            }
            
            if($result)
            { ?>
                <div><button type="button" class="btn btn-default"><a href="admin_page.php">Back to Admin Page</a></button><BR /><BR /></div>
                
                <?php echo die("Insert into person table successful");    
            }
        }
    }

?>

<div class="container">
  <div class="jumbotron">
    <h1>Edit Person Archive</h1>   
  </div>

    <form class="form-horizontal" role="form" method="post" action="edit_person_add.php">
        <h3><center>Add Person to database</center></h3>
      <div class="form-group">
        <label class="control-label col-sm-2" for="first">First:</label>
        <div class="col-sm-10">
          <input type=text class="form-control" name="first" placeholder="Enter First Name">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="middle">Middle:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="middle" placeholder="Enter Middle Name">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="last">Last:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="last" placeholder="Enter Last Name">
        </div>
      </div>
       <div class="form-group">
            <label class="control-label col-sm-2" for="country">Country of Origin:</label>
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
        <label class="control-label col-sm-2" for="Afirst">Alias First:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="Afirst" placeholder="Enter Alias First Name">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="Alast">Alias Last:</label>
        <div class="col-sm-10"> 
          <input type="text" class="form-control" name="Alast" placeholder="Enter Alias Last Name">
        </div>
      </div>
      <div class="form-group" id="date-selection">
            <label class="control-label col-sm-2" for="date">DoB:</label>
            <div class="control-label col-sm-10">
                <input type="text" class="form-control col-sm-3 datefield" placeholder="Enter Date of Birth" id="datefield" name="date_of_birth">
            </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="description">Description:</label>
        <div class="col-sm-10"> 
          <textarea class="form-control" rows="5" name="description" placeholder="Enter Description"></textarea>
          <!-- <input type="text" class="form-control input-lg" name="description" placeholder="Enter Description"> -->
        </div>
      </div>
      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default">Add Person to Archive</button>
        </div>
      </div>
    
    </form>
</div>

<?php
    include($_INCLUDES."footer.php");
?>