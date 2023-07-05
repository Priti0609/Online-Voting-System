<?php 
   if(isset($_GET['addedCandidate']))
   {
 ?>
    <div class="alert alert-success my-3" role="alert">
     Candidate has been added successfully!
    </div>
 <?php
   }
   else if(isset($_GET['delete_id']))
   {
    mysqli_query($db,"DELETE FROM candidate_details WHERE id = '".$_GET['delete_id']."' ");
   }
 ?>
 
<div class="row">
    <div class="col-4 my-3">
        <h3>Add New Candidate</h3>
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
            <input type="submit" name="add_candidate_btn" value="addCandidate" class="btn btn-success" />
        </form>
    </div>

  <div class="col-8">
        <h3>Candidate Details</h3>
    <table class="table">
     <thead>
        <tr>
          <th scope="col mr-3">S_No</th>
          <th scope="col mr-3">Photo</th>
          <th scope="col mr-3">Name</th>
          <th scope="col mr-3">Details</th>
          <th scope="col mr-3">Election</th>
          <th scope="col mr-3">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
           $query="SELECT * FROM candidate_details";
           $fetchdata=mysqli_query($db,$query);
           $is_any_candidate = mysqli_num_rows($fetchdata);

           if($is_any_candidate)
           {
             $s_no=1;
             while($row = mysqli_fetch_assoc($fetchdata))
             {
               $election_id=$row['election_id'];
               $fetchingelection=mysqli_query($db,"SELECT * FROM election where id= '".$election_id."' ") or die(mysqli_error($db));
               $fetchingelectioninassoc=mysqli_fetch_assoc($fetchingelection);
               $election_name= $fetchingelectioninassoc['election_topic'];

               $candidate_photo=$row['candidate_photo'];
               $candidate_id = $row['id'];
        ?>
              <tr>
                 <td><?php echo $s_no++;?> </td>
                 <td><img src="<?php echo $candidate_photo;?>" class="candidate-photo" /></td>
                 <td><?php echo $row['candidate_name'];?> </td>
                 <td><?php echo $row['candidate_details'];?> </td>
                 <td><?php echo $election_name;?> </td>
                 
                 <td>
                    <a href="index.php?editCandidate=<?php echo $candidate_id; ?>"  class="btn btn-sm btn-warning"> Edit </a>
                    <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $candidate_id; ?>)"> Delete</button>
             </td>



             </tr>
        <?php
             }

           }
           else
           {
         ?>
             <tr>
                <td colspan="4"><b>Any candidate is not yet added</b> </td>
            </tr>
         <?php

           }

        ?>
        
    
       </tbody>
       
    </table>
   </div>

</div>
<script>
    const DeleteData = (c_id) =>
   {
     let c = confirm("Do you really want to delete");

     if(c == true)
     {
        location.assign("index.php?addcandidate=1&delete_id="+c_id);
     }
   }
  </script>
<?php
 if(isset($_POST['add_candidate_btn']))
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
     $query="INSERT INTO candidate_details(election_id,candidate_name,candidate_details,candidate_photo,inserted_by,inserted_on) VALUES('".$election_id."',
    '".$candidate_name."','".$candidate_details."','".$candidate_photo."','".$inserted_by."','".$inserted_on."') ";

      mysqli_query($db,$query) or die(mysqli_error($db));
     }

 ?>
      <script>location.assign("index.php?addcandidate=1&addedCandidate=1")</script>
 <?php
 }

 ?>