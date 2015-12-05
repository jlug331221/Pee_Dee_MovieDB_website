<?php

if (isset($_POST['submit'])) {
    $search = $_POST['search-term'];
    header('Location: /Database_Website/php/search.php?q='.urlencode($search));
}

?>

<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>  
                </button>
                <a class="navbar-brand" href="/index.php">Pee Dee's MovieDB</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="link6" href="/Database_Website/php/user_profile.php">My User Page</a>
                    </li>
                    <li>
                        <a class="link4" href="/Database_Website/php/advanced_search.php">Adv Search</a>
                    </li>
                </ul>
                
                <div class="col-sm-3 col-md-3">
                    <form class="navbar-form" role="search" method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control searchBar" autofocus="autofocus" placeholder="Search" name="search-term" id="search-term">
                            <div class="input-group-btn">
                                <button class="btn btn-default" name="submit" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="rightLink1" href="/Database_Website/php/logout.php" >Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    