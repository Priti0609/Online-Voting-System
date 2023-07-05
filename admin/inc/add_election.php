
<?php 
   if(isset($_GET['added']))
   {
 ?>
    <div class="alert alert-success my-3" role="alert">
     Election has been added successfully!
    </div>
 <?php
   }
   else if(isset($_GET['delete_id']))
   {
    mysqli_query($db,"DELETE FROM election WHERE id='".$_GET['delete_id']."'");
    ?>
    <div class="alert alert-danger my-3" role="alert">
     Election has been deleted successfully!
    </div>
 <?php
   }
  /* else if(isset($_GET['update_id']))
   {
    location.ass
   }*/
 ?>
<div class="row">
    <div class="col-4 my-3">
        <h3>Add Election</h3>
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
            <input type="submit" name="add_election_btn" value="submit" class="btn btn-success" />
        </form>
    </div>

  <div class="col-8">
        <h3>Upcoming Election</h3>
    <table class="table">
     <thead>
        <tr>
          <th scope="col mr-3">S_No</th>
          <th scope="col mr-3">Election Name</th>
          <th scope="col mr-3"># Candidates</th>
          <th scope="col mr-3">Starting Date</th>
          <th scope="col mr-3">Ending Date</th>
          <th scope="col mr-3">Status</th>
          <th scope="col mr-3">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
           $query="SELECT * FROM election";
           $fetchdata=mysqli_query($db,$query);
           $is_any_election = mysqli_num_rows($fetchdata);

           if($is_any_election)
           {
             $s_no=1;
             while($row = mysqli_fetch_assoc($fetchdata))
             {
              $election_id = $row['id'];
        ?>
              <tr>
                 <td><?php echo $s_no++;?> </td>
                 <td><?php echo $row['election_topic'];?> </td>
                 <td><?php echo $row['no_of_candidtes'];?> </td>
                 <td><?php echo $row['starting_date'];?> </td>
                 <td><?php echo $row['ending_date'];?> </td>
                 <td><?php echo $row['status'];?> </td>
                 <td>
                    
                    <a href="index.php?edit=<?php echo $election_id; ?>"  class="btn btn-sm btn-warning"> Edit  </a>
                    
                    <button  class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $election_id; ?>)"> Delete</button>
             </td>



             </tr>
        <?php
             }

           }
           else
           {
         ?>
             <tr>
                <td colspan="4"><b>Any election is not yet added</b> </td>
            </tr>
         <?php

           }

        ?>
        
    
       </tbody>
       
    </table>
   </div>

</div>
<script>

   const DeleteData = (e_id) =>
   {
     let c = confirm("Do you really want to delete");

     if(c == true)
     {
        location.assign("index.php?addelection=1&delete_id="+e_id);
     }
   }

  /* const UpdateData = (e_id) =>
   {
     let c = confirm("Do you really want to update your data");

     if(c == true)
     {
        location.assign("index.php?addelection=1&update_id="+e_id);
     }
   }*/
  </script>
<?php
 if(isset($_POST['add_election_btn']))
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

 $query="INSERT INTO election(election_topic,no_of_candidtes,starting_date,ending_date,status,inserted_by,inserted_on) VALUES('".$election_topic."',
 '".$no_of_candidtes."','".$starting_date."','".$ending_date."','".$status."','".$inserted_by."','".$inserted_on."') ";

 mysqli_query($db,$query) or die(mysqli_error($db));

 ?>
   <script>location.assign("index.php?addelection=1&added=1")</script>
 <?php
 }

 ?>