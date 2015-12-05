<?php 
    include("../_include/header.php");
    include($_INCLUDES."navbar.php");

    $personID = $_GET['q'];
?>

<div class = "container">
    <h1>Edit a Person</h1>
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="/Database_Website/php/edit_person_bio.php"><h4>Edit Person Bio</h4></a>
            <a href="/Database_Website/php/edit_person_addRole.php?q=<?php echo $personID; ?>&f=<?php echo $_GET['f']; ?>&l=<?php echo $_GET['l']; ?>"><h4>Add Role for Person</h4></a>
        </div>
    </div>
</div>  

    
<?php 
    include($_INCLUDES."footer.php"); 
?>