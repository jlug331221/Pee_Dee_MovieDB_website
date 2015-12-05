<?php

?> <script type="text/javascript" src="/Database_Website/js/custom.js"></script> <?php

/*
class searchResult
{
    public $result;
    public $result_type;
    public $id;
    
    public function __construct($result, $result_type, $id) {
        $this->result = $result;
        $this->result_type = $result_type;
        $this->id = $id;
    }
}
*/

function find_m_index($results){
    for($x=0; $x < count($results); $x++)
    {
        if(strcmp($results[$x]->result_type, 'm') == 0)
        {
            return $x;
            break;
        }
    }
    return count($results);
}

function display_results() {
    $search = $_GET['q'];
    $results = get_person_results($search);
    //<div class="well">
        //<?php echo $querystr; ? >
    //</div>
    
    // display person results
    ?>
    
    <div class="container">
        <h3 style="display:inline-block">People</h3>

        <table class="table table-striped adv-table-results" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Person</th>
                    <th>Country</th>
                    <th>DOB</th>
                </tr>
            </thead> 
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
    $results = get_movie_results($search);
    
    // display movie results
    ?>
    
    <div class="container">
        <h3 style="display:inline-block">Movies</h3>

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

/*function display_results() {
    $search = $_GET['q'];
    $results = get_results($search); 
    
    $m_index = find_m_index($results);
    
    if(count($results) < 1)
    {
        echo 'No Results Found!';
    }
    else
    {
        if(strcmp($results[0]->result_type, 'p') == 0)
        {
        ?>
            <div class="container">
                <h1>Results from People</h1>

                <table class="table table-striped table-bordered
                              table-condensed">
                    <thead>
                        <tr>
                            <td><b>Name</b></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        for($x = 0; $x < $m_index; $x++) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?php echo '/Database_Website/php/person.php?q='.urlencode($results[$x]->id); ?>">
                                        <?php echo $results[$x]->result; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>

        <?php   
        }
        if($m_index < count($results))
        {
        ?>
            <div class="container">
                <h1>Results from Movies</h1>

                <table class="table table-striped table-bordered
                              table-condensed">
                    <thead>
                        <tr>
                            <td><b>Title</b></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        for($x = $m_index; $x < count($results); $x++) {
                        ?>
                            <tr>
                                <td>
                                    <a href="<?php echo '/Database_Website/php/movie.php?q='.urlencode($results[$x]->id); ?>">
                                        <?php echo $results[$x]->result; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php  
        }
    }
        
    
}
*/

function get_person_results($search_term) {
    $results = array();
    
    $query = 'SELECT `P_ID` as id, `image`, `First`, `Middle`, `Last`, `AFirst`, `AMiddle`, `ALast`, `Nickname`, `DOB`, `Country_Of_Origin` 
              FROM person LEFT JOIN image ON person.I_ID = image.I_ID 
              WHERE `First` like :search or 
                    `Middle` like :search or
                    `Last` like :search or 
                    `AFirst` like :search or 
                    `AMiddle` like :search or 
                    `ALast` like :search or
                    `Nickname` like :search';
    $params = array(':search' => '%'.$search_term.'%');
    $query_result = db_query($query, $params);
    
    //var_dump($query_result);
    return $query_result;
    
}

function get_movie_results($search_term) {
    $query = 'SELECT `M_ID` as id, `image`, `Title`, `Country`, `Genre`, `Date`, `Parental Rating`, `Runtime`
              FROM movie LEFT JOIN image ON movie.I_ID = image.I_ID
              WHERE `Title` like :search';
    $params = array(':search' => '%'.$search_term.'%');
    $query_result = db_query($query, $params);
    
    //var_dump($query_result);
    return $query_result;
}

?>