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

    if(isset($_POST['adv-movie-search'])) {
        $url = '';
        $urlarray = array();
        $error = false;
        $errormsg = '';
        if(invalid_runtime($_POST['runtimemin']) || invalid_runtime($_POST['runtimemax'])) {
            $error = true;
            $errormsg = 'Cannot understand those runtimes! Please try again.';
        }
        else {
            if(isset($_POST['title']) && !empty($_POST['title'])) {
                $urlarray['title'] = $_POST['title'];
            }
            if(isset($_POST['country']) && !empty($_POST['country'])) {
                $urlarray['country'] = $_POST['country'];
            }
            if(isset($_POST['genre']) && !empty($_POST['genre'])) {
                $urlarray['genre'] = $_POST['genre'];
            }
            if(isset($_POST['parentalrating']) && !empty($_POST['parentalrating'])) {
                $urlarray['pr'] = $_POST['parentalrating'];
            }
            if(isset($_POST['runtimemin']) && !empty($_POST['runtimemin'])) {
                $urlarray['rtmin'] = $_POST['runtimemin'];
            }
            if(isset($_POST['runtimemax']) && !empty($_POST['runtimemax'])) {
                $urlarray['rtmax'] = $_POST['runtimemax'];
            }
            if(isset($_POST['startdate']) && !empty($_POST['startdate'])) {
                $urlarray['startdate'] = $_POST['startdate'];
            }
            if(isset($_POST['enddate']) && !empty($_POST['enddate'])) {
                $urlarray['enddate'] = $_POST['enddate'];
            }
            $url = $url.http_build_query($urlarray);
            header('Location: /Database_Website/php/advanced_movie_search.php?'.$url);
        }
    }
?>

