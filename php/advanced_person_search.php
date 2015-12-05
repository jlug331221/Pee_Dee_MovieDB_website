<?php 
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");

    function invalid_runtime($runtime) {
        if(isset($runtime) && !empty($runtime) && (!is_numeric($runtime) || floatval($runtime) < 0)) {
            return true;
            break;
        }
        return false;
    }

    if(isset($_POST['adv-person-search'])) {
        $url = '';
        $urlarray = array();
        $error = false;
        $errormsg = '';
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            $urlarray['name'] = $_POST['name'];
        }
        if(isset($_POST['country']) && !empty($_POST['country'])) {
            $urlarray['country'] = $_POST['country'];
        }
        if(isset($_POST['role']) && !empty($_POST['role'])) {
            $urlarray['role'] = $_POST['role'];
        }
        if(isset($_POST['dobstart']) && !empty($_POST['dobstart'])) {
            $urlarray['dobstart'] = $_POST['dobstart'];
        }
        if(isset($_POST['dobend']) && !empty($_POST['dobend'])) {
            $urlarray['dobend'] = $_POST['dobend'];
        }
        $url = $url.http_build_query($urlarray);
        header('Location: /Database_Website/php/advanced_person_search.php?'.$url);
    }
?>

<?php 
  if(!$_GET) { 
?>

<div class="container">
    <h1>Advanced Person Search</h1>
    
    <?php if($error) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> <?php echo $errormsg; ?>
        </div>
    <?php } ?>
    
    <form class="form-horizontal" role="form" id="advanced-person-form" method="POST" >
        <div class="form-group">
            <label class="control-label col-sm-1" for="name">Name:</label>
            <div class="control-label col-sm-6">
                <input type="text" class="form-control col-sm-7" id="title" placeholder="Enter name" name="name">
            </div>  
        </div>

        <div class="form-group">
            <label class="control-label col-sm-1" for="country">Country:</label>
            <div class="control-label col-sm-6">
                <select class="input-medium form-control" id="country" placeholder="Select a country" name="country">
                    <option></option>
                    <?php 
                        $countries = countries_array();
                        foreach($countries as $country) {
                            echo "<option>".$country."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-1" for="roles">Roles:</label>
            <ul class="control-group genre-checkbox-group col-sm-5" id="roles">
                <li><input type="checkbox" name="role[]" id="cb1" value="actor" style="margin-right: 7px;"/><label for="cb1">Actor</label></li> 
                <li><input type="checkbox" name="role[]" id="cb2" value="director" style="margin-right: 7px;"/><label for="cb2">Director</label></li> 
                <li><input type="checkbox" name="role[]" id="cb3" value="composer" style="margin-right: 7px;"/><label for="cb3">Composer</label></li>
                <li><input type="checkbox" name="role[]" id="cb4" value="write" style="margin-right: 7px;"/><label for="cb4">Writer</label></li>
                <li><input type="checkbox" name="role[]" id="cb5" value="producer" style="margin-right: 7px;"/><label for="cb5">Producer</label></li>
            </lu>
        </div>
        
        <div class="form-group" id="date-selection">
            <label class="control-label col-sm-1" for="dob">DOB:</label>
            <div class="control-label col-sm-2">
                <input type="text" class="form-control col-sm-2 datefield" placeholder="Beginning date" id="datefield" name="dobstart">
            </div>
            <div class="control-label col-sm-2">
                <input type="text" class="form-control col-sm-2 datefield" placeholder="End date" id="datefield" name="dobend">
            </div>
        </div>
        
        <button type="submit" name="adv-person-search" class="btn btn-default" id="adv-person-search-btn">Submit</button>
    </form>
</div> 

<?php
  } else {

      $query = 'SELECT `P_ID` as id, `image`, `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, `DOB`, `Country_Of_Origin` FROM person LEFT JOIN image ON person.I_ID = image.I_ID WHERE ';
      $params = array();
      $querystr = '';
      if($_GET['name'])
      {
          $query .= '(`First` like :name or `Middle` like :name or `Last` like :name or `AFirst` like :name or `AMiddle` like :name or `ALast` like :name or `Nickname` like :name) and ';
          $params[':name'] = "%".$_GET['name']."%";
          $querystr .= 'Name is similar to '.$_GET['name'].' / ';
      }
      if($_GET['country'])
      {
          $query .= '(`Country_Of_Origin` = :country) and ';
          $params[':country'] = $_GET['country'];
          $querystr .= 'Birthplace of person is '.$_GET['country'].' / ';
      }
      if($_GET['dobstart'])
      {
          $query .= '(`DOB` >= :dobstart) and ';
          $params[':dobstart'] = $_GET['dobstart'];
          $querystr .= 'Born on or after '.$_GET['dobstart'].' / ';
      }
      if($_GET['dobend'])
      {
          $query .= '(`DOB` <= :dobend) and ';
          $params[':dobend'] = $_GET['dobend'];
          $querystr .= 'Born on or before '.$_GET['dobend'].' / ';
      }
      if($_GET['role'])
      {
          $clause = '(';
          $length = count($_GET['role']);
          $querystr .= 'Roles include ';
          for($i = 0; $i < $length; $i += 1)
          {
              $clause .= '`P_ID` in ( SELECT '.$_GET['role'][$i].'.P_ID FROM `'.$_GET['role'][$i].'` ) or ';
              $querystr .= $_GET['role'][$i].', ';
          }        
          $clause = rtrim($clause, ' or ');
          $query .= $clause.') and ';
          $querystr = rtrim($querystr, ', ');
          $querystr .= ' / ';
      }
      
      
      $querystr = rtrim($querystr, ' / ');
      $query = rtrim($query, ' and ');
      //echo nl2br($query."\n");
      //var_dump($params);
      //echo nl2br("\n");
      $results = db_query($query, $params);
      //var_dump($results);
      
?>

<div class="container">
    <h3 style="display:inline-block">Displaying results for: </h3>
    <a href="/Database_Website/php/advanced_person_search.php">
        <button class="btn btn-default" style="display: inline; float: right;">Back to advanced search</button>
    </a>
    <div class="well">
        <?php echo $querystr; ?>
    </div>
    
    <table class="table table-striped adv-table-results" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Person</th>
                <th>Country</th>
                <th>DOB</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Person</th>
                <th>Country</th>
                <th>DOB</th>
            </tr>
        </tfoot>     
        <tbody>
            <?php foreach($results as $row) { ?>
                <tr>
                    <td style="vertical-align:middle;">
                        <?php echo '<a href="/Database_Website/php/person.php?q='.$row['id'].'">';
                            if(!$row['image'])
                            {
                                echo '<img class="center-block" src="/Database_Website/images/nullicon.png" style="display:inline; margin-right: 4px;">';
                            }
                            else 
                            {
                                echo '<img class="center-block" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" height="40" width="30" style="display:inline; margin-right: 7px;">';
                            }
                            echo format_person_name($row); 
                            echo '</a>'
                        ?>
                    </td>
                    <td style="vertical-align:middle;"><?php echo $row['Country_Of_Origin']; ?></td>
                    <td style="vertical-align:middle;"><?php echo $row['DOB']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php      
  }
?>




    
<?php 
    include($_INCLUDES."footer.php"); 
?>



































