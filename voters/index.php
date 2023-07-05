<?php
 require_once("inc/header.php");
 
 require_once("inc/navigation.php");
 ?>
  <div class="row">
      <div class="col-12 my-3">
         <h3>Voters Panel</h3>
         <?php
            $fetchingactiveelections = mysqli_query($db,"SELECT *FROM election WHERE status='active'");
            $total_active_elections=mysqli_num_rows($fetchingactiveelections);

            if($total_active_elections > 0)
            {
                 while($data = mysqli_fetch_assoc($fetchingactiveelections))
                  {
                    $election_id = $data['id'];
                    $election_topic = $data['election_topic'];
                ?>

                    <table class="table">
                    <thead>
                          <tr>
                              <th colspan="4" class="bg-green text-white"><h5> ELECTION TOPIC:
                                <?php echo strtoupper($election_topic); ?> </h5></th>
                          </tr>
                           <tr>
                               <th> Photo </th>
                               <th> Candidate Details </th>
                               <th> # of votes </th>
                               <th> Action </th>
                          </tr>
                    </thead>
                    <tbody>
                        <?php
                            $fetchingcandidates = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id ='".$election_id."'");

                            while($candidatedata = mysqli_fetch_assoc($fetchingcandidates))
                            {
                                  $candidate_id = $candidatedata['id'];
                                  $candidate_photo = $candidatedata['candidate_photo'];

                                  //fetching candidate votes

                                  $fetchingvotes= mysqli_query($db,"SELECT * FROM votings WHERE candidate_id = '".$candidate_id."' ") or die(mysqli_error($db));
                                  $totalvotes=mysqli_num_rows($fetchingvotes);
                                
                        ?>
                            <tr>
                                <td> <img src="<?php echo $candidate_photo; ?>" class="candidate-photo"></td>
                                <td><?php echo "<b>" . $candidatedata['candidate_name']. "</b><br />" . $candidatedata['candidate_details']?></td>
                                <td><?php echo $totalvotes; ?></td>
                                <td>
                                
                                    <?php
                                    $checkifvoted = mysqli_query($db,"SELECT * FROM votings WHERE voters_id = '".$_SESSION['user_id']."' AND election_id = '". $election_id ."'");
                                    $is_vote_casted = mysqli_num_rows($checkifvoted);
                                    if($is_vote_casted > 0)
                                    {
                                        $voteCastedData = mysqli_fetch_assoc($checkifvoted);
                                        $voteCastedCandidate= $voteCastedData['candidate_id'];

                                        if($voteCastedCandidate == $candidate_id)
                                        {
                                    ?>
                                         <img src="../img/logo.png" width="100px";
                                    <?php
                                        }

                                  

                                    }
                                    else
                                    {
                                   ?>
                                   
                                       <button class="btn btn-success" onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?> , <?php echo $_SESSION['user_id']; ?>)"> Vote </button> 
                                 
                                    <?php    
                                    }
                                    ?>
                                </td>
                                

                                
                                   
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
               </table>
                <?php

                  }
                ?>
               
           <?php

            }
            else
            {
                echo "No active elections available";
            }
         ?>
          
      </div>
      
</div>
 <script> 
    const CastVote = (election_id,customer_id,voters_id) =>
    {
        $.ajax({
            type: "POST",
            url:  "inc/ajaxcall.php",
            data: "e_id=" + election_id + "&c_id=" + customer_id + "&v_id=" + voters_id,
            success: function(response){
                if (response == "Success")
                 {
                    location.assign("index.php?voteCasted=1");
                 }
                 else{
                    location.assign("index.php?votenotCasted=1");

                 }
            }

        });
    }
 </script>

 <?php
 require_once("inc/footer.php");
?>