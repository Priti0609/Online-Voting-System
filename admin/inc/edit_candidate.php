<?php
 $candidate_id = $_GET['editCandidate'];
?>
<?php
   if(isset($_GET['editedCandidate']))
    {
  ?>
        <div class="alert alert-success my-3" role="alert">
        Candidate details has been edited successfully!
       </div>
<?php
    }
 ?>
<div class="row">
    <div class="col-6 my-3">
        <h3>Edit Candidate Details</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <select name="election_id" class="form-control"  required>
                <option value="">Select Election</option>
                <?php
                   $query="SELECT* FROM election";
                   $fetchingelections=mysqli_query($db,$query) or die(mysqli_error($db));
                   $iselection=mysqli_num_rows($fetchingelections);

                   if($iselection > 0)
                   {
                     while($row = mysqli_fetch_assoc($fetchingelections))
                     {
                        $election_id= $row['id'];
                        $election_name= $row['election_topic'];
                        $allowedcandidates= $row['no_of_candidtes'];

                        //check no of candidates

                        $fetchcandidate = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id ='".$election_id."'") or die(mysqli_error($db));

                        
                        $addedcandidates =mysqli_num_rows($fetchcandidate);

                        if($addedcandidates < $allowedcandidates)
                        {
                ?>
                <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
                <?php
                         }
                    }

                   }
                   else
                   {
                ?>
                    <option value="">Please add election first</option>
                <?php
                  
                   }

                ?>
            </select>
            </div>
            <div class="form-group">
                <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="file"  name="candidate_img" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text"  name="details" placeholder="Candidate Details" class="form-control" required />
            </div>
            <input type="submit" name="edit_candidate_btn" value="addCandidate" class="btn btn-success" />
        </form>
    </div>
</div>
<?php
 if(isset($_POST['edit_candidate_btn']))
 {
     $election_id=$_POST['election_id'];
     $candidate_name=$_POST['candidate_name'];
     $candidate_details=$_POST['details'];
     $inserted_by=$_SESSION['username'];
     $inserted_on=date("Y-m-d");

     $targetedfolder="../img/candidate_photos/";

     $candidate_photo=$targetedfolder . rand(11111111111,999999999999) ."_" . rand(11111111111,999999999999) . $_FILES['candidate_img']['name'];
     $candidate_photo_tmp_name= $_FILES['candidate_img']['tmp_name'];
     

 //insertion in db
     if(move_uploaded_file($candidate_photo_tmp_name,$candidate_photo))
     {
     $query="UPDATE candidate_details SET election_id = '".$election_id."', candidate_name = '".$candidate_name."', candidate_details = '".$candidate_details."', candidate_photo = '".$candidate_photo."',
      inserted_by = '".$inserted_by."', inserted_on = '".$inserted_on."' WHERE id='".$candidate_id."'";
     mysqli_query($db,$query) or die(mysqli_error($db));
    
      mysqli_query($db,$query) or die(mysqli_error($db));
     }

 ?>
      <script>location.assign("index.php?editCandidate&editedCandidate=1")</script>
 <?php
 }

 ?>
 


 