<?php 
  if(!$_GET) { 
?>

<div class="container">
    <h1>Advanced Movie Search</h1>
    
    <?php if($error) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> <?php echo $errormsg; ?>
        </div>
    <?php } ?>
    
    <form class="form-horizontal" role="form" id="advanced-movie-form" method="POST" >
        <div class="form-group">
            <label class="control-label col-sm-1" for="title">Title:</label>
            <div class="control-label col-sm-6">
                <input type="text" class="form-control col-sm-7" id="title" placeholder="Enter title" name="title">
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
            <label class="control-label col-sm-1" for="genres">Genre:</label>
            <ul class="control-group genre-checkbox-group col-sm-5" id="genres">
                <li><input type="checkbox" name="genre[]" id="cb1" value="Action" style="margin-right: 7px;"/><label for="cb1">Action</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb2" value="Adventure" style="margin-right: 7px;"/><label for="cb2">Adventure</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb3" value="Adventure" style="margin-right: 7px;"/><label for="cb3">Animation</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb4" value="Biography" style="margin-right: 7px;"/><label for="cb4">Biography</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb5" value="Comedy" style="margin-right: 7px;"/><label for="cb5">Comedy</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb6" value="Crime" style="margin-right: 7px;"/><label for="cb6">Crime</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb7" value="Documentary" style="margin-right: 7px;"/><label for="cb7">Documentary</label></li> 
                <li><input type="checkbox" name="genre[]" name="genre[]" id="cb8" value="Drama" style="margin-right: 7px;"/><label for="cb8">Drama</label></li> 
                <li><input type="checkbox" name="genre[]" id="cb9" value="Fantasy" style="margin-right: 7px;"/><label for="cb9">Fantasy</label></li> 
                <li><input type="checkbox" name="genre[]" name="genre[]" id="cb10" value="Horror" style="margin-right: 7px;"/><label for="cb10">Horror</label></li>
                <li><input type="checkbox" name="genre[]" id="cb11" value="Musical" style="margin-right: 7px;"/><label for="cb11">Musical</label></li>
                <li><input type="checkbox" name="genre[]" id="cb12" value="Mystery" style="margin-right: 7px;"/><label for="cb12">Mystery</label></li>
                <li><input type="checkbox" name="genre[]" name="genre[]" id="cb13" value="Romance" style="margin-right: 7px;"/><label for="cb13">Romance</label></li>
                <li><input type="checkbox" name="genre[]" id="cb14" value="Science Fiction" style="margin-right: 7px;"/><label for="cb14">Sci-Fi</label></li>
                <li><input type="checkbox" name="genre[]" id="cb15" value="Sports" style="margin-right: 7px;"/><label for="cb15">Sports</label></li>
                <li><input type="checkbox" name="genre[]" name="genre[]" id="cb16" value="Thriller" style="margin-right: 7px;"/><label for="cb16">Thriller</label></li>
                <li><input type="checkbox" name="genre[]" id="cb17" value="War" style="margin-right: 7px;"/><label for="cb17">War</label></li>
                <li><input type="checkbox" name="genre[]" id="cb18" value="Western" style="margin-right: 7px;"/><label for="cb18">Western</label></li>
            </ul>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-1" for="parental-rating">MPAA Rating:</label>
            <ul class="control-group parental-rating-checkbox-group col-sm-11" id="parental-rating">
                <li><input type="checkbox" name="parentalrating[]" id="cb19" value="G" style="margin-right: 7px;"/>
                    <label for="cb19">
                        <img src=<?php echo rating_logo("G"); ?> alt="G" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="checkbox" name="parentalrating[]" id="cb20" value="PG" style="margin-right: 7px;"/>
                    <label for="cb20">
                        <img src=<?php echo rating_logo("PG"); ?> alt="PG" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="checkbox" name="parentalrating[]" id="cb21" value="PG-13" style="margin-right: 7px;"/>
                    <label for="cb21">
                        <img src=<?php echo rating_logo("PG-13"); ?> alt="PG-13" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="checkbox" name="parentalrating[]" id="cb22" value="R" style="margin-right: 7px;"/>
                    <label for="cb22">
                        <img src=<?php echo rating_logo("R"); ?> alt="R" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="checkbox" name="parentalrating[]" id="cb23" value="NC-17" style="margin-right: 7px;"/>
                    <label for="cb23">
                        <img src=<?php echo rating_logo("NC-17"); ?> alt="NC-17" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
                <li><input type="checkbox" name="parentalrating[]" id="cb23" value="NR" style="margin-right: 7px;"/>
                    <label for="cb23">
                        <img src=<?php echo rating_logo("NR"); ?> alt="Not Rated" style="height:22px;margin-right:11px;">
                    </label>
                </li> 
            </ul>
        </div>
        
        <div class="form-group" id="runtime-form-group">
            <label class="control-label col-sm-1" for="runtime">Runtime:</label>
            <div class="control-label col-sm-1">
                <input type="text" class="form-control col-sm-1 inline" id="runtimemin" placeholder="Min" name="runtimemin">
                <div class="help text-left"></div>
            </div>  
            <div class="control-label col-sm-1">
                <input type="text" class="form-control col-sm-1 inline" id="runtimemax" placeholder="Max" name="runtimemax">
                <div class="help text-left"></div>
            </div>  
        </div>
        
        <div class="form-group" id="date-selection">
            <label class="control-label col-sm-1" for="date">Date:</label>
            <div class="control-label col-sm-2">
                <input type="text" class="form-control col-sm-2 datefield" placeholder="Start date" id="datefield" name="startdate">
            </div>
            <div class="control-label col-sm-2">
                <input type="text" class="form-control col-sm-2 datefield" placeholder="End date" id="datefield" name="enddate">
            </div>
        </div>
        
        <button type="submit" name="adv-movie-search" class="btn btn-default" id="adv-movie-search-btn">Submit</button>
    </form>
</div> 

<?php
  } else {

      $query = 'SELECT `M_ID` as id, `image`, `Title`, `Country`, `Genre`, `Date`, `Parental Rating`, `Runtime` FROM movie LEFT JOIN image ON movie.I_ID = image.I_ID WHERE ';
      $params = array();
      $querystr = '';
      if($_GET['title'])
      {
          $query .= '(`Title` like :title) and ';
          $params[':title'] = "%".$_GET['title']."%";
          $querystr .= 'Title is '.$_GET['title'].' / ';
      }
      if($_GET['country'])
      {
          $query .= '(`Country` = :country) and ';
          $params[':country'] = $_GET['country'];
          $querystr .= 'Location of movie is '.$_GET['country'].' / ';
      }
      if($_GET['genre'])
      {
          $clause = '(';
          $length = count($_GET['genre']);
          $querystr .= 'Genre includes ';
          for($i = 0; $i < $length; $i += 1)
          {
              $clause .= '`Genre` like :genre'.$i.' or ';
              $params[':genre'.$i] = "%".$_GET['genre'][$i]."%";
              $querystr .= $_GET['genre'][$i].', ';
          }        
          $clause = rtrim($clause, ' or ');
          $query .= $clause.') and ';
          $querystr = rtrim($querystr, ', ');
          $querystr .= ' / ';
      }
      if($_GET['pr'])
      {
          $clause = '(';
          $length = count($_GET['pr']);
          $querystr .= 'Parental Rating includes ';
          for($i = 0; $i < $length; $i += 1)
          {
              $clause .= '`Parental Rating` = :pr'.$i.' or ';
              $params[':pr'.$i] = $_GET['pr'][$i];
              $querystr .= $_GET['pr'][$i].', ';
          }        
          $clause = rtrim($clause, ' or ');
          $query .= $clause.') and ';
          $querystr = rtrim($querystr, ', ');
          $querystr .= ' / ';
      }
      if($_GET['rtmin'])
      {
          $query .= '(`Runtime` >= :rtmin) and ';
          $params[':rtmin'] = $_GET['rtmin'];
          $querystr .= 'Minimum runtime is '.$_GET['rtmin'].' minutes / ';
      }
      if($_GET['rtmax'])
      {
          $query .= '(`Runtime` <= :rtmax) and ';
          $params[':rtmax'] = $_GET['rtmax'];
          $querystr .= 'Maximum runtime is '.$_GET['rtmax'].' minutes / ';
      }
      if($_GET['startdate'])
      {
          $query .= '(`Date` >= :datemin) and ';
          $params[':datemin'] = $_GET['startdate'];
          $querystr .= 'Released after '.$_GET['startdate'].' / ';
      }
      if($_GET['enddate'])
      {
          $query .= '(`Date` <= :datemax) and ';
          $params[':datemax'] = $_GET['enddate'];
          $querystr .= 'Released before '.$_GET['enddate'].' / ';
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
    <a href="/Database_Website/php/advanced_movie_search.php">
        <button class="btn btn-default" style="display: inline; float: right;">Back to advanced search</button>
    </a>
    <div class="well">
        <?php echo $querystr; ?>
    </div>
    
    <table class="table table-striped adv-table-results" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Movie</th>
                <th>Country</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Parental Rating</th>
                <th>Runtime</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Movie</th>
                <th>Country</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Parental Rating</th>
                <th>Runtime</th>
            </tr>
        </tfoot>     
        <tbody>
            <?php foreach($results as $row) { ?>
                <tr>
                    <td style="vertical-align:middle;">
                        <?php echo '<a href="/Database_Website/php/movie.php?q='.$row['id'].'">';
                            if(!$row['image'])
                            {
                                echo '<img class="center-block" src="/Database_Website/images/nullicon.png" style="display:inline; margin-right: 4px;">';
                            }
                            else 
                            {
                                echo '<img class="center-block" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" height="40" width="30" style="display:inline; margin-right: 7px;">';
                            }
                            echo $row['Title']; 
                            echo '</a>'
                        ?>
                    </td>
                    <td style="vertical-align:middle;"><?php echo $row['Country']; ?></td>
                    <td style="vertical-align:middle;"><?php echo $row['Genre']; ?></td>
                    <td style="vertical-align:middle;"><?php echo substr($row['Date'], 0, 4); ?></td>
                    <td style="vertical-align:middle;">
                        <?php 
                            echo '<img class="center-block" src='.rating_logo($row['Parental Rating']).' height="15">';
                            echo '<span hidden>'.$row['Parental Rating'].'</span>';
                        ?>
                    </td>
                    <td style="vertical-align:middle;"><?php echo $row['Runtime'].' minutes'; ?></td>
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



































