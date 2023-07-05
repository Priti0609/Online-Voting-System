<?php
  $election_id = $_GET['viewResults'];
 ?>
  <div class="row">
      <div class="col-12 my-3">
         <h3>Voters Panel</h3>
         <?php
         
            $fetchingactiveelections = mysqli_query($db,"SELECT *FROM election WHERE status='active'");

            $total_active_elections=mysqli_num_rows($fetchingactiveelections);

            if($total_active_elections != 0)
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
                               <th> Result </th>

                          </tr>
                    </thead>
                    <tbody>
                        <?php
                            $fetching_vote_candidates = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id ='".$election_id."'");
                            $max_votes = 0;

                            while($candidate_voteData = mysqli_fetch_assoc($fetching_vote_candidates))
                            {
                                $candidate_vote_id =  $candidate_voteData['id'];
                                $fetchingCandidatevotes= mysqli_query($db,"SELECT * FROM votings WHERE candidate_id = '".$candidate_vote_id."' ") or die(mysqli_error($db));
                                $totalCandidatevotes=mysqli_num_rows($fetchingCandidatevotes);
                                
                                if($totalCandidatevotes > $max_votes)
                                {
                                    $max_votes = $totalCandidatevotes;
                                    $winner_id = $candidate_vote_id;
                                }


                            }
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
                                <?php
                                  if($candidate_id == $winner_id)
                                  {
                                ?>
                                <td><b>WINNER<b></td> 
                                <?php
                                  }
                                  else
                                  {
                                    ?>
                                <td><b>Better Luck Next Time!<b></td> 
                                <?php

                                  }
                                
                        
                                
                                ?>   
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
                echo "This election is currently inactive!";
            }
         ?>
          
      </div>
      
</div>