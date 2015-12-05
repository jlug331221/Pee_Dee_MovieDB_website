<?php 
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");
?>

<div class="container">
    <h1>Here are some great movies</h1>
    <h1>It is a shame that all of them do not have Arnold!</h1>
    <table class="table table-striped table-bordered
                  table-condensed">
        <thead>
            <tr>
                <td><b>Title</b></td>
                <td><b>Year</b></td>
            </tr>
        </thead>
        <tbody>
        <?php 
            $movies = get_movies(); 
            foreach($movies as $movie) {
            ?>
                <tr>
                    <td><?php echo $movie["Title"];?></td>
                    <td><?php echo substr($movie["Date"], 0, 4);?></td>
                </tr>
            <?php
            }
        ?>
        </tbody>
    </table>
</div>
    
<?php 
    include($_INCLUDES."footer.php"); 
?>