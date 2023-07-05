<?php
  $election_id = $_GET['edit'];
 
 ?>
 <?php
   if(isset($_GET['edited']))
    {
  ?>
        <div class="alert alert-success my-3" role="alert">
        Election has been edited successfully!
       </div>
<?php
    }
 ?>
<div class="row">
    <div class="col-4 my-3">
        <h3>Edit Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="election_method" placeholder="Election Topic" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="no_of_candidates" placeholder="Number of candidates" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='Date'" name="starting_date" placeholder="Starting date" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='Date'" name="ending_date" placeholder="Ending Date" class="form-control" required />
            </div>
            <input type="submit" name="edit_election_btn" value="submit" class="btn btn-success" />
        </form>
    </div>
</div>

<?php
 if(isset($_POST['edit_election_btn']))
 {
     $election_topic=$_POST['election_method'];
     $no_of_candidtes=$_POST['no_of_candidates'];
     $starting_date=$_POST['starting_date'];
     $ending_date=$_POST['ending_date'];
     $inserted_by=$_SESSION['username'];
     $inserted_on=date("Y-m-d");

    $date1=date_create($inserted_on);
    $date2=date_create($starting_date);
    $diff=date_diff($date1,$date2);
    
    if($diff->format("%R%a") > 0)
    {
        $status="Inactive";
    }
    else
    {
        $status="Active";
    }
     //insertion in db

 $query="UPDATE election  SET election_topic = '".$election_topic."', no_of_candidtes = '".$no_of_candidtes."', starting_date = '".$starting_date."', ending_date = '".$ending_date."',
 status = '".$status."', inserted_by = '".$inserted_by."', inserted_on = '".$inserted_on."' WHERE id='".$election_id."'";
 mysqli_query($db,$query) or die(mysqli_error($db));

 ?>
   <script>location.assign("index.php?edit&edited=1")</script>
 <?php
 }

 ?>

 


 