<?php 
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");
    include($_PHP."search_function.php");
    require_once($_INCLUDES."footer.php");

?>

<div class="container">
    <?php display_results(); ?>
</div>
    

<?php
    require_once($_INCLUDES."footer.php");
?>