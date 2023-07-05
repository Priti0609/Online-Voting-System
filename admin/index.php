<?php
 require_once("inc/header.php");
 require_once("inc/navigation.php");

 if(isset($_GET['homepage']))
 {
    require_once("inc/home_page.php");
 }

  else if(isset($_GET['addelection']))
 {
    require_once("inc/add_election.php");
 }

 else if(isset($_GET['addcandidate']))
 {
    require_once("inc/add_candidate.php");
 }
 else if(isset($_GET['viewResults']))
 {
    require_once("inc/viewResults.php");
 }
 else if(isset($_GET['edit']))
 {
    require_once("inc/edit.php");
 }
 else if(isset($_GET['editCandidate']))
 {
    require_once("inc/edit_candidate.php");
 }
?>

<?php
 require_once("inc/footer.php");
?>